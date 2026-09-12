<?php

/*
|--------------------------------------------------------------------------
| Page content (placeholders)
|--------------------------------------------------------------------------
|
| Everything the landing page renders lives here so you can swap real copy,
| games, team members and roles without touching Blade or controllers.
| Images: drop files in /public/img and reference them as 'img/your-file.png'
| (leave 'image' as null to show the styled placeholder box).
|
*/

return [

    'hero' => [
        'eyebrow' => 'Game design & development studio',
        'title_lines' => ['We make games.', 'Some of them', 'are even fun.'],
        'title_accent' => 'are even fun.', // which line gets the orange treatment
        'body' => "From the first scribbled mechanic to the build you can actually put "
            . "in someone's hands. Original projects, co-development, and proof of "
            . "concepts that answer the only question that matters early: is this fun yet?",
        'stats' => [
            ['value' => '6+',    'label' => 'Projects shipped'],
            ['value' => '3 wks', 'label' => 'To a playable proto'],
            ['value' => '1',     'label' => 'Cat with a sword'],
        ],
    ],

    // status keys map to a colour treatment: in_dev | released | prototype
    'games' => [
        [
            'title' => 'Placeholder Title I',
            'blurb' => 'One-line hook for the flagship — genre, the twist, why anyone would play a second run.',
            'status' => 'in_dev',
            'status_label' => 'In development',
            'meta' => 'PC · Card battler',
            'link_label' => 'Steam page',
            'href' => '#',
            'image' => null,
            'image_hint' => 'Drop key art (16:10)',
        ],
        [
            'title' => 'Placeholder Title II',
            'blurb' => 'Co-development with a partner studio. One line on the scope you handled.',
            'status' => 'released',
            'status_label' => 'Released',
            'meta' => 'PC · Console',
            'link_label' => 'Visit site',
            'href' => '#',
            'image' => null,
            'image_hint' => 'Drop a screenshot',
        ],
        [
            'title' => 'Placeholder Title III',
            'blurb' => 'Proof of concept built in three weeks to test one mechanic. Source is public.',
            'status' => 'prototype',
            'status_label' => 'Prototype',
            'meta' => 'Web · Jam build',
            'link_label' => 'GitHub',
            'href' => '#',
            'image' => null,
            'image_hint' => 'Drop a GIF or still',
        ],
    ],

    'services' => [
        ['num' => '01', 'title' => 'Full-cycle game development', 'body' => 'Design, art direction, engineering, release. One team from pitch deck to store page.'],
        ['num' => '02', 'title' => 'Co-development', 'body' => 'Drop us into your project to own a system, a platform port, or the content push before a milestone.'],
        ['num' => '03', 'title' => 'Proof of concept', 'body' => 'Three weeks, one playable build, one honest verdict on whether the core is worth funding.'],
        ['num' => '04', 'title' => 'Systems & economy design', 'body' => 'Card builders, loops, progression, meta. Spreadsheets first, then the fun part.'],
        ['num' => '05', 'title' => 'Playtesting & production rescue', 'body' => 'For projects that stopped being fun somewhere and need someone to find where.'],
    ],

    'pillars' => [
        ['title' => 'Prototype-first', 'body' => 'Playable in weeks, not quarters.',   'color' => 'orange'],
        ['title' => 'Systems people',  'body' => 'Cards, loops, economies, meta.',      'color' => 'purple'],
        ['title' => 'Straight answers','body' => "If it isn't fun yet, we'll say so.",  'color' => 'teal'],
        ['title' => 'Full pipeline',   'body' => 'Design, art, code, release.',         'color' => 'ink'],
    ],

    'team' => [
        ['name' => 'Team Member', 'role' => 'Founder / design', 'note' => 'One line of deadpan bio.', 'image' => null, 'image_hint' => 'Drop a portrait'],
        ['name' => 'Team Member', 'role' => 'Engineering',      'note' => 'One line of deadpan bio.', 'image' => null, 'image_hint' => 'Drop a portrait'],
        ['name' => 'Team Member', 'role' => 'Art direction',    'note' => 'One line of deadpan bio.', 'image' => null, 'image_hint' => 'Drop a portrait'],
        ['name' => 'Team Member', 'role' => 'Production',        'note' => 'One line of deadpan bio.', 'image' => null, 'image_hint' => 'Drop a portrait'],
    ],

    'quotes' => [
        ['text' => 'Placeholder testimonial. They found the fun in our prototype in two weeks, then told us which half to delete.', 'who' => 'Partner name', 'where' => 'Studio / publisher'],
        ['text' => 'Placeholder testimonial. Shipped on the milestone date, which in this industry counts as a magic trick.',      'who' => 'Partner name', 'where' => 'Studio / publisher'],
        ['text' => 'Placeholder testimonial. The only contractors who told us our design was broken before we paid for it.',        'who' => 'Partner name', 'where' => 'Studio / publisher'],
    ],

    'roles' => [
        ['title' => 'Gameplay Engineer',            'detail' => 'Unity / C# · Remote · Contract or full-time'],
        ['title' => '2D Artist — characters & UI',  'detail' => 'Stylised, hand-drawn · Remote · Contract'],
        ['title' => 'Game Designer (systems)',      'detail' => 'Card games, economies · Remote · Full-time'],
    ],
];
