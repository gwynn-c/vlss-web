<?php

namespace Tests\Feature\Admin;

use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSubmissionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $submission = ContactSubmission::factory()->create();

        $this->get('/admin/submissions')->assertRedirect('/admin/login');
        $this->get("/admin/submissions/{$submission->id}")->assertRedirect('/admin/login');
        $this->delete("/admin/submissions/{$submission->id}")->assertRedirect('/admin/login');
        $this->assertModelExists($submission);
    }

    public function test_index_lists_submissions_newest_first(): void
    {
        ContactSubmission::factory()->create(['name' => 'Older Sender', 'created_at' => '2026-09-01 10:00:00']);
        ContactSubmission::factory()->create(['name' => 'Newer Sender', 'created_at' => '2026-09-10 10:00:00']);

        $response = $this->actingAs(User::factory()->create())->get('/admin/submissions');

        $response->assertSeeInOrder(['Newer Sender', 'Older Sender']);
    }

    public function test_index_paginates_twenty_per_page(): void
    {
        ContactSubmission::factory()->count(21)->sequence(fn ($sequence) => [
            'name' => 'Sender '.str_pad((string) $sequence->index, 2, '0', STR_PAD_LEFT),
            'created_at' => now()->subMinutes($sequence->index),
        ])->create();
        $admin = User::factory()->create();

        $firstPage = $this->actingAs($admin)->get('/admin/submissions');
        $secondPage = $this->actingAs($admin)->get('/admin/submissions?page=2');

        $firstPage->assertSee('Sender 19');
        $firstPage->assertDontSee('Sender 20');
        $firstPage->assertSee('Page 1 of 2 · 21 total');
        $secondPage->assertSee('Sender 20');
    }

    public function test_index_shows_an_empty_state_without_submissions(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/admin/submissions');

        $response->assertSee('No submissions yet.');
    }

    public function test_show_renders_every_field_of_the_submission(): void
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'Jane Swordsmith',
            'company' => 'Anvil Games',
            'email' => 'jane@anvil.test',
            'topic' => 'Co-development',
            'budget' => '$10k – $50k',
            'message' => 'We need a card battler ported.',
            'ip_address' => '203.0.113.7',
        ]);

        $response = $this->actingAs(User::factory()->create())->get("/admin/submissions/{$submission->id}");

        $response->assertSeeText('Jane Swordsmith');
        $response->assertSeeText('Anvil Games');
        $response->assertSee('mailto:jane@anvil.test');
        $response->assertSeeText('Co-development');
        $response->assertSeeText('$10k – $50k');
        $response->assertSeeText('We need a card battler ported.');
        $response->assertSeeText('203.0.113.7');
    }

    public function test_show_returns_404_for_a_missing_submission(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/admin/submissions/999');

        $response->assertNotFound();
    }

    public function test_submitted_content_is_escaped(): void
    {
        $submission = ContactSubmission::factory()->create([
            'name' => '<script>alert("name")</script>',
            'message' => '<img src=x onerror=alert(1)>',
        ]);
        $admin = User::factory()->create();

        $index = $this->actingAs($admin)->get('/admin/submissions');
        $show = $this->actingAs($admin)->get("/admin/submissions/{$submission->id}");

        $index->assertSee('&lt;script&gt;', false);
        $index->assertDontSee('<script>alert("name")</script>', false);
        $show->assertSee('&lt;img src=x onerror=alert(1)&gt;', false);
        $show->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_admin_can_delete_a_submission(): void
    {
        $submission = ContactSubmission::factory()->create();
        $kept = ContactSubmission::factory()->create();

        $response = $this->actingAs(User::factory()->create())->delete("/admin/submissions/{$submission->id}");

        $response->assertRedirect('/admin/submissions');
        $response->assertSessionHas('status', 'Submission deleted.');
        $this->assertModelMissing($submission);
        $this->assertModelExists($kept);
    }

    public function test_dashboard_shows_the_submission_count(): void
    {
        ContactSubmission::factory()->count(7)->create();

        $response = $this->actingAs(User::factory()->create())->get('/admin');

        $response->assertSeeInOrder(['<span class="card__count">7</span>', 'Contact submissions'], false);
    }
}
