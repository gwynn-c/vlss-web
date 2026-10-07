<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('home', [
            'hero' => config('content.hero'),
        ]);
    }

    public function games()
    {
        return view('games', [
            'games' => config('content.games'),
        ]);
    }

    public function services()
    {
        return view('services', [
            'services' => config('content.services'),
        ]);
    }

    public function studio()
    {
        return view('studio', [
            'pillars' => config('content.pillars'),
            'quotes' => config('content.quotes'),
        ]);
    }

    public function team()
    {
        return view('team', [
            'team' => config('content.team'),
        ]);
    }

    public function careers()
    {
        return view('careers', [
            'roles' => config('content.roles'),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function privacy()
    {
        return view('privacy');
    }
}
