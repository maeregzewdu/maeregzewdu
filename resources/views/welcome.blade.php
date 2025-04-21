<x-app :socialLinks="$socialLinks" :myInfo="$myInfo">

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#0F172A] {{ request()->routeIs('privacy-policy') ? 'hidden' : '' }}">
        <img src="images/logo/gold-logo.svg" alt="Maereg Zewdu Logo" class="w-[150px] sm:w-[200px] mb-8 animate-pulse">
        <div class="w-64 h-2 bg-gray-800 rounded-full overflow-hidden mb-4">
            <div id="loading-bar" class="h-full bg-[#F5D061] rounded-full w-0 transition-all duration-300 ease-out"></div>
        </div>
        <p id="loading-status" class="text-gray-400 text-sm">Initializing...</p>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient h-screen lg:pt-26 flex items-center">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-20 items-center">
                <div class="space-y-3 md:space-y-6">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[65px] font-russo leading-tight slide-in-left">
                        Smart Solutions  
                        <span class="gradient-text block">Built to Impress</span>
                    </h1>
                    
                    <p class="text-base sm:text-lg md:text-xl text-gray-300 max-w-xl leading-relaxed slide-in-left" style="transition-delay: 0.2s;">
                        I craft clean, effective websites that solve problems and make brands shine.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 hero-buttons slide-in-left" style="transition-delay: 0.4s;">
                        <!-- Primary Button -->
                        <button onclick="window.location.href = '#portfolio'" 
                            class="cta-button w-full sm:w-auto bg-[#F5D061] text-black px-6 sm:px-10 py-3 sm:py-4 rounded-full font-russo text-base sm:text-lg transition-all duration-300 hover:bg-[#f5d061]/90">
                            View My Work
                        </button>
                
                        <!-- Secondary Button -->
                        <button onclick="window.location.href = '#contact'" 
                            class="w-full sm:w-auto border border-[#F5D061]/30 px-6 sm:px-10 py-3 sm:py-4 rounded-full font-russo text-base sm:text-lg hover:bg-[#F5D061]/10 transition-all duration-300 group text-white">
                            <span class="flex items-center justify-center gap-2">
                                Let's Connect
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>                
                
                <div class="relative hidden sm:block slide-in-right">
                    <div class="floating">
                        <div class="glass-nav p-8 rounded-xl">
                            <div class="bg-[#1A2332] text-left p-6 rounded-lg shadow-md">
                                <div class="flex gap-2 mb-4">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                                </div>
                                <pre class="text-sm font-mono code-snippet-animated" id="code-snippet">
