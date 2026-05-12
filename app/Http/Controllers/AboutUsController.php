<?php

namespace App\Http\Controllers;

class AboutUsController extends Controller
{
    public function index()
    {
        $persons = [
            [
                'name' => 'Ahmad Hasnain Fazili',
                'title' => 'Technical Lead',
                'tagLine' => 'If we hard, we hard!',
                'picture' => 'VLSS ICON.jpg',
                'profileLink'=> '#',
                'favouriteGames'=> 'Baldurs Gate3, Hades and Skyrim',
            ],

            [
                'name' => 'Aman bin Khalid',
                'title' => 'Creative Lead',
                'tagLine' => 'Apko phit pta czn!',
                'picture' => 'VLSS ICON.jpg',
                'profileLink'=> '#',
                'favouriteGames'=> 'CS:2 and FIFA',
            ],

            [
                'name' => 'Samia Afzal',
                'title' => 'Art Director',
                'tagLine' => 'Ish sho nummy',
                'picture' => 'VLSS ICON.jpg',
                'profileLink'=> '#',
                'favouriteGames'=> 'Marvel Rivals and Jak and Dexter',
            ],

            [
                'name' => 'Zubair Ali',
                'title' => 'Lead Game Designer',
                'tagLine' => 'Off!',
                'picture' => 'VLSS ICON.jpg',
                'profileLink'=> '#',
                'favouriteGames'=> 'Counter Strike, DoTA and Tiny Glade',
            ],

        ];

        return view('about', ['persons' => $persons]);
    }
}
