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
        $projects = Project::query()
            ->ordered()
            ->get();

        $profile = config('portfolio');

        return view('portfolio.index', compact('projects', 'profile'));
    }
}