<span class="text-purple-400">const</span> <span class="text-blue-400">MaeregZewdu</span> = () => {
  <span class="text-gray-400">// Crafting digital experiences</span>
  <span class="text-purple-400">const</span> <span class="text-blue-400">skills</span> = [
    <span class="text-green-400">'Laravel'</span>,
    <span class="text-green-400">'Vue.js'</span>,
    <span class="text-green-400">'Tailwind'</span>,
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
    <section id="services" class="py-16 md:py-24 bg-[#0F172A]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-russo mb-3 md:mb-4 section-title">What I Do</h2>
                <p class="text-gray-400 max-w-2xl mx-auto section-subtitle">I specialize in creating modern, responsive websites that help businesses establish their online presence and achieve their goals.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Web Development -->
                <div class="glass-nav p-6 md:p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group service-card">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-4 md:mb-6 group-hover:bg-[#F5D061]/20 transition-colors service-icon">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-3 md:mb-4 service-title">Web Development</h3>
                    <p class="text-gray-400 service-description">Custom websites built with modern technologies like Laravel, Vue.js, and Tailwind CSS, ensuring fast, secure, and scalable solutions.</p>
                </div>

                <!-- UI/UX Design -->
                <div class="glass-nav p-6 md:p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group service-card">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-4 md:mb-6 group-hover:bg-[#F5D061]/20 transition-colors service-icon">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-3 md:mb-4 service-title">UI/UX Design</h3>
                    <p class="text-gray-400 service-description">Creating beautiful, intuitive interfaces that provide exceptional user experiences and drive engagement.</p>
                </div>

                <!-- Responsive Design -->
                <div class="glass-nav p-6 md:p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group service-card">
                    <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mb-4 md:mb-6 group-hover:bg-[#F5D061]/20 transition-colors service-icon">
                        <svg class="w-6 h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-russo mb-3 md:mb-4 service-title">Responsive Design</h3>
                    <p class="text-gray-400 service-description">Ensuring your website looks and functions perfectly across all devices, from mobile phones to desktop computers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Showcase Section - Vue.js Component Mount Point -->
    <div id="portfolio-app"></div>

    <!-- Pricing Section - Vue.js Component Mount Point -->
    <div id="pricing-app"
        data-plans='@json($plans)'
        data-my-info='@json($myInfo)'>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="py-16 md:py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-russo mb-3 md:mb-4">Let's Work Together</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Have a project in mind? Let's discuss how we can bring your ideas to life.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 max-w-6xl mx-auto">
                <!-- Contact Form - Vue.js Component Mount Point -->
                <div id="contact-form-app"></div>

                <!-- Contact Information -->
                <div class="space-y-6 md:space-y-8">
                    <div class="glass-nav p-6 md:p-8 rounded-xl border border-white/10">
                        <h3 class="text-xl md:text-2xl font-russo mb-4 md:mb-6">Contact Information</h3>
                        <div class="space-y-4 md:space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-gray-300 font-medium">Email</h4>
                                    <a href="mailto:{{ $myInfo->email }}" class="text-[#F5D061] hover:underline">{{ $myInfo->email }}</a>
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
                                    <a href="tel:{{ $myInfo->phone }}" class="text-[#F5D061] hover:underline">{{ $myInfo->phone }}</a>
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
                                    <a class="text-gray-400">{{ $myInfo->address }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @include('components.social-links-enhanced')
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading screen animation
            const loadingOverlay = document.getElementById('loading-overlay');
            const loadingBar = document.getElementById('loading-bar');
            const loadingStatus = document.getElementById('loading-status');
            let progress = 0;
            
            // Loading status messages
            const statusMessages = [
                "Initializing...",
                "Loading assets...",
                "Preparing content...",
                "Finalizing...",
                "Finalizing..."
            ];
            
            // Disable scrolling while loading
            document.body.style.overflow = 'hidden';
            
            // Simulate loading progress
            const loadingInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 100) progress = 100;
                loadingBar.style.width = `${progress}%`;
                
                // Update status message based on progress
                if (progress < 20) {
                    loadingStatus.textContent = statusMessages[0];
                } else if (progress < 40) {
                    loadingStatus.textContent = statusMessages[1];
                } else if (progress < 60) {
                    loadingStatus.textContent = statusMessages[2];
                } else if (progress < 80) {
                    loadingStatus.textContent = statusMessages[3];
                } else {
                    loadingStatus.textContent = statusMessages[4];
                }
                
                if (progress >= 100) {
                    clearInterval(loadingInterval);
                    
                    // Add a small delay before hiding the overlay
                    setTimeout(() => {
                        // Fade out the overlay
                        loadingOverlay.style.opacity = '0';
                        loadingOverlay.style.transition = 'opacity 0.5s ease-out';
                        
                        // Enable scrolling
                        document.body.style.overflow = '';
                        
                        // Remove the overlay after fade out
                        setTimeout(() => {
                            loadingOverlay.style.display = 'none';
                            
                            // Trigger hero animations
                            triggerHeroAnimations();
                            
                            // Start typing effect for code snippet
                            startTypingEffect();
                        }, 500);
                    }, 500);
                }
            }, 200);
            
            // Function to trigger hero animations
            function triggerHeroAnimations() {
                // Add active class to fade-in elements with staggered delay
                const fadeElements = document.querySelectorAll('.fade-in');
                fadeElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('active');
                    }, 100 * index);
                });
                
                // Add active class to slide-in elements
                const slideElements = document.querySelectorAll('.slide-in-left, .slide-in-right');
                slideElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('active');
                    }, 300 + (100 * index));
                });
            }
            
            // Function to create typing effect for code snippet
            function startTypingEffect() {
                const codeSnippet = document.getElementById('code-snippet');
                if (!codeSnippet) return;
                
                // Simply add the visible class after a delay
                setTimeout(() => {
                    codeSnippet.classList.add('visible');
                }, 500);
            }
            
            // Scroll animation for services section
            function handleScrollAnimations() {
                const serviceCards = document.querySelectorAll('.service-card');
                const sectionTitle = document.querySelector('.section-title');
                const sectionSubtitle = document.querySelector('.section-subtitle');
                const triggerPoint = window.innerHeight * 0.8;
                
                // Check if section title and subtitle are in view
                if (sectionTitle && sectionSubtitle) {
                    const titleTop = sectionTitle.getBoundingClientRect().top;
                    
                    if (titleTop < triggerPoint) {
                        // Animate title first
                        sectionTitle.classList.add('visible');
                        
                        // Then animate subtitle with a slight delay
                        setTimeout(() => {
                            sectionSubtitle.classList.add('visible');
                        }, 200);
                    }
                }
                
                serviceCards.forEach((card, index) => {
                    const cardTop = card.getBoundingClientRect().top;
                    
                    if (cardTop < triggerPoint) {
                        // Add staggered delay based on index
                        setTimeout(() => {
                            card.classList.add('visible');
                            
                            // Add a subtle hover effect after animation
                            card.addEventListener('mouseenter', function() {
                                this.style.transform = 'translateY(-5px)';
                                this.style.boxShadow = '0 10px 25px rgba(245, 208, 97, 0.15)';
                            });
                            
                            card.addEventListener('mouseleave', function() {
                                this.style.transform = 'translateY(0)';
                                this.style.boxShadow = 'none';
                            });
                        }, 150 * index);
                    }
                });
            }
            
            // Initial check for elements in view
            handleScrollAnimations();
            
            // Add scroll event listener with throttling for better performance
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                if (scrollTimeout) {
                    window.cancelAnimationFrame(scrollTimeout);
                }
                
                scrollTimeout = window.requestAnimationFrame(function() {
                    handleScrollAnimations();
                });
            });

            // Add contact section animations
            const contactSection = document.querySelector('.contact-section');
            if (contactSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Animate contact section
                            entry.target.classList.add('visible');
                            
                            // Animate info titles
                            const infoTitles = entry.target.querySelectorAll('.info-title');
                            infoTitles.forEach((title, index) => {
                                setTimeout(() => {
                                    title.classList.add('visible');
                                }, 200 + (100 * index));
                            });
                            
                            // Animate social links
                            const socialLinks = entry.target.querySelectorAll('.social-link');
                            socialLinks.forEach((link, index) => {
                                setTimeout(() => {
                                    link.classList.add('visible');
                                }, 400 + (100 * index));
                            });
                            
                            // Animate info items
                            const infoItems = entry.target.querySelectorAll('.info-item');
                            infoItems.forEach((item, index) => {
                                setTimeout(() => {
                                    item.classList.add('visible');
                                }, 800 + (100 * index));
                            });
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 });
                
                observer.observe(contactSection);
            }
        });
    </script>
    
</x-app>