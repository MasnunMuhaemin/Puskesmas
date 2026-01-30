<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Puskesmas') }}</title>
    
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Sidebar -->
        <aside 
            class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 flex-shrink-0 z-30 fixed inset-y-0 left-0 md:relative h-full"
            :class="{ 'w-64 -translate-x-0': sidebarOpen, 'w-0 md:w-20 -translate-x-full md:translate-x-0': !sidebarOpen }"
        >
            <div class="h-full flex flex-col overflow-hidden" :class="{ 'opacity-0 md:opacity-100': !sidebarOpen }">
                <!-- Logo -->
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center space-x-3" x-show="sidebarOpen">
                        <svg class="w-9 h-9" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="44" rx="12" fill="#309898" />
                            <path d="M22 12V32M12 22H32" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                        </svg>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Puskesmas</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <!-- Dashboard (All Roles) -->
                    <a href="{{ route(Auth::user()->role . '.dashboard') }}" 
                       class="flex items-center px-4 py-3 {{ request()->routeIs(Auth::user()->role . '.dashboard') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl font-medium transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>
                    
                    <!-- Admin Specific -->
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl font-medium transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span x-show="sidebarOpen">Kelola User</span>
                    </a>
                    <a href="{{ route('admin.poli.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.poli.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span x-show="sidebarOpen">Manajemen Poli</span>
                    </a>
                    <a href="{{ route('admin.dokter.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dokter.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span x-show="sidebarOpen">Data Dokter</span>
                    </a>
                    @endif

                    <!-- Petugas & Admin -->
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                    <a href="{{ route(Auth::user()->role . '.pasien.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('*.pasien.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span x-show="sidebarOpen">Data Pasien</span>
                    </a>
                    <a href="{{ route(Auth::user()->role . '.pendaftaran.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('*.pendaftaran.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span x-show="sidebarOpen">Pendaftaran</span>
                    </a>
                    @endif

                    <!-- Dokter & Admin -->
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'dokter')
                    <a href="{{ route(Auth::user()->role . '.rekam-medis.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('*.rekam-medis.*') ? 'text-primary bg-primary/10' : 'text-gray-600 dark:text-white hover:text-primary hover:bg-primary/5' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span x-show="sidebarOpen">Rekam Medis</span>
                    </a>
                    @endif
                </nav>

                <!-- Profile & Logout -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center p-2 rounded-xl bg-gray-50 dark:bg-gray-900/50">
                        <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center text-primary font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3 overflow-hidden" x-show="sidebarOpen">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all font-medium">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span x-show="sidebarOpen">Log Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-20 md:hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 sticky top-0 z-10 flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all mr-4">
                        <svg class="w-6 h-6 text-gray-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white md:hidden">Puskesmas</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-500 dark:text-white hidden sm:block">{{ date('l, d F Y') }}</span>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-6 max-w-7xl mx-auto w-full">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
