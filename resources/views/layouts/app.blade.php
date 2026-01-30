<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Puskesmas') }}</title>
    
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside 
            class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 w-64 fixed md:sticky top-0 h-screen z-20 transition-all duration-300 transform"
            :class="{ '-translate-x-full md:translate-x-0 md:w-20': !sidebarOpen, 'translate-x-0 w-64': sidebarOpen }"
        >
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center space-x-3" x-show="sidebarOpen">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold">P</div>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">Puskesmas</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="flex items-center px-4 py-3 text-primary bg-primary/10 rounded-xl font-medium transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                    <a href="#" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:text-primary hover:bg-primary/5 rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span x-show="sidebarOpen">Poli & Dokter</span>
                    </a>
                    @endif

                    <!-- Add more menu items based on roles here -->
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

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 sticky top-0 z-10">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ date('l, d F Y') }}</span>
                    </div>
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
