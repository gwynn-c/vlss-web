# Very Longsword Studio — website

Marketing site for **Very Longsword Studio** (verylongswordstudio.com), a game
design & development studio. Built with **Laravel** and served locally with
**Laravel Herd**.

## Stack

- Laravel 13 (PHP 8.4)
- Blade templates, hand-written CSS (no build step required)
- SQLite in local dev
- Type: **Super Mabroz** (display / headings, self-hosted) + **Chivo** (body, Google Fonts)

## Running locally

Requires [Laravel Herd](https://herd.laravel.com/windows) (bundles PHP + Composer).

```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve        # http://127.0.0.1:8000
```

With Herd, you can also just park the folder and visit `http://vlss-web.test`.

## Where to edit things

| What | Where |
| --- | --- |
| Games, services, team, testimonials, roles, hero copy | `config/content.php` |
| Contact email, studio name, social links | `config/site.php` (or the matching `.env` keys) |
| Layout / `<head>` | `resources/views/layouts/app.blade.php` |
| Page sections | `resources/views/sections/*.blade.php` |
| Styles | `public/css/app.css` |
| Brand assets (mascot, logo, fonts, favicons) | `public/img`, `public/fonts` |

To add a real image, drop the file in `public/img/` and set the matching
`image` value in `config/content.php` (e.g. `'image' => 'img/my-game.png'`).

## Contact form

`POST /contact` validates, stores the submission in the `contact_submissions`
table, and emails it to `SITE_CONTACT_EMAIL` (default `dev.vlss@proton.me`).
In local dev `MAIL_MAILER=log` writes the email to `storage/logs/laravel.log`
instead of sending it — set real mail credentials in `.env` for production.

A honeypot field (`website`) blocks basic spam bots.
