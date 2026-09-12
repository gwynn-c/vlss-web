<?php

namespace Tests\Feature;

use App\Models\ContentSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/sections/games')->assertRedirect('/admin/login');
    }

    public function test_admin_can_create_a_project_with_an_image(): void
    {
        $file = UploadedFile::fake()->image('keyart.png', 800, 500);

        $response = $this->actingAs($this->admin())->post('/admin/sections/games', [
            'title'      => 'New Game',
            'blurb'      => 'A test project.',
            'status'     => 'released',
            'meta'       => 'PC',
            'link_label' => 'Steam',
            'href'       => 'https://example.com',
            'image'      => $file,
        ]);

        $response->assertRedirect('/admin/sections/games');

        $games = ContentSetting::where('key', 'games')->first()->value;
        $new   = collect($games)->firstWhere('title', 'New Game');

        $this->assertNotNull($new);
        $this->assertSame('Released', $new['status_label']); // select drove the label
        $this->assertStringStartsWith('img/uploads/', $new['image']);
        $this->assertFileExists(public_path($new['image']));

        // The public homepage reflects the new project.
        $this->get('/')->assertOk()->assertSee('New Game');

        // Clean up the file this test wrote into public/.
        @unlink(public_path($new['image']));
    }

    public function test_admin_can_remove_a_project_image(): void
    {
        $admin = $this->admin();
        $file  = UploadedFile::fake()->image('art.png');

        $this->actingAs($admin)->post('/admin/sections/games', [
            'title' => 'Has Image',
            'image' => $file,
        ]);

        $item = collect(ContentSetting::where('key', 'games')->first()->value)
            ->firstWhere('title', 'Has Image');
        $path = public_path($item['image']);
        $this->assertFileExists($path);

        $this->actingAs($admin)->put("/admin/sections/games/{$item['id']}", [
            'title'          => 'Has Image',
            'remove_image'   => '1',
        ])->assertRedirect('/admin/sections/games');

        $updated = collect(ContentSetting::where('key', 'games')->first()->value)
            ->firstWhere('id', $item['id']);

        $this->assertNull($updated['image']);
        $this->assertFileDoesNotExist($path);
    }

    public function test_admin_can_delete_a_project(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/sections/games', ['title' => 'Doomed']);
        $item = collect(ContentSetting::where('key', 'games')->first()->value)
            ->firstWhere('title', 'Doomed');

        $this->actingAs($admin)->delete("/admin/sections/games/{$item['id']}")
            ->assertRedirect('/admin/sections/games');

        $titles = collect(ContentSetting::where('key', 'games')->first()->value)->pluck('title');
        $this->assertFalse($titles->contains('Doomed'));
    }

    public function test_services_are_auto_numbered(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post('/admin/sections/services', ['title' => 'Extra service']);

        $services = ContentSetting::where('key', 'services')->first()->value;
        $nums = collect($services)->pluck('num')->all();

        $this->assertSame('01', $nums[0]);
        $this->assertSame(str_pad((string) count($services), 2, '0', STR_PAD_LEFT), end($nums));
    }

    public function test_admin_can_update_the_hero(): void
    {
        $this->actingAs($this->admin())->put('/admin/hero', [
            'eyebrow'      => 'New eyebrow',
            'title_lines'  => "Line one\nLine two",
            'title_accent' => 'Line two',
            'body'         => 'Body copy.',
            'stat_value'   => ['6+', ''],
            'stat_label'   => ['Shipped', ''],
        ])->assertRedirect('/admin/hero');

        $hero = ContentSetting::where('key', 'hero')->first()->value;

        $this->assertSame(['Line one', 'Line two'], $hero['title_lines']);
        $this->assertCount(1, $hero['stats']); // empty stat row dropped
        $this->assertSame('6+', $hero['stats'][0]['value']);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $this->actingAs($this->admin())->put('/admin/settings', [
            'contact_email'   => 'hello@example.com',
            'name'            => 'VLSS',
            'socials'         => ['discord' => 'https://discord.gg/x', 'bluesky' => '', 'youtube' => '', 'itch' => ''],
        ])->assertRedirect('/admin/settings');

        $site = ContentSetting::where('key', 'site')->first()->value;
        $this->assertSame('hello@example.com', $site['contact_email']);
        $this->assertSame('https://discord.gg/x', $site['socials']['discord']);
    }
}
