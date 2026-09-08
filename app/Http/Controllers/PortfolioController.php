<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class PortfolioController extends Controller
{
    /**
     * Display the portfolio landing page.
     */
    public function index(): View
    {
        try {
            $projects = Project::query()
                ->ordered()
                ->get();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Portfolio database query failed: ' . $e->getMessage());
            $projects = collect();
        }

        $profile = config('portfolio');

        return view('portfolio.index', compact('projects', 'profile'));
    }
}
