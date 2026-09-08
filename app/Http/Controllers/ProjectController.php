<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Project::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->ordered()->paginate(10)->withQueryString();
        $totalProjects = Project::count();
        $featuredCount = Project::featured()->count();

        return view('admin.projects.index', compact('projects', 'totalProjects', 'featuredCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'description' => ['required', 'string'],
            'tech_stack' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $techStack = $this->parseTechStack($request->input('tech_stack'));

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $uniqueSlug = $slug;
        $counter = 1;
        while (Project::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = "{$slug}-{$counter}";
            $counter++;
        }

        Project::create([
            'title' => $validated['title'],
            'slug' => $uniqueSlug,
            'description' => $validated['description'],
            'tech_stack' => $techStack,
            'demo_url' => $validated['demo_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'New project successfully added to portfolio!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,'.$project->id],
            'description' => ['required', 'string'],
            'tech_stack' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $techStack = $this->parseTechStack($request->input('tech_stack'));

        $project->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'],
            'tech_stack' => $techStack,
            'demo_url' => $validated['demo_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $title = $project->title;
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$title}\" was successfully removed.");
    }

    /**
     * Parse tech stack comma-separated string into an array.
     *
     * @return array<int, string>
     */
    private function parseTechStack(?string $raw): array
    {
        if (empty($raw)) {
            return [];
        }

        $items = explode(',', $raw);
        $cleaned = [];

        foreach ($items as $item) {
            $trimmed = trim($item);
            if ($trimmed !== '') {
                $cleaned[] = $trimmed;
            }
        }

        return array_values(array_unique($cleaned));
    }
}
