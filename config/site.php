<?php

/*
|--------------------------------------------------------------------------
| Site / brand configuration
|--------------------------------------------------------------------------
|
| Central place for Very Longsword Studio's public details. Update these
| values (or the matching keys in your .env) rather than editing the views.
|
*/

return [

    // Where the contact form emails are delivered.
    'contact_email' => env('SITE_CONTACT_EMAIL', 'dev.vlss@proton.me'),

    // Date shown on the privacy policy page (Y-m-d).
    'privacy_updated' => '2026-09-12',

    // Studio meta used in the footer, <head>, and structured data.
    'name'        => 'Very Longsword Studio',
    'tagline'     => 'Game design & development studio',
    'description' => 'Very Longsword Studio designs and builds games — from the first '
        . 'scribbled mechanic to the build you can actually put in someone\'s hands. '
        . 'Original projects, co-development, and fast proof of concepts.',

    // Social / external links. Empty string = the button is hidden.
    'socials' => [
        'discord' => env('SITE_DISCORD', '#'),
        'bluesky' => env('SITE_BLUESKY', '#'),
        'youtube' => env('SITE_YOUTUBE', '#'),
        'itch'    => env('SITE_ITCH', '#'),
    ],

];
