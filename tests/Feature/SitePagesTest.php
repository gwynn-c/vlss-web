<?php

namespace Tests\Feature;

use App\Models\ContentSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_section_pages_render_with_unique_headings(): void
    {
        $this->get('/team')->assertOk()->assertSee('The people');
        $this->get('/games')->assertOk()->assertSee('The showcase');
        $this->get('/services')->assertOk()->assertSee('What you can');
        $this->get('/studio')->assertOk()->assertSee('A small studio');
        $this->get('/careers')->assertOk()->assertSee('Open roles');
        $this->get('/contact')->assertOk()->assertSee('Tell us what');
    }

    public function test_home_page_is_hero_only(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('We make games.')
            ->assertDontSee('The showcase')
            ->assertDontSee('What you can');
    }

    public function test_team_page_groups_members_by_department(): void
    {
        ContentSetting::create([
            'key' => 'team',
            'value' => [
                ['name' => 'Ada Appleseed', 'department' => 'engineering'],
                ['name' => 'Grace Blade',   'department' => 'design'],
            ],
        ]);

        $this->get('/team')
            ->assertOk()
            ->assertSee('Engineering')
            ->assertSee('Art')
            ->assertSee('Design')
            ->assertSee('Ada Appleseed')
            ->assertSee('Grace Blade')
            ->assertDontSee('Nobody');
    }
}
