# Deployment

Very Longsword Studio deploys via a **bare git repo + `post-receive` hook** on the
server. Once installed, `git push production main` fully deploys the app.

## Server layout

| Path | What it is |
| --- | --- |
| `~/web/vlss-web.git` | bare repo you push to |
| `~/web/vlss-web` | checked-out work tree (the Laravel app) |
| `~/web` | Apache docroot (rewrites into `vlss-web/public`) |
| `~/vlss.env.production` | the production `.env` (holds `APP_KEY`; **never committed**) |

## First-time bootstrap (from scratch — no work tree, no deploy.sh needed)

The hook creates the work tree and runs the whole release itself, so the only
setup is getting the hook file in place. Do this once.

**1. On your machine**, point a remote at the server's bare repo and push `main`:

```bash
# create the bare repo first if it doesn't exist:
#   ssh <user>@verylongswordstudio.com 'git init --bare ~/web/vlss-web.git'
git remote add production <user>@verylongswordstudio.com:web/vlss-web.git
git push production main
```

This push just stores the objects — nothing deploys yet, because the hook isn't
installed. That's expected.

**2. On the server**, install the hook by extracting it from the objects you just
pushed (works with no checkout present), then trigger the first deploy:

```bash
git --git-dir=~/web/vlss-web.git show main:deploy/post-receive \
    > ~/web/vlss-web.git/hooks/post-receive
chmod +x ~/web/vlss-web.git/hooks/post-receive

# fire it once manually (feed it the ref on stdin):
NEW=$(git --git-dir=~/web/vlss-web.git rev-parse main)
echo "0000000000000000000000000000000000000000 $NEW refs/heads/main" \
    | ~/web/vlss-web.git/hooks/post-receive
```

That first run does the full deploy. From here on the hook **self-updates** from
`deploy/post-receive` on every release, so you never touch it again.

## Deploying (after bootstrap)

```bash
git push production main
```

The hook runs: checkout → `composer install --no-dev` → `migrate --force` →
admin bootstrap (optional) → `config:cache` / `route:cache` / `view:cache` →
docroot wiring. Only pushes to `main` deploy; other branches are ignored.

## Admin account

The content panel needs an admin user. Either:

- **Auto-provision:** add these to `~/vlss.env.production` (the hook reads them and
  upserts on each deploy — safe to re-run, handy for password resets):

  ```env
  ADMIN_NAME="Admin"
  ADMIN_EMAIL="you@example.com"
  ADMIN_PASSWORD="a-strong-password"
  ```

- **Or by hand**, once, on the server:

  ```bash
  cd ~/web/vlss-web && php artisan admin:create
  ```

## Rollback

The hook prints the deployed SHA each run. To roll back:

```bash
git --git-dir=~/web/vlss-web.git --work-tree=~/web/vlss-web checkout -f <old-sha>
cd ~/web/vlss-web && composer install --no-dev -o && php artisan migrate --force \
  && php artisan config:cache && php artisan route:cache && php artisan view:cache
```
