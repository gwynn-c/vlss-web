#!/bin/bash
# Very Longsword Studio — production deploy (uses the existing git-checkout system).
# Run on the server as vlsssftp1:   bash ~/deploy.sh
set -euo pipefail

GITDIR="$HOME/web/vlss-web.git"
WORK="$HOME/web/vlss-web"
DOCROOT="$HOME/web"
BUNDLE="$HOME/vlss-deploy.bundle"
STAMP="$(date +%Y%m%d-%H%M%S)"

echo "==> VLSS deploy ($STAMP)"
[ -f "$BUNDLE" ] || { echo "!! $BUNDLE not found — re-upload it and retry"; exit 1; }

echo "==> current deployed main: $(git --git-dir="$GITDIR" rev-parse main 2>/dev/null || echo none)"
echo "    (save this SHA if you ever want to roll back)"

# 1) Import the release and check it out (identical to the post-receive hook)
git --git-dir="$GITDIR" fetch "$BUNDLE" +main:main
echo "==> new main: $(git --git-dir="$GITDIR" rev-parse main)"
mkdir -p "$WORK"
git --work-tree="$WORK" --git-dir="$GITDIR" checkout -f main

cd "$WORK"

# 2) Environment (reuses the existing production APP_KEY)
if [ ! -f .env ]; then
  cp "$HOME/vlss.env.production" .env
  echo "==> installed .env"
else
  echo "==> .env already present — leaving it untouched"
fi

# 3) PHP dependencies + Laravel setup
export COMPOSER_ALLOW_SUPERUSER=1
echo "==> composer install"
composer install --no-dev --optimize-autoloader --no-interaction

mkdir -p database
[ -f database/database.sqlite ] || touch database/database.sqlite

echo "==> migrate"
php artisan migrate --force
php artisan storage:link 2>/dev/null || true

echo "==> cache config/routes/views"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> fix writable dirs"
chmod -R ug+rwX storage bootstrap/cache

# 4) Point the docroot at the app's public/ (backs up what it replaces)
echo "==> docroot routing"
[ -f "$DOCROOT/.htaccess" ] && cp "$DOCROOT/.htaccess" "$DOCROOT/.htaccess.bak-$STAMP" || true
cat > "$DOCROOT/.htaccess" <<'HTACCESS'
# Serve the Laravel app that deploys into ./vlss-web
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/vlss-web/public/
    RewriteRule ^(.*)$ /vlss-web/public/$1 [L]
</IfModule>
HTACCESS

# Stop the placeholder index.html from shadowing "/"
if [ -f "$DOCROOT/index.html" ]; then
  mv "$DOCROOT/index.html" "$DOCROOT/index.html.disabled-$STAMP"
  echo "==> disabled placeholder index.html"
fi

# 5) Verify locally
echo "==> verify (local curl):"
curl -sS -I -H "Host: verylongswordstudio.com" http://127.0.0.1/ 2>/dev/null | head -6 || true
echo
echo "==> looking for site content:"
curl -sS -H "Host: verylongswordstudio.com" http://127.0.0.1/ 2>/dev/null | grep -o -m1 "WE MAKE GAMES" || echo "(content marker not found via local curl — check in a browser)"

echo "==> DONE. Visit https://verylongswordstudio.com/"
