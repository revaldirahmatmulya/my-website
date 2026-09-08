@extends('layouts.app')

@section('title', 'Add New Project — Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-8">

    <!-- Header & Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                <a href="{{ route('admin.projects.index') }}" class="hover:text-slate-200 transition-colors">Projects</a>
                <span>/</span>
                <span class="text-indigo-400">Add New</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">
                Add New Project
            </h1>
        </div>

        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white text-xs font-medium transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-900/60 border border-slate-800/90 rounded-3xl p-6 sm:p-8 backdrop-blur-sm shadow-xl">
        <form action="{{ route('admin.projects.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Project Title <span class="text-indigo-400">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Modern E-Commerce Platform"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all">
                    @error('title')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (Optional) -->
                <div>
                    <label for="slug" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        URL Slug <span class="text-slate-500 font-normal lowercase">(auto-generated if empty)</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. modern-ecommerce-platform"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all font-mono">
                    @error('slug')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Display Order <span class="text-slate-500 font-normal lowercase">(lower numbers display first)</span>
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all">
                    @error('sort_order')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Project Description <span class="text-indigo-400">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required placeholder="Describe the purpose, architecture, key features, and problem solved..."
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all leading-relaxed">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tech Stack Tags -->
                <div class="sm:col-span-2">
                    <label for="tech_stack" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Tech Stack <span class="text-slate-500 font-normal lowercase">(separated with commas)</span>
                    </label>
                    <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack') }}" placeholder="e.g. Laravel 11, Tailwind CSS, MySQL, Redis, REST API"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all">
                    <p class="text-xs text-slate-500 mt-1.5">Enter technology tags separated by commas. These will be rendered as sleek badges on the project card.</p>
                    @error('tech_stack')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Demo URL -->
                <div>
                    <label for="demo_url" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Live Demo URL <span class="text-slate-500 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url') }}" placeholder="https://example.com/demo"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all">
                    @error('demo_url')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GitHub URL -->
                <div>
                    <label for="github_url" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        GitHub Repository URL <span class="text-slate-500 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url') }}" placeholder="https://github.com/username/repo"
                        class="w-full px-4 py-3 bg-slate-950/60 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm text-slate-100 placeholder-slate-600 outline-none transition-all">
                    @error('github_url')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Featured Checkbox -->
                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center gap-3 p-4 rounded-xl bg-slate-950/40 border border-slate-800 hover:border-slate-700 cursor-pointer transition-colors">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', true) ? 'checked' : '' }}
                            class="w-5 h-5 rounded bg-slate-900 border-slate-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900">
                        <div>
                            <span class="text-sm font-semibold text-slate-200">Mark as Featured Project</span>
                            <p class="text-xs text-slate-400">Featured projects receive a highlighted badge on the main page.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-800">
                <a href="{{ route('admin.projects.index') }}" class="px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold shadow-lg shadow-indigo-600/30 transition-all">
                    Save Project
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
