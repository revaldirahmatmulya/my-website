<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_page_can_be_rendered_in_english_without_navbar_or_footer(): void
    {
        $project = Project::create([
            'title' => 'Nexus E-Commerce Platform',
            'slug' => 'nexus-e-commerce-platform',
            'description' => 'A high-performance online store with real-time inventory and payments.',
            'tech_stack' => ['Laravel 11', 'Tailwind CSS'],
            'demo_url' => 'https://example.com/demo',
            'github_url' => 'https://github.com/example/nexus',
            'is_featured' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Nexus E-Commerce Platform');
        $response->assertSee('Laravel 11');
        $response->assertSee('Tailwind CSS');
        $response->assertSee(config('portfolio.name'));
        $response->assertSee('View Projects');
        $response->assertSee('Email Me');
        $response->assertSee('Copy Email');
        $response->assertSee('Live Demo');
        $response->assertSee('Source Code');

        // Confirm navbar and footer elements are removed
        $response->assertDontSee('<header class="sticky top-0 z-40', false);
        $response->assertDontSee('Hak Cipta Dilindungi');
        $response->assertDontSee('Mari Terhubung');
    }

    public function test_login_screen_can_be_rendered_in_english(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('Admin Sign In');
        $response->assertSee('Email Address');
        $response->assertSee('Password');
    }
}
