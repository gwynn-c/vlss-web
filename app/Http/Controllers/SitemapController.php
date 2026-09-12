<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * A small XML sitemap of the public pages.
     */
    public function index(): Response
    {
        $pages = [
            ['loc' => route('home'),    'changefreq' => 'weekly',  'priority' => '1.0'],
            ['loc' => route('privacy'), 'changefreq' => 'yearly',  'priority' => '0.3'],
        ];

        $xml = view('sitemap', ['pages' => $pages])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
