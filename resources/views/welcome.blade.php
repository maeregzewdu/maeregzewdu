<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maereg Zewdu - Web Solutions</title>
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
        h1, h2, h3, h4, h5, h6, a, button {
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
    </style>
</head>

<body class="bg-[#0F172A] text-white">
    <!-- Notification Component Mount Point -->
    <div id="notification-app"></div>
    
    <!-- Flash Messages Container (Hidden) -->
    @if(session('success'))
        <div id="laravel-success-message" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <header class="fixed w-full z-50">
        <nav class="glass-nav w-full flex justify-between items-center px-10 py-5 mx-auto max-w-[1270px] rounded-xl mt-6 shadow-lg backdrop-blur-xl bg-opacity-30 border border-white/10">
            <a href="#home" class="text-2xl">
                <img src="images/logo/gold-logo.svg" alt="Maereg Zewdu Logo" class="w-[200px] hover:opacity-90 transition-opacity">
            </a>
            <div class="flex items-center gap-8">
                <div class="space-x-8">
                    <a href="#home" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Home</a>
                    <a href="#services" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Services</a>
                    <a href="#portfolio" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Portfolio</a>
                    <a href="#pricing" class="nav-link text-gray-300 font-russo hover:text-white transition-colors text-sm">Pricing</a>
                </div>
                <a href="#contact" class="cta-button bg-[#F5D061] text-black px-5 py-2 rounded-full font-russo text-sm">
                    Get in touch
                </a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient min-h-screen flex items-center pt-[120px]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-10">
                    <h1 class="text-7xl font-russo leading-tight">
                        Crafting Digital
                        <span class="gradient-text block">Experiences</span>
                        That Inspire
                    </h1>
                    <p class="text-xl text-gray-300 max-w-xl leading-relaxed">
                        I build modern, responsive websites that help businesses grow online.
                    </p>                    
                    <div class="flex gap-6">
                        <button onclick="window.location.href = '#portfolio'" class="cta-button bg-[#F5D061] cursor-pointer text-black px-10 py-4 rounded-full font-russo text-lg">
                            View My Work
                        </button>
                        <button onclick="window.location.href = '#contact'" class="glass-nav cursor-pointer border border-[#F5D061]/30 px-10 py-4 rounded-full font-russo text-lg hover:bg-[#F5D061]/10 transition-all duration-300 group">
                            <span class="flex items-center gap-2">
                                Let's Connect
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <div class="floating">
                        <div class="glass-nav p-8 rounded-xl">
                            <div class="bg-[#1A2332] text-left p-6 rounded-lg shadow-md">
                                <div class="flex gap-2 mb-4">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                </div>
                                <pre class="text-sm font-mono">
<span class="text-purple-400">const</span> <span class="text-blue-400">MaeregZewdu</span> = () => {
  <span class="text-gray-400">// Crafting digital experiences</span>
  <span class="text-purple-400">const</span> <span class="text-blue-400">skills</span> = [
    <span class="text-green-400">'Laravel'</span>,
    <span class="text-green-400">'Vue.js'</span>,
    <span class="text-green-400">'Tailwind'</span>
    <span class="text-green-400">'HTML/CSS'</span>,
  ];

  <span class="text-purple-400">return</span> (
    &lt;<span class="text-blue-400">div</span> <span class="text-yellow-400">className</span>=<span class="text-green-400">"portfolio"</span>&gt;
      &lt;<span class="text-blue-400">h1</span>&gt;Welcome to my world&lt;/<span class="text-blue-400">h1</span>&gt;
      &lt;<span class="text-blue-400">p</span>&gt;Where code meets creativity&lt;/<span class="text-blue-400">p</span>&gt;
    &lt;/<span class="text-blue-400">div</span>&gt;
  );
};</pre>
                            </div>
                        </div>
                        <div class="absolute -bottom-8 -right-8 glass-nav p-4 rounded-lg">
                            <div class="bg-[#1A2332] p-3 rounded-md">
                                <pre class="text-xs font-mono text-green-400">
<span class="text-purple-400">npm</span> install maereg-zewdu
<span class="text-gray-400"># Installing awesome developer...</span></pre>
                            </div>
                        </div>
                        <div class="absolute -top-8 -left-8 glass-nav p-4 rounded-lg">
                            <div class="bg-[#1A2332] p-3 rounded-md">
                                <pre class="text-xs font-mono text-green-400">
<span class="text-purple-400">git</span> clone maereg-zewdu
<span class="text-gray-400"># Cloning portfolio...</span></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-[#0F172A]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-russo mb-4">What I Do</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">I specialize in creating modern, responsive websites that help businesses establish their online presence and achieve their goals.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Web Development -->
                <div class="glass-nav p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#F5D061]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-4">Web Development</h3>
                    <p class="text-gray-400">Custom websites built with modern technologies like Laravel, Vue.js, and Tailwind CSS, ensuring fast, secure, and scalable solutions.</p>
                </div>

                <!-- UI/UX Design -->
                <div class="glass-nav p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#F5D061]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-4">UI/UX Design</h3>
                    <p class="text-gray-400">Creating beautiful, intuitive interfaces that provide exceptional user experiences and drive engagement.</p>
                </div>

                <!-- Responsive Design -->
                <div class="glass-nav p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-6 group-hover:bg-[#F5D061]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-4">Responsive Design</h3>
                    <p class="text-gray-400">Ensuring your website looks and functions perfectly across all devices, from mobile phones to desktop computers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Showcase Section - Vue.js Component Mount Point -->
    <div id="portfolio-app"></div>

    <!-- Pricing Section - Vue.js Component Mount Point -->
    <div id="pricing-app"></div>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-russo mb-4">Let's Work Together</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Have a project in mind? Let's discuss how we can bring your ideas to life.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Contact Form - Vue.js Component Mount Point -->
                <div id="contact-form-app"></div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <div class="glass-nav p-8 rounded-xl border border-white/10">
                        <h3 class="text-2xl font-russo mb-6">Contact Information</h3>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-300 font-medium">Email</h4>
                                    <a href="mailto:contact@example.com" class="text-[#F5D061] hover:underline">info@maeregzewdu.com</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-300 font-medium">Phone</h4>
                                    <a href="tel:+251912345678" class="text-[#F5D061] hover:underline">+251 965 598 182</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-300 font-medium">Location</h4>
                                    <a class="text-gray-400">Addis Ababa, Ethiopia</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="glass-nav p-8 rounded-xl border border-white/10">
                        <h3 class="text-2xl font-russo mb-6">Follow Me</h3>
                        <div class="flex gap-4">
                            <a href="https://t.me/maeregzewdu" target="_blank" class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                                <i class="ri-telegram-fill text-[#F5D061] text-2xl"></i>
                            </a>
                            <a href="https://www.instagram.com/_maereg" target="_blank" class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                                <i class="ri-instagram-fill text-[#F5D061] text-2xl"></i>
                            </a>
                            <a href="https://wa.me/251965598182" target="_blank" class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                                <i class="ri-whatsapp-fill text-[#F5D061] text-2xl"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/maeregzewdu" target="_blank" class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                                <i class="ri-linkedin-fill text-[#F5D061] text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-[#0A1020] border-t border-white/5 py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Logo & Info -->
                <div class="space-y-6">
                    <img src="images/logo/gold-logo.svg" alt="Maereg Zewdu Logo" class="w-[180px]">
                    <p class="text-gray-400 text-sm">Creating digital experiences that inspire and drive business growth.</p>
                    <div class="flex gap-3">
                        <a href="https://t.me/maeregzewdu" target="_blank" class="w-10 h-10 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-telegram-fill text-[#F5D061] text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/_maereg" target="_blank" class="w-10 h-10 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-instagram-fill text-[#F5D061] text-lg"></i>
                        </a>
                        <a href="https://wa.me/251965598182" target="_blank" class="w-10 h-10 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-whatsapp-fill text-[#F5D061] text-lg"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/maeregzewdu" target="_blank" class="w-10 h-10 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-linkedin-fill text-[#F5D061] text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-russo mb-4 text-white">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-gray-400 hover:text-[#F5D061] transition-colors">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-[#F5D061] transition-colors">Services</a></li>
                        <li><a href="#portfolio" class="text-gray-400 hover:text-[#F5D061] transition-colors">Projects</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-[#F5D061] transition-colors">Pricing</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-[#F5D061] transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-russo mb-4 text-white">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-[#F5D061] transition-colors">Web Development</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#F5D061] transition-colors">UI/UX Design</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#F5D061] transition-colors">E-Commerce</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#F5D061] transition-colors">Content Management</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#F5D061] transition-colors">SEO Optimization</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-russo mb-4 text-white">Contact</h4>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i class="ri-map-pin-line text-[#F5D061] mt-1"></i>
                            <a class="text-gray-400">Addis Ababa, Ethiopia</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ri-mail-line text-[#F5D061] mt-1"></i>
                            <a href="mailto:info@maeregzewdu.com" class="text-gray-400 hover:text-[#F5D061] transition-colors">info@maeregzewdu.com</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ri-phone-line text-[#F5D061] mt-1"></i>
                            <a href="tel:+251965598182" class="text-gray-400 hover:text-[#F5D061] transition-colors">+251 965 598 182</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy; 2025 Maereg Zewdu. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-gray-500 hover:text-[#F5D061] text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-[#F5D061] text-sm transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>