<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Nexus E-Commerce Platform',
                'slug' => 'nexus-e-commerce-platform',
                'description' => 'A high-performance full-stack online store featuring real-time cart management, automated payment gateway integration, and comprehensive inventory analytics.',
                'tech_stack' => ['Laravel 11', 'Tailwind CSS', 'Alpine.js', 'MySQL', 'Stripe API'],
                'demo_url' => 'https://example.com/demo/nexus',
                'github_url' => 'https://github.com/example/nexus-ecommerce',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pulse SaaS Analytics & Monitoring',
                'slug' => 'pulse-saas-analytics-monitoring',
                'description' => 'A web-based dashboard application for real-time server metrics, API uptime tracking, and interactive performance visualization with instant webhook alerts.',
                'tech_stack' => ['Laravel', 'PostgreSQL', 'Tailwind CSS', 'Chart.js', 'Redis'],
                'demo_url' => 'https://example.com/demo/pulse',
                'github_url' => 'https://github.com/example/pulse-saas',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'DocuFlow Workflow & Task Engine',
                'slug' => 'docuflow-workflow-task-engine',
                'description' => 'A digital workplace workflow automation system featuring electronic signatures, automated audit trails, and multi-tier escalation notifications.',
                'tech_stack' => ['Laravel', 'Livewire', 'Tailwind CSS', 'SQLite'],
                'demo_url' => 'https://example.com/demo/docuflow',
                'github_url' => 'https://github.com/example/docuflow',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'DevConnect RESTful Microservices API',
                'slug' => 'devconnect-restful-microservices-api',
                'description' => 'A secure, scalable backend API architecture with Sanctum authentication, dynamic rate limiting, interactive Swagger OpenAPI documentation, and comprehensive unit tests.',
                'tech_stack' => ['PHP 8.4', 'Laravel', 'Docker', 'Swagger OpenAPI', 'PHPUnit'],
                'demo_url' => null,
                'github_url' => 'https://github.com/example/devconnect-api',
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }
    }
}
