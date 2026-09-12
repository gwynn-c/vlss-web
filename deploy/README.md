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

## One-time hook install

From the server, after the first checkout exists:

```bash
cp ~/web/vlss-web/deploy/post-receive ~/web/vlss-web.git/hooks/post-receive
chmod +x ~/web/vlss-web.git/hooks/post-receive
```

If the work tree doesn't exist yet, run `bash ~/deploy.sh` once (the manual path),
then install the hook. After that the hook **self-updates** from
`deploy/post-receive` on every deploy.

## Deploying

Add the remote once on your machine:

```bash
git remote add production <user>@verylongswordstudio.com:web/vlss-web.git
```

Then deploy by pushing `main`:

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
