<?php

/*
|--------------------------------------------------------------------------
| Admin panel section schema
|--------------------------------------------------------------------------
|
| Drives the generic CRUD screens. Each "list" section is an ordered list of
| items with the given fields; the admin can add, edit, reorder and delete
| them. Field types: text, textarea, url, select, image.
|
*/

return [

    'sections' => [

        'games' => [
            'label'    => 'Projects / Games',
            'singular' => 'Project',
            'icon'     => '🎮',
            'blurb'    => 'The showcase cards. Add key art, links and status for each project.',
            'fields'   => [
                'title'      => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'blurb'      => ['label' => 'Blurb', 'type' => 'textarea'],
                'status'     => ['label' => 'Status', 'type' => 'select', 'options' => [
                    'in_dev'    => 'In development',
                    'released'  => 'Released',
                    'prototype' => 'Prototype',
                ], 'sets_label' => 'status_label'],
                'meta'       => ['label' => 'Meta (e.g. "PC · Card battler")', 'type' => 'text'],
                'link_label' => ['label' => 'Link label', 'type' => 'text'],
                'href'       => ['label' => 'Link URL', 'type' => 'url'],
                'image'      => ['label' => 'Key art', 'type' => 'image'],
                'image_hint' => ['label' => 'Placeholder hint (shown when no image)', 'type' => 'text'],
            ],
        ],

        'team' => [
            'label'    => 'Team members',
            'singular' => 'Team member',
            'icon'     => '🧑',
            'blurb'    => 'The people grid in the Studio section.',
            'fields'   => [
                'name'       => ['label' => 'Name', 'type' => 'text', 'required' => true],
                'role'       => ['label' => 'Role', 'type' => 'text'],
                'note'       => ['label' => 'Short bio', 'type' => 'textarea'],
                'image'      => ['label' => 'Portrait', 'type' => 'image'],
                'image_hint' => ['label' => 'Placeholder hint', 'type' => 'text'],
            ],
        ],

        'quotes' => [
            'label'    => 'Testimonials',
            'singular' => 'Testimonial',
            'icon'     => '❝',
            'blurb'    => 'Partner quotes in the Studio section.',
            'fields'   => [
                'text'  => ['label' => 'Quote', 'type' => 'textarea', 'required' => true],
                'who'   => ['label' => 'Who said it', 'type' => 'text'],
                'where' => ['label' => 'Studio / publisher', 'type' => 'text'],
            ],
        ],

        'services' => [
            'label'    => 'Services',
            'singular' => 'Service',
            'icon'     => '🛠',
            'blurb'    => 'The numbered "What you can hand us" list. Numbers renumber automatically.',
            'fields'   => [
                'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'body'  => ['label' => 'Description', 'type' => 'textarea'],
            ],
            'auto_number' => 'num', // field filled with 01, 02, … on save
        ],

        'pillars' => [
            'label'    => 'Studio pillars',
            'singular' => 'Pillar',
            'icon'     => '🏛',
            'blurb'    => 'The small value props beside the studio copy.',
            'fields'   => [
                'title' => ['label' => 'Title', 'type' => 'text', 'required' => true],
                'body'  => ['label' => 'Body', 'type' => 'text'],
                'color' => ['label' => 'Colour', 'type' => 'select', 'options' => [
                    'orange' => 'Orange',
                    'purple' => 'Purple',
                    'teal'   => 'Teal',
                    'ink'    => 'Ink',
                ]],
            ],
        ],

        'roles' => [
            'label'    => 'Open roles',
            'singular' => 'Role',
            'icon'     => '💼',
            'blurb'    => 'Careers listings.',
            'fields'   => [
                'title'  => ['label' => 'Role title', 'type' => 'text', 'required' => true],
                'detail' => ['label' => 'Detail (stack · location · type)', 'type' => 'text'],
            ],
        ],

    ],

];
