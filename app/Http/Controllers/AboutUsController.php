<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $persons = [
            [
                "name"=> "Ahmad Hasnain Fazili",
                "title" =>'Lead Developer',
                'tagLine' =>'If we hard, we hard!',
                'picture'=>'VLSS ICON.jpg'
            ],
            
            [
                "name"=> "Aman bin Khalid",
                "title" =>'CFO and Jrafic designer',
                'tagLine' =>'Apko phit pta czn!',
                'picture'=>'VLSS ICON.jpg'
            ],
        
            [
                "name"=> "Samia Afzal",
                "title" =>'The heart',
                'tagLine' =>'Ish sho nummy',
                'picture'=>'VLSS ICON.jpg'
                ],
            [
                "name"=> "Zubair Ali",
                "title" =>'Awazar tareen',
                'tagLine' =>'Off!',
                'picture'=>'VLSS ICON.jpg'
            ]

        ];

        return view("about", ['persons'=>$persons]);
    }
}
