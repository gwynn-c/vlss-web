<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('home', [
            'hero'     => config('content.hero'),
            'games'    => config('content.games'),
            'services' => config('content.services'),
            'pillars'  => config('content.pillars'),
            'team'     => config('content.team'),
            'quotes'   => config('content.quotes'),
            'roles'    => config('content.roles'),
        ]);
    }
}
