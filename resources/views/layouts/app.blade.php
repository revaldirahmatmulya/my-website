<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Revaldi\'s Portfolio')</title>
    <meta name="description" content="@yield('meta_description', config('portfolio.bio'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polygon points='12 2 2 7 12 12 22 7 12 2'/><polyline points='2 17 12 22 22 17'/><polyline points='2 12 12 17 22 12'/></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080c14] text-slate-100 font-sans antialiased min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Subtle Background Glows -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-gradient-to-tr from-indigo-600/15 via-purple-600/10 to-transparent blur-[120px] pointer-events-none -z-10"></div>
    <div class="fixed top-1/3 -right-32 w-[500px] h-[500px] bg-gradient-to-bl from-blue-600/10 via-cyan-600/5 to-transparent blur-[140px] pointer-events-none -z-10"></div>
    <div class="fixed -bottom-32 -left-32 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-900/15 via-slate-900/20 to-transparent blur-[140px] pointer-events-none -z-10"></div>

    @if(request()->routeIs('admin.*'))
        <!-- Admin-Only Navigation Bar -->
        <header class="sticky top-0 z-40 backdrop-blur-md bg-[#080c14]/80 border-b border-slate-800/80">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white text-xs shadow-md shadow-indigo-600/30">
                        {{ strtoupper(substr(config('portfolio.name', 'A'), 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-200 group-hover:text-white transition-colors">
                        {{ config('portfolio.name', 'Aldi') }}
                    </span>
                    <span class="text-xs text-indigo-400 font-mono">/ Admin</span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1 py-1.5 px-3 rounded-lg hover:bg-slate-800/60">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>View Website</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-slate-400 hover:text-red-400 transition-colors flex items-center gap-1 py-1.5 px-3 rounded-lg hover:bg-slate-800/60">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>
    @endif

    <!-- Flash Notifications -->
    @if(session('success') || session('info') || $errors->any())
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
            @if(session('success'))
                <div class="flex items-center justify-between p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400/80 hover:text-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="flex items-center justify-between p-4 rounded-xl bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 text-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('info') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-indigo-400/80 hover:text-indigo-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm">
                    <div class="flex items-center gap-3 font-semibold mb-1">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Please correct the errors below:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-xs text-red-400 ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

</body>
</html>
