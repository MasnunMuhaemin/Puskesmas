<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Puskesmas Modern</title>
    
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-white font-sans selection:bg-primary/30 selection:text-primary">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100 dark:bg-gray-900/70 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center space-x-3">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-primary blur-lg opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <svg class="relative w-12 h-12" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="44" height="44" rx="14" fill="url(#logo_grad_welcome)" />
                                <path d="M22 12V32M12 22H32" stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M32 12C32 13.1046 31.1046 14 30 14C28.8954 14 28 13.1046 28 12C28 10.8954 28.8954 10 30 10C31.1046 10 32 10.8954 32 12Z" fill="#38BDF8"/>
                                <defs>
                                    <linearGradient id="logo_grad_welcome" x1="0" y1="0" x2="44" y2="44" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#309898"/>
                                        <stop offset="1" stop-color="#175F5F"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Puskesmas<span class="text-primary">.</span></span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-sm font-semibold text-gray-600 dark:text-white hover:text-primary transition-colors">Beranda</a>
                    <a href="#layanan" class="text-sm font-semibold text-gray-600 dark:text-white hover:text-primary transition-colors">Layanan</a>
                    <a href="#kontak" class="text-sm font-semibold text-gray-600 dark:text-white hover:text-primary transition-colors">Kontak</a>
                    @auth
                        <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-primary transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Ornaments -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none opacity-50">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-blue-400/20 blur-[100px] rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left space-y-8">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary border border-primary/20 text-xs font-bold uppercase tracking-widest animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-primary mr-2"></span> Terpercaya & Profesional
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-black text-gray-900 dark:text-white leading-[1.1]">
                        Solusi Kesehatan <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Terintegrasi</span>
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-white max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Kami menghadirkan layanan kesehatan digital yang memudahkan Anda dalam pendaftaran, konsultasi dokter, hingga pencatatan rekam medis secara aman dan transparan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all transform hover:-translate-y-1 text-center">
                            Daftar Pasien Baru
                        </a>
                        <a href="#layanan" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 font-bold rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all text-center">
                            Lihat Layanan
                        </a>
                    </div>
                    <div class="pt-8 flex flex-wrap items-center justify-center lg:justify-start gap-8">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">12k+</span>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Pasien</span>
                        </div>
                        <div class="w-px h-8 bg-gray-200 dark:bg-gray-800"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">50+</span>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Tenaga Medis</span>
                        </div>
                        <div class="w-px h-8 bg-gray-200 dark:bg-gray-800"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">24/7</span>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Layanan</span>
                        </div>
                    </div>
                </div>
                <div class="relative lg:block">
                    <!-- Modern Visual instead of missing image -->
                    <div class="relative w-full aspect-square max-w-xl mx-auto">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary to-blue-400 rounded-[3rem] rotate-3 opacity-20 blur-2xl"></div>
                        <div class="relative h-full w-full bg-white dark:bg-gray-800 border-8 border-gray-50 dark:border-gray-900 rounded-[3.5rem] shadow-2xl overflow-hidden p-8 flex flex-col justify-center">
                            <!-- Dashboard Preview Element -->
                            <div class="space-y-4">
                                <div class="h-8 w-1/2 bg-gray-100 dark:bg-gray-700 rounded-lg"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-32 bg-primary/5 rounded-2xl border border-primary/10 p-4">
                                        <div class="w-8 h-8 bg-primary rounded-lg mb-2"></div>
                                        <div class="h-3 w-3/4 bg-gray-200 dark:bg-gray-600 rounded"></div>
                                    </div>
                                    <div class="h-32 bg-blue-500/5 rounded-2xl border border-blue-500/10 p-4">
                                        <div class="w-8 h-8 bg-blue-500 rounded-lg mb-2"></div>
                                        <div class="h-3 w-3/4 bg-gray-200 dark:bg-gray-600 rounded"></div>
                                    </div>
                                </div>
                                <div class="h-40 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 p-4 flex flex-col space-y-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                                        <div class="flex-1 space-y-1">
                                            <div class="h-3 w-1/3 bg-gray-200 rounded"></div>
                                            <div class="h-2 w-1/4 bg-gray-100 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="h-2 w-full bg-gray-100 rounded"></div>
                                    <div class="h-2 w-full bg-gray-100 rounded"></div>
                                    <div class="h-2 w-2/3 bg-gray-100 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-16">
            <div class="max-w-3xl mx-auto space-y-4">
                <h2 class="text-sm font-black text-primary uppercase tracking-[0.2em]">Kategori Layanan</h2>
                <h3 class="text-4xl font-bold dark:text-white">Fasilitas Kesehatan Unggulan</h3>
                <p class="text-gray-600 dark:text-white">Kami menyediakan berbagai layanan poli spesialis untuk memenuhi kebutuhan kesehatan Anda dan keluarga.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 text-left">
                <!-- Poli Umum -->
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/10 rounded-3xl flex items-center justify-center text-primary mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Poli Umum</h4>
                    <p class="text-gray-600 dark:text-white text-sm leading-relaxed mb-6">Pemeriksaan kesehatan dasar untuk mengatasi berbagai keluhan penyakit umum Anda.</p>
                    <a href="#" class="text-sm font-bold text-primary flex items-center group-hover:translate-x-2 transition-transform">
                        Selengkapnya <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Poli Gigi -->
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-3xl flex items-center justify-center text-blue-500 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Poli Gigi</h4>
                    <p class="text-gray-600 dark:text-white text-sm leading-relaxed mb-6">Layanan perawatan gigi dan mulut dengan dokter spesialis yang berpengalaman.</p>
                    <a href="#" class="text-sm font-bold text-primary flex items-center group-hover:translate-x-2 transition-transform">
                        Selengkapnya <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Rekam Medis Digital -->
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-[2.5rem] border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-500/10 rounded-3xl flex items-center justify-center text-purple-500 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Rekam Medis Digital</h4>
                    <p class="text-gray-600 dark:text-white text-sm leading-relaxed mb-6">Akses riwayat kesehatan Anda kapan pun dan di mana pun secara aman & digital.</p>
                    <a href="#" class="text-sm font-bold text-primary flex items-center group-hover:translate-x-2 transition-transform">
                        Selengkapnya <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-24 bg-white dark:bg-gray-950 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Info Side -->
                <div class="space-y-12">
                    <div class="space-y-4 text-center lg:text-left">
                        <h2 class="text-sm font-black text-primary uppercase tracking-[0.2em]">Hubungi Kami</h2>
                        <h3 class="text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight">Ada Pertanyaan? Kami Siap Membantu Anda</h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-xl">Layanan kami tersedia untuk membantu kebutuhan informasi dan bantuan medis Anda. Hubungi kami melalui saluran di bawah ini.</p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-8">
                        <!-- Location -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary border border-primary/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Lokasi Kami</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Jl. Kesehatan No. 123, Jakarta Selatan, Indonesia</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 border border-blue-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Layanan Telepon</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">(021) 1234-5678</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-500 border border-purple-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 00-2 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Email Resmi</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">info@puskesmas-modern.id</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">admin@puskesmas.id</p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 border border-orange-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">Jam Operasional</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Senin - Sabtu: 08:00 - 20:00</p>
                                <p class="text-sm text-orange-500 font-bold uppercase tracking-tighter text-[10px] mt-1">Gawat Darurat: 24 Jam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Side -->
                <div class="relative" x-data="{ submitted: false }">
                    <div class="absolute inset-0 bg-primary/5 rounded-[3rem] -rotate-2 blur-2xl"></div>
                    <div class="relative bg-white dark:bg-gray-800 p-8 lg:p-12 rounded-[3rem] border border-gray-100 dark:border-gray-700 shadow-2xl shadow-primary/5">
                        <template x-if="!submitted">
                            <form @submit.prevent="submitted = true" class="space-y-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama</label>
                                        <input type="text" placeholder="John Doe" required class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900/50 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white placeholder:text-gray-400">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                                        <input type="email" placeholder="john@example.com" required class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900/50 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white placeholder:text-gray-400">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Subjek</label>
                                    <input type="text" placeholder="Ingin tanya tentang..." required class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900/50 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white placeholder:text-gray-400">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Pesan Anda</label>
                                    <textarea rows="4" placeholder="Tuliskan keluhan atau pertanyaan Anda di sini..." required class="w-full px-5 py-4 bg-gray-50 dark:bg-gray-900/50 border-none rounded-2xl focus:ring-2 focus:ring-primary transition-all text-gray-900 dark:text-white placeholder:text-gray-400"></textarea>
                                </div>
                                <button type="submit" class="w-full py-5 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:bg-primary/90 transition-all flex items-center justify-center group overflow-hidden relative">
                                    <span class="relative z-10">Kirim Pesan Sekarang</span>
                                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                </button>
                            </form>
                        </template>
                        
                        <template x-if="submitted">
                            <div class="text-center py-20 space-y-6 animate-in fade-in zoom-in duration-500">
                                <div class="w-24 h-24 bg-green-100 dark:bg-green-500/20 text-green-600 rounded-full mx-auto flex items-center justify-center">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="text-3xl font-black text-gray-900 dark:text-white">Pesan Terkirim!</h4>
                                    <p class="text-gray-500 dark:text-gray-400">Terima kasih telah menghubungi kami. Tim kami akan segera merespon pesan Anda melalui email.</p>
                                </div>
                                <button @click="submitted = false" class="text-primary font-bold hover:underline">Kirim Pesan Lainnya</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-gray-100 dark:bg-gray-900 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="44" height="44" rx="12" fill="#309898" />
                    <path d="M22 14V30M14 22H30" stroke="white" stroke-width="4" stroke-linecap="round"/>
                </svg>
                <span class="text-xl font-black text-gray-900 dark:text-white">Puskesmas<span class="text-primary">.</span></span>
            </div>
            <p class="text-sm text-gray-500">© {{ date('Y') }} Sistem Informasi Puskesmas Modern. All rights reserved.</p>
            <div class="flex space-x-6 text-sm font-bold text-gray-900 dark:text-white">
                <a href="#" class="hover:text-primary transition-colors">Privacy</a>
                <a href="#" class="hover:text-primary transition-colors">Terms</a>
            </div>
        </div>
    </footer>
</body>
</html>
