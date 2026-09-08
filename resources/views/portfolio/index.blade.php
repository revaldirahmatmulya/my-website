@extends('layouts.app')

@section('title', $profile['name'] . ' — ' . $profile['role'])
@section('meta_description', $profile['bio'])

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- HERO / PROFILE SECTION (FULL SCREEN) -->
    <section class="min-h-screen flex flex-col justify-center items-start relative py-16">
        <!-- Status Indicator Pill -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-xs font-medium text-emerald-400 mb-8 backdrop-blur-md shadow-sm shadow-emerald-500/5">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span>{{ $profile['status'] ?? 'Available for new projects & opportunities' }}</span>
        </div>

        <!-- Greeting & Name -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-tight sm:leading-none">
            Hi, I'm <br class="sm:hidden">
            <span class="bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent">
                {{ $profile['name'] }}
            </span>
        </h1>

        <!-- Role / Title -->
        <p class="mt-4 text-xl sm:text-2xl font-semibold text-slate-300 tracking-tight">
            {{ $profile['role'] }}
        </p>

        <!-- Bio Description -->
        <p class="mt-5 text-base sm:text-lg text-slate-400 max-w-2xl leading-relaxed">
            {{ $profile['bio'] }}
        </p>

        <!-- Primary Actions & Social/Contact Channels -->
        <div class="mt-10 flex flex-wrap items-center gap-3.5 w-full">
            <!-- Scroll to projects -->
            <a href="#projects" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold shadow-lg shadow-indigo-600/30 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                <span>View Projects</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>

            <!-- Direct Email Action -->
            <a href="mailto:{{ $profile['email'] }}" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 text-slate-200 hover:text-white text-sm font-medium hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Email Me</span>
            </a>

            <!-- 1-Click Copy Email Button -->
            <button type="button" onclick="copyEmail()" id="copyEmailBtn" class="inline-flex items-center justify-center gap-1.5 px-4 py-3.5 rounded-xl bg-slate-900/90 hover:bg-slate-800 border border-slate-800 text-slate-400 hover:text-slate-200 text-sm font-medium transition-colors" title="Copy email address to clipboard">
                <svg id="copyIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span id="copyText">Copy Email</span>
            </button>

            <!-- Hidden email value for copy function -->
            <span id="rawEmail" class="hidden">{{ $profile['email'] }}</span>

            <!-- Social Links: GitHub & LinkedIn -->
            <div class="flex items-center gap-2 pl-2 sm:border-l sm:border-slate-800">
                <a href="{{ $profile['github_url'] }}" target="_blank" rel="noopener noreferrer"
                    class="p-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-400 hover:text-white transition-colors" title="GitHub Profile">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                </a>
                <a href="{{ $profile['linkedin_url'] }}" target="_blank" rel="noopener noreferrer"
                    class="p-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-400 hover:text-[#0a66c2] transition-colors" title="LinkedIn Profile">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Sleek Scroll Down Indicator at Bottom of Hero -->
        <div class="absolute bottom-6 left-0 flex items-center">
            <a href="#projects" class="group flex items-center gap-2.5 text-xs text-slate-500 hover:text-slate-300 transition-colors">
                <span class="w-5 h-9 rounded-full border border-slate-700 group-hover:border-indigo-400 flex items-start justify-center p-1 transition-colors">
                    <span class="w-1 h-2 rounded-full bg-slate-500 group-hover:bg-indigo-400 animate-bounce"></span>
                </span>
                <span class="tracking-wide">Scroll down to explore</span>
            </a>
        </div>
    </section>

    <!-- PROJECTS SHOWCASE SECTION -->
    <section id="projects" class="scroll-mt-12 pb-24 pt-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-8 border-b border-slate-800/80">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Featured Work</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-1">
                    Projects
                </h2>
                <p class="text-slate-400 text-sm sm:text-base mt-2">
                    A curated selection of web applications and digital platforms I've engineered.
                </p>
            </div>

            <!-- Instant Search Input -->
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="projectSearch" placeholder="Search by name or tech..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-900/90 border border-slate-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-xs sm:text-sm text-slate-200 placeholder-slate-500 outline-none transition-all">
            </div>
        </div>

        <!-- Projects Grid -->
        <div id="projectsGrid" class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            @forelse($projects as $project)
                <article class="project-card group relative flex flex-col justify-between bg-slate-900/50 hover:bg-slate-900/80 border border-slate-800/90 hover:border-indigo-500/40 rounded-2xl p-6 sm:p-7 backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-indigo-500/10"
                    data-title="{{ strtolower($project->title) }}"
                    data-tags="{{ strtolower(implode(' ', $project->tech_stack ?? [])) }}"
                    data-desc="{{ strtolower($project->description) }}">

                    <div>
                        <!-- Header & Badges -->
                        <div class="flex items-center justify-between gap-3 mb-4">
                            @if($project->is_featured)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-semibold bg-indigo-500/15 text-indigo-300 border border-indigo-500/30">
                                    <svg class="w-3 h-3 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                </span>
                            @else
                                <span class="text-xs text-slate-500 font-mono">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>

                        <!-- Project Title -->
                        <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors flex items-center justify-between gap-2">
                            <span>{{ $project->title }}</span>
                            @if($project->demo_url)
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-indigo-400 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            @endif
                        </h3>

                        <!-- Project Description -->
                        <p class="mt-3 text-slate-400 text-sm leading-relaxed">
                            {{ $project->description }}
                        </p>
                    </div>

                    <div class="mt-6 pt-5 border-t border-slate-800/80">
                        <!-- Tech Stack Tags -->
                        @if(!empty($project->tech_stack) && count($project->tech_stack) > 0)
                            <div class="flex flex-wrap gap-1.5 mb-5">
                                @foreach($project->tech_stack as $tech)
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800/90 text-slate-300 border border-slate-700/60">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Action Links -->
                        <div class="flex items-center gap-3">
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-3.5 py-2 rounded-lg shadow-sm shadow-indigo-600/30 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Live Demo</span>
                                </a>
                            @endif

                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700/80 border border-slate-700/80 px-3.5 py-2 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                    </svg>
                                    <span>Source Code</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-16 text-center rounded-2xl border border-dashed border-slate-800 bg-slate-900/30">
                    <p class="text-sm font-semibold text-slate-300">No projects added yet.</p>
                </div>
            @endforelse
        </div>

        <!-- No Results state for search -->
        <div id="noSearchResults" class="hidden py-16 text-center rounded-2xl border border-dashed border-slate-800 bg-slate-900/30 mt-6">
            <p class="text-slate-400 text-sm">No projects match your search query.</p>
        </div>
    </section>

    <!-- Discreet Admin Shortcut at the bottom -->
    <div class="pb-10 flex justify-end">
        <a href="{{ route('admin.projects.index') }}" class="text-slate-700 hover:text-slate-500 transition-colors p-2" title="Manage Projects">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </a>
    </div>

</div>

<script>
function copyEmail() {
    const email = document.getElementById('rawEmail').innerText.trim();
    const copyText = document.getElementById('copyText');

    navigator.clipboard.writeText(email).then(() => {
        copyText.innerText = 'Copied!';
        copyText.classList.add('text-emerald-400');
        setTimeout(() => {
            copyText.innerText = 'Copy Email';
            copyText.classList.remove('text-emerald-400');
        }, 2000);
    });
}

// Client-side search & filtering
document.getElementById('projectSearch')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.project-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const tags = card.getAttribute('data-tags') || '';
        const desc = card.getAttribute('data-desc') || '';

        if (title.includes(query) || tags.includes(query) || desc.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noResults = document.getElementById('noSearchResults');
    if (noResults) {
        if (visibleCount === 0 && cards.length > 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }
});
</script>
@endsection
