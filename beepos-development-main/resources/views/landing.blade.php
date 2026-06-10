<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Japemethe | Kedai Makanan Di Purwokerto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ffc61a',
                        primaryDark: '#e6b017',
                        primaryLight: '#ffd24d',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .font-display {
            font-family: 'Playfair Display', serif;
        }
        
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffc61a' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .menu-card:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }
        
        .menu-card {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="" class=""/>
                        <h1 class="text-3xl font-display font-black text-gray-900">
                            Japemethe<span class="text-primary"></span>
                        </h1>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="#home" class="text-gray-700 hover:text-primary transition-colors font-medium">Beranda</a>
                        <a href="#menu" class="text-gray-700 hover:text-primary transition-colors font-medium">Menu</a>
                        <a href="#about" class="text-gray-700 hover:text-primary transition-colors font-medium">Tentang</a>
                        <a href="#gallery" class="text-gray-700 hover:text-primary transition-colors font-medium">Galeri</a>
                        <a href="#contact" class="text-gray-700 hover:text-primary transition-colors font-medium">Kontak</a>
                        <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                            Reservasi
                        </button>
                        @if(auth()->check())
                            <a href="{{ route('auth.logout') }}" class="text-gray-700 hover:text-primary transition-colors font-medium">Logout</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition-colors font-medium">Login</a>
                        @endif
                        @if(auth()->check() && auth()->user()->role == 'admin')
                            <a href="{{ route('dashboard.admin') }}" class="text-gray-700 hover:text-primary transition-colors font-medium">Dashboard</a>
                        @endif
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="#home" class="text-gray-700 hover:text-primary transition-colors font-medium">Beranda</a>
                    <a href="#menu" class="text-gray-700 hover:text-primary transition-colors font-medium">Menu</a>
                    <a href="#about" class="text-gray-700 hover:text-primary transition-colors font-medium">Tentang</a>
                    <a href="#gallery" class="text-gray-700 hover:text-primary transition-colors font-medium">Galeri</a>
                    <a href="#contact" class="text-gray-700 hover:text-primary transition-colors font-medium">Kontak</a>
                    <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors w-full">
                        Reservasi
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center justify-center hero-pattern pt-20">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-primaryLight/5"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="fade-in">
                    <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-6">
                        <span class="text-primaryDark font-semibold">Autentik & Modern</span>
                    </div>
                    
                    <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                        Cita Rasa
                        <span class="text-primary block">Nusantara</span>
                        yang Menggugah
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Nikmati pengalaman kuliner Indonesia yang autentik dengan sentuhan modern. Setiap hidangan dibuat dengan cinta dan bumbu tradisional pilihan.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="bg-primary hover:bg-primaryDark text-gray-900 font-bold px-8 py-4 rounded-full transition-all transform hover:scale-105 shadow-lg">
                            Lihat Menu
                        </button>
                        <button class="bg-white hover:bg-gray-50 text-gray-900 font-semibold px-8 py-4 rounded-full transition-all border-2 border-gray-900">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                Tonton Video
                            </span>
                        </button>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-12 border-t border-gray-200">
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">10+</h3>
                            <p class="text-gray-600 font-medium">Tahun Pengalaman</p>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">50+</h3>
                            <p class="text-gray-600 font-medium">Menu Pilihan</p>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">1000+</h3>
                            <p class="text-gray-600 font-medium">Pelanggan Puas</p>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative fade-in">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('assets/img/satu.jpeg') }}" alt="Traditional Indonesian nasi goreng dish with perfectly fried rice, vegetables, and garnished with fried egg and crackers on a rustic wooden table" class="w-full h-auto object-cover"/>
                        
                        <!-- Floating Badge -->
                        <div class="absolute top-8 right-8 bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center space-x-3">
                                <div class="bg-primary rounded-full p-3">
                                    <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-900">4.9</p>
                                    <p class="text-sm text-gray-600">Rating Pelanggan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-primary rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -top-6 -right-6 w-40 h-40 bg-primaryLight rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-4">
                    <span class="text-primaryDark font-semibold">Menu Spesial</span>
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Menu Favorit Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pilihan hidangan terbaik yang wajib Anda coba
                </p>
            </div>

            <!-- Menu Categories -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="menu-category-btn active bg-primary text-gray-900 px-6 py-3 rounded-full font-semibold transition-all" data-category="all">
                    Semua Menu
                </button>
                <button class="menu-category-btn bg-gray-100 hover:bg-primary hover:text-gray-900 text-gray-700 px-6 py-3 rounded-full font-semibold transition-all" data-category="main">
                    Makanan Utama
                </button>
                <button class="menu-category-btn bg-gray-100 hover:bg-primary hover:text-gray-900 text-gray-700 px-6 py-3 rounded-full font-semibold transition-all" data-category="snack">
                    Camilan
                </button>
                <button class="menu-category-btn bg-gray-100 hover:bg-primary hover:text-gray-900 text-gray-700 px-6 py-3 rounded-full font-semibold transition-all" data-category="drink">
                    Minuman
                </button>
            </div>

            <!-- Menu Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Menu Card 1 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="main">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/nasi_ayam_geprek.jpg') }}" alt="Plate of traditional rendang beef curry with rich brown sauce, tender meat pieces, and aromatic spices served in authentic ceramic bowl" class="w-full h-full object-cover"/>
                        <div class="absolute top-4 right-4 bg-primary text-gray-900 px-4 py-2 rounded-full font-bold">
                            Best Seller
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Nasi Ayam Geprek</h3>
                            <span class="text-2xl font-bold text-primary">13K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Nasi hangat dengan ayam geprek pedas, sambal spesial, dan lalapan segar
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.9</span>
                                <span class="text-gray-500">(120)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Card 2 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="main">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/nasi_telor_krispi.jpg') }}" alt="Bowl of aromatic chicken soto soup with yellow broth, shredded chicken, vegetables, and traditional Indonesian spices" class="w-full h-full object-cover"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Nasi Telor Krispi</h3>
                            <span class="text-2xl font-bold text-primary">9K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Nasi hangat dengan telur krispi gurih, sambal pedas, dan lalapan segar
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.8</span>
                                <span class="text-gray-500">(95)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Card 3 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="main">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/nasi_omelet.jpg') }}" alt="Plate of golden fried rice with vegetables, eggs, chicken pieces, and garnished with cucumber and tomato slices" class="w-full h-full object-cover"/>
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-full font-bold">
                            New
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Nasi Omelet Mie Instan Single</h3>
                            <span class="text-2xl font-bold text-primary">13,5K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Nasi hangat dengan omelet mie instan lezat, sambal pedas, dan lalapan segar
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.7</span>
                                <span class="text-gray-500">(88)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Card 4 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="main">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/nasi_goreng_telor.jpg') }}" alt="Basket of golden brown crispy fried spring rolls with fresh vegetables and sweet chili dipping sauce on wooden board" class="w-full h-full object-cover"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Nasi Goreng Telor</h3>
                            <span class="text-2xl font-bold text-primary">12K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Nasi goreng spesial dengan telur mata sapi, acar, dan kerupuk
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.6</span>
                                <span class="text-gray-500">(72)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Card 5 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="main">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/nasi_magelangan.jpeg') }}" alt="Plate of golden fried banana fritters with crispy coating, dusted with powdered sugar and served with chocolate sauce" class="w-full h-full object-cover"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Nasi Magelangan</h3>
                            <span class="text-2xl font-bold text-primary">13,5K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Nasi magelangan lezat dengan campuran mie, telur, dan bumbu khas
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.8</span>
                                <span class="text-gray-500">(65)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Card 6 -->
                <div class="menu-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100" data-category="snack">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('assets/img/pisang_goreng.jpg') }}" alt="Tall glass of refreshing iced tea with lemon slices, ice cubes, and mint leaves garnish on wooden table" class="w-full h-full object-cover"/>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Pisang Goreng</h3>
                            <span class="text-2xl font-bold text-primary">8K</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Pisang goreng crispy dengan taburan gula halus, cocok untuk camilan sore Anda
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-gray-900 font-semibold">4.5</span>
                                <span class="text-gray-500">(150)</span>
                            </div>
                            <button class="bg-primary hover:bg-primaryDark text-gray-900 font-semibold px-6 py-2 rounded-full transition-colors">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Image -->
                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://placehold.co/600x500" alt="Professional chef in traditional Indonesian restaurant kitchen preparing authentic dishes with fresh ingredients and traditional cooking methods" class="w-full h-auto object-cover"/>
                    </div>
                    
                    <!-- Floating Stats Card -->
                    <div class="absolute -bottom-8 -right-8 bg-white rounded-2xl shadow-2xl p-8 max-w-xs">
                        <div class="flex items-center space-x-4">
                            <div class="bg-primary rounded-full p-4">
                                <svg class="w-8 h-8 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-gray-900">50+</p>
                                <p class="text-gray-600 font-medium">Resep Autentik</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div>
                    <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-4">
                        <span class="text-primaryDark font-semibold">Tentang Kami</span>
                    </div>
                    
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-gray-900 mb-6">
                        Cita Rasa Tradisional dengan Sentuhan Modern
                    </h2>
                    
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Rasa Nusantara hadir untuk menghadirkan pengalaman kuliner Indonesia yang autentik. Dengan pengalaman lebih dari 10 tahun, kami berkomitmen untuk menyajikan hidangan terbaik menggunakan bahan-bahan pilihan dan resep turun-temurun.
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Setiap hidangan dibuat dengan cinta dan dedikasi tinggi oleh chef berpengalaman kami. Kami percaya bahwa makanan yang baik adalah makanan yang dibuat dengan hati.
                    </p>

                    <!-- Features -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Bahan Premium</h4>
                                <p class="text-gray-600">Menggunakan bahan-bahan segar dan berkualitas tinggi</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Chef Berpengalaman</h4>
                                <p class="text-gray-600">Tim chef profesional dengan keahlian kuliner Indonesia</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Suasana Nyaman</h4>
                                <p class="text-gray-600">Desain interior modern dengan nuansa tradisional</p>
                            </div>
                        </div>
                    </div>

                    <button class="bg-primary hover:bg-primaryDark text-gray-900 font-bold px-8 py-4 rounded-full transition-all transform hover:scale-105">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-4">
                    <span class="text-primaryDark font-semibold">Galeri</span>
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Suasana & Hidangan Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Lihat berbagai momen indah di restoran kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Gallery Item 1 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Cozy interior of Indonesian restaurant with warm wooden furniture, traditional decorations, and ambient lighting creating welcoming atmosphere" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Suasana Restoran</h3>
                            <p class="text-sm">Nuansa nyaman dan tradisional</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 2 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Beautifully plated Indonesian cuisine with artistic presentation, colorful vegetables, and traditional garnishing on elegant white plate" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Penyajian Istimewa</h3>
                            <p class="text-sm">Detail dalam setiap hidangan</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 3 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Chef preparing traditional Indonesian dishes in professional kitchen with fresh ingredients and traditional cooking equipment" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Dapur Kami</h3>
                            <p class="text-sm">Proses memasak dengan cinta</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 4 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Delicious Indonesian desserts with colorful traditional sweets, coconut-based treats, and artistic plating on decorative serving plate" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Dessert Tradisional</h3>
                            <p class="text-sm">Manis yang memanjakan</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 5 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Group of happy diners enjoying Indonesian food together at restaurant with smiling faces and festive atmosphere" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Momen Bersama</h3>
                            <p class="text-sm">Kenangan tak terlupakan</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 6 -->
                <div class="relative overflow-hidden rounded-2xl shadow-lg group cursor-pointer h-80">
                    <img src="https://placehold.co/400x500" alt="Outdoor dining area of restaurant with tropical garden setting, comfortable seating, and natural lighting perfect for relaxed dining" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-6 left-6 text-white">
                            <h3 class="text-2xl font-bold mb-2">Area Outdoor</h3>
                            <p class="text-sm">Santai dengan alam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-4">
                    <span class="text-primaryDark font-semibold">Testimoni</span>
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-black text-gray-900 mb-4">
                    Kata Pelanggan Kami
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Pengalaman nyata dari pelanggan setia kami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-1 mb-4">
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        "Rendangnya luar biasa enak! Bumbunya meresap sempurna dan dagingnya sangat empuk. Tempat favorit keluarga untuk makan malam."
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-gray-900 font-bold text-lg">AS</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Andi Setiawan</h4>
                            <p class="text-sm text-gray-500">Food Blogger</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-1 mb-4">
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        "Suasananya sangat nyaman dan pelayanannya ramah. Menu-menunya autentik dan mengingatkan saya pada masakan ibu. Highly recommended!"
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-gray-900 font-bold text-lg">SW</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Siti Wijaya</h4>
                            <p class="text-sm text-gray-500">Pengusaha</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-1 mb-4">
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-primary fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        "Nasi goreng spesialnya juara! Porsi besar, bumbu pas, dan harga sangat terjangkau. Pasti balik lagi kesini!"
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-gray-900 font-bold text-lg">BP</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Budi Prasetyo</h4>
                            <p class="text-sm text-gray-500">Mahasiswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left - Contact Info -->
                <div>
                    <div class="inline-block bg-primary/20 px-4 py-2 rounded-full mb-4">
                        <span class="text-primaryDark font-semibold">Hubungi Kami</span>
                    </div>
                    
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-gray-900 mb-6">
                        Reservasi atau
                        <span class="text-primary block">Tanya Jawab</span>
                    </h2>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Hubungi kami untuk reservasi meja atau pertanyaan seputar menu dan layanan kami. Tim kami siap melayani Anda.
                    </p>

                    <!-- Contact Details -->
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Alamat</h4>
                                <p class="text-gray-600">
                                    Jl. Raya Nusantara No. 123<br/>
                                    Jakarta Selatan, DKI Jakarta 12345
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Telepon</h4>
                                <p class="text-gray-600">
                                    +62 812-3456-7890<br/>
                                    (021) 7890-1234
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Jam Operasional</h4>
                                <p class="text-gray-600">
                                    Senin - Jumat: 10.00 - 22.00<br/>
                                    Sabtu - Minggu: 09.00 - 23.00
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Email</h4>
                                <p class="text-gray-600">
                                    info@rasanusantara.com<br/>
                                    reservasi@rasanusantara.com
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-primary hover:bg-primaryDark rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-primary hover:bg-primaryDark rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-primary hover:bg-primaryDark rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-primary hover:bg-primaryDark rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right - Contact Form -->
                <div class="bg-gray-50 rounded-3xl p-8 lg:p-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="email@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="+62 812-3456-7890">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Orang</label>
                            <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                                <option>1-2 orang</option>
                                <option>3-4 orang</option>
                                <option>5-6 orang</option>
                                <option>7-10 orang</option>
                                <option>Lebih dari 10 orang</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Tulis pesan atau pertanyaan Anda..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primaryDark text-gray-900 font-bold px-8 py-4 rounded-lg transition-all transform hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-display text-3xl font-black mb-4">
                        Rasa<span class="text-primary">Nusantara</span>
                    </h3>
                    <p class="text-gray-400 mb-4 leading-relaxed">
                        Menghadirkan cita rasa autentik Indonesia dengan sentuhan modern. Setiap hidangan dibuat dengan cinta dan dedikasi untuk kepuasan Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="#menu" class="text-gray-400 hover:text-primary transition-colors">Menu Kami</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-primary transition-colors">Tentang</a></li>
                        <li><a href="#gallery" class="text-gray-400 hover:text-primary transition-colors">Galeri</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-primary transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Dapatkan promo & info terbaru</p>
                    <div class="flex">
                        <input type="email" placeholder="Email Anda" class="flex-1 px-4 py-2 rounded-l-lg bg-gray-800 text-white border border-gray-700 focus:border-primary focus:outline-none">
                        <button class="bg-primary hover:bg-primaryDark text-gray-900 font-bold px-4 py-2 rounded-r-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    © 2025 Rasa Nusantara. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollTop" class="fixed bottom-8 right-8 bg-primary hover:bg-primaryDark text-gray-900 p-4 rounded-full shadow-lg transition-all transform hover:scale-110 opacity-0 pointer-events-none">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
            
            lastScroll = currentScroll;
        });

        // Menu Category Filter
        const categoryButtons = document.querySelectorAll('.menu-category-btn');
        const menuCards = document.querySelectorAll('.menu-card');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;
                
                // Update active button
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-primary', 'text-gray-900');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                button.classList.add('active', 'bg-primary', 'text-gray-900');
                button.classList.remove('bg-gray-100', 'text-gray-700');
                
                // Filter menu cards
                menuCards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Scroll to Top Button
        const scrollTopButton = document.getElementById('scrollTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopButton.classList.remove('opacity-0', 'pointer-events-none');
                scrollTopButton.classList.add('opacity-100');
            } else {
                scrollTopButton.classList.add('opacity-0', 'pointer-events-none');
                scrollTopButton.classList.remove('opacity-100');
            }
        });

        scrollTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Form Submission
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Terima kasih! Pesan Anda telah terkirim. Tim kami akan segera menghubungi Anda.');
            e.target.reset();
        });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>
