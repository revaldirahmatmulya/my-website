<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
        ]);
    }

    public function test_guests_cannot_access_admin_project_management(): void
    {
        $response = $this->get(route('admin.projects.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_project_list_in_english(): void
    {
        Project::create([
            'title' => 'Alpha Cloud Architecture',
            'slug' => 'alpha-cloud-architecture',
            'description' => 'Scalable cloud infrastructure engine.',
            'tech_stack' => ['Laravel', 'AWS'],
            'is_featured' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.projects.index'));

        $response->assertOk();
        $response->assertSee('Alpha Cloud Architecture');
        $response->assertSee('Manage Projects');
        $response->assertSee('Add New Project');
    }

    public function test_admin_can_create_a_new_project_with_english_notifications(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'FinTrack AI Accounting',
            'slug' => 'fintrack-ai-accounting',
            'description' => 'AI-driven expense management platform with real-time currency conversion.',
            'tech_stack' => 'Laravel 11, Tailwind CSS, OpenAI API, PostgreSQL',
            'demo_url' => 'https://fintrack.example.com',
            'github_url' => 'https://github.com/example/fintrack',
            'is_featured' => '1',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHas('success', 'New project successfully added to portfolio!');

        $this->assertDatabaseHas('projects', [
            'title' => 'FinTrack AI Accounting',
            'slug' => 'fintrack-ai-accounting',
        ]);

        $project = Project::where('slug', 'fintrack-ai-accounting')->first();
        $this->assertNotNull($project);
        $this->assertContains('Laravel 11', $project->tech_stack);
        $this->assertContains('OpenAI API', $project->tech_stack);
    }

    public function test_admin_can_update_an_existing_project(): void
    {
        $project = Project::create([
            'title' => 'Legacy System',
            'slug' => 'legacy-system',
            'description' => 'Old description',
            'tech_stack' => ['PHP'],
            'is_featured' => false,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), [
            'title' => 'Modernized Microservice',
            'slug' => 'modernized-microservice',
            'description' => 'Upgraded high-throughput microservice architecture.',
            'tech_stack' => 'PHP 8.4, Laravel 11, Docker, Redis',
            'demo_url' => 'https://demo.example.com',
            'github_url' => 'https://github.com/example/microservice',
            'is_featured' => '1',
            'sort_order' => 2,
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHas('success', 'Project updated successfully!');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Modernized Microservice',
            'slug' => 'modernized-microservice',
            'description' => 'Upgraded high-throughput microservice architecture.',
        ]);
    }

    public function test_admin_can_delete_a_project(): void
    {
        $project = Project::create([
            'title' => 'Project Scheduled For Removal',
            'slug' => 'project-scheduled-for-removal',
            'description' => 'Pending deletion',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHas('success', 'Project "Project Scheduled For Removal" was successfully removed.');

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
