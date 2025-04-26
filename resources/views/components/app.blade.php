<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maereg Zewdu - Web Designer and Developer</title>
    <meta name="description" content="Crafting modern, responsive websites that help businesses grow online. Let’s bring your digital ideas to life." />
    <meta property="og:title" content="Maereg Zewdu – Web Designer and Developer" />
    <meta property="og:description" content="Crafting modern, responsive websites that help businesses grow online." />
    <meta property="og:url" content="https://maeregzewdu.com" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url('images/logo/favicon.svg') }}" />
    <link rel="icon" type="image/png" href="{{ url('images/logo/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ url('images/logo/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ url('images/logo/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/logo/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Maereg" />
    <link rel="manifest" href="{{ url('images/logo/site.webmanifest') }}" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Russo+One&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4, h5, h6, a, button, .price, #loading-status, #font-russo {
            font-family: 'Russo One', sans-serif;
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #F5D061;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
        }
        .cta-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .cta-button:hover::before {
            transform: translateX(100%);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 208, 97, 0.3);
        }
        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(245, 208, 97, 0.1), transparent 50%),
                        linear-gradient(45deg, #0F172A, #1E293B);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .gradient-text {
            background: linear-gradient(45deg, #F5D061, #FFB800, #F5D061);
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .tech-stack {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .tech-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }
        .tech-item:hover {
            background: rgba(245, 208, 97, 0.1);
            transform: translateY(-2px);
        }
        
        /* Mobile Menu Styles */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            z-index: 49;
            padding: 6rem 2rem 2rem;
            flex-direction: column;
            align-items: center;
        }
        
        .mobile-menu.active {
            display: flex;
        }
        
        .mobile-menu a {
            display: block;
            padding: 1rem;
            font-size: 1.25rem;
            text-align: center;
            width: 100%;
        }
        
        .mobile-menu .cta-button {
            margin-top: 1.5rem;
            width: 80%;
        }
        
        .hamburger {
            display: none;
            cursor: pointer;
            z-index: 60;
            position: relative;
        }
        
        header {
            z-index: 55;
        }
        
        #menu-toggle {
            z-index: 60;
        }
        
        @media (max-width: 1024px) {
            .desktop-menu {
                display: none;
            }
            
            .hamburger {
                display: block;
            }
            
            .glass-nav {
                padding: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 3rem !important;
            }
            
            .glass-nav {
                margin-top: 1rem;
                border-radius: 0.5rem;
                padding: 0.75rem 1.5rem;
            }
            
            .logo-img {
                width: 150px;
            }
        }
        
        @media (max-width: 640px) {
            h1 {
                font-size: 2.5rem !important;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .hero-buttons button {
                width: 100%;
            }
            
            .logo-img {
                width: 120px;
            }
        }
        
        /* Animation Classes */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slide-in-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .slide-in-left.active {
            opacity: 1;
            transform: translateX(0);
        }
        
        .slide-in-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .slide-in-right.active {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Services section animations */
        .service-card {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .service-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(245, 208, 97, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }
        
        .service-card.visible::before {
            opacity: 1;
        }
        
        .service-icon {
            transform: scale(0.8) rotate(-10deg);
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .service-card.visible .service-icon {
            transform: scale(1) rotate(0);
        }
        
        .service-title {
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            transition-delay: 0.2s;
        }
        
        .service-card.visible .service-title {
            opacity: 1;
            transform: translateY(0);
        }
        
        .service-description {
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            transition-delay: 0.3s;
        }
        
        .service-card.visible .service-description {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Section title animations */
        .section-title {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .section-title.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .section-subtitle {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition-delay: 0.2s;
        }
        
        .section-subtitle.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Simple code snippet animation */
        .code-snippet-animated {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .code-snippet-animated.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Contact section animations */
        .contact-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .contact-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contact info container */
        .contact-info-container {
            margin-top: 2rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .contact-info-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Info title animations */
        .info-title {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .info-title.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Social links animations */
        .social-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .social-link.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .social-link:hover {
            transform: translateX(5px);
            background: rgba(245, 208, 97, 0.1);
            border-color: rgba(245, 208, 97, 0.3);
        }

        /* Contact details animations */
        .info-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .info-item.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .info-item:hover {
            transform: translateX(-5px);
            background: rgba(245, 208, 97, 0.1);
            border-color: rgba(245, 208, 97, 0.3);
        }
    </style>
</head>

<body class="bg-[#0F172A] text-white">

    <!-- Notification Component Mount Point -->
    <div id="notification-app"></div>

    <!-- Cookie Consent Component Mount Point -->
    <div id="cookie-consent-app"></div>
    
    <!-- Flash Messages Container (Hidden) -->
    @if(session('success'))
        <div id="laravel-success-message" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <header class="fixed w-full z-40">
        <nav class="w-full">
            <div class="flex justify-between items-center px-4 sm:px-6 md:px-10 py-4 md:py-5 mx-auto max-w-[1270px] lg:rounded-xl lg:mt-4 shadow-lg backdrop-blur-xl bg-opacity-30 border border-white/10 bg-black/30">
                <a href="/" class="text-2xl">
                    <img src="{{ asset('images/logo/gold-logo.svg') }}" alt="Maereg Zewdu Logo" class="w-[120px] sm:w-[150px] md:w-[200px] logo-img hover:opacity-90 transition-opacity">
                </a>
    
                <!-- Desktop Menu -->
                <div class="desktop-menu hidden lg:flex items-center gap-4 md:gap-8">
                    <div class="space-x-4 md:space-x-8">
                        <a href="#home" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Home</a>
                        <a href="#services" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Services</a>
                        <a href="#portfolio" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Portfolio</a>
                        <a href="#pricing" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Pricing</a>
                    </div>
                    <a href="#contact" class="cta-button bg-[#F5D061] text-black px-5 py-2 rounded-full font-russo text-sm">
                        Get in touch
                    </a>
                </div>
    
                <!-- Mobile Menu Button -->
                <div class="hamburger">
                    <button id="menu-toggle" class="text-white p-2 relative w-10 h-10 flex items-center justify-center focus:outline-none">
                        <span class="sr-only">Toggle menu</span>
                        <i id="menu-icon-open" class="ri-menu-line text-2xl"></i>
                        <i id="menu-icon-close" class="ri-close-line text-2xl hidden"></i>
                    </button>
                </div>
            </div>
        </nav>
    
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu">
            <button id="mobile-menu-close" class="absolute top-6 right-6 text-white p-2 focus:outline-none">
                <i class="ri-close-line text-3xl"></i>
            </button>
            <a href="#home" class="nav-link text-gray-300 font-russo hover:text-white transition-colors">Home</a>
            <a href="#services" class="nav-link text-gray-300 font-russo hover:text-white transition-colors">Services</a>
            <a href="#portfolio" class="nav-link text-gray-300 font-russo hover:text-white transition-colors">Portfolio</a>
            <a href="#pricing" class="nav-link text-gray-300 font-russo hover:text-white transition-colors">Pricing</a>
            <a href="#contact" class="cta-button mt- bg-[#F5D061] text-black px-5 py-2 rounded-full font-russo text-center">
                Get in touch
            </a>
        </div>
    </header>

    {{ $slot }}

    <!-- Footer Section -->
    <footer class="bg-[#0A1020] border-t border-white/5 py-6 md:py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Logo & Info -->
                <div class="space-y-3">
                    <img src="{{ asset('images/logo/gold-logo.svg') }}" alt="Maereg Zewdu Logo" class="w-[150px] md:w-[180px]">
                    <p class="text-gray-400 text-sm">Creating digital experiences that inspire and drive business growth.</p>
                    @include('components.social-links-compact')
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-russo mb-3 text-white">Quick Links</h4>
                    <ul class="space-y-1.5 lg:flex lg:gap-3">
                        <li><a href="#home" class="text-gray-400 hover:text-[#F5D061] transition-colors">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-[#F5D061] transition-colors">Services</a></li>
                        <li><a href="#portfolio" class="text-gray-400 hover:text-[#F5D061] transition-colors">Projects</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-[#F5D061] transition-colors">Pricing</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-[#F5D061] transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-russo mb-3 text-white">Contact</h4>
                    <ul class="lg:flex lg:gap-3">
                        <li class="flex items-center gap-2">
                            <i class="ri-mail-line text-[#F5D061] mt-1 lg:hidden"></i>
                            <a href="mailto:{{ $myInfo->email }}" class="text-gray-400 hover:text-[#F5D061] transition-colors">{{ $myInfo->email }}</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ri-phone-line text-[#F5D061] mt-1 lg:hidden"></i>
                            <a href="tel:{{ $myInfo->phone }}" class="text-gray-400 hover:text-[#F5D061] transition-colors">{{ $myInfo->phone }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 mt-4 md:mt-6 pt-3 md:pt-4 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-3 md:mb-0">&copy; {{ date('Y') }} {{ $myInfo->name }}. All rights reserved.</p>
                <div class="flex items-center gap-3 md:gap-4">
                    <a href="{{ route('privacy-policy') }}" class="text-gray-500 hover:text-[#F5D061] text-sm transition-colors">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIconOpen = document.getElementById('menu-icon-open');
            const menuIconClose = document.getElementById('menu-icon-close');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleMenu();
                });
            }
            
            // Close button inside mobile menu
            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', function() {
                    closeMenu();
                });
            }
            
            // Close mobile menu when clicking a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    closeMenu();
                });
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (mobileMenu.classList.contains('active') && 
                    !mobileMenu.contains(e.target) && 
                    !menuToggle.contains(e.target)) {
                    closeMenu();
                }
            });
            
            // Prevent clicks inside the mobile menu from closing it
            mobileMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Helper functions for menu operations
            function toggleMenu() {
                mobileMenu.classList.toggle('active');
                menuIconOpen.classList.toggle('hidden');
                menuIconClose.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
            
            function closeMenu() {
                mobileMenu.classList.remove('active');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            // Laravel flash message handling
            const successMessage = document.getElementById('laravel-success-message');
            if (successMessage && successMessage.dataset.message) {
                // This assumes you have a notification Vue component
                // You would need to implement this part based on your notification system
                console.log('Success message:', successMessage.dataset.message);
            }
        });
    </script>

</body>

</html>