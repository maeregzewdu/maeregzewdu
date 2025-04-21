<template>
    <section id="portfolio" class="py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-russo mb-4 section-title">Featured Projects</h2>
                <p class="text-gray-400 max-w-2xl mx-auto section-subtitle">Explore my latest work and see how I bring ideas to life
                    through code and design.</p>
            </div>

            <div class="relative">
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out max-w-[1270px] mx-auto hover-pause"
                        :style="{ transform: `translateX(-${currentSlide * 100}%)` }" @mouseenter="stopAutoPlay"
                        @mouseleave="startAutoPlay">
                        <!-- Project 1 -->
                        <div class="w-full flex-shrink-0 px-4 project-card">
                            <div
                                class="group relative overflow-hidden bg-[#11172E] rounded-xl p-0 transition-all duration-500 max-w-[400px] mx-auto hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1">
                                <!-- Image Container -->
                                <div class="relative h-52 overflow-hidden">
                                    <img :src="'/images/projects/tenamart.png'" alt="Project 1"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-40 group-hover:opacity-60 transition-opacity duration-500">
                                    </div>
                                    <!-- Feature badge -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="bg-[#F5D061]/90 text-black text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="relative z-10 p-6 pt-5">
                                    <!-- Tech stack badges -->
                                    <div class="flex flex-wrap gap-2 mb-3 -mt-8">
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Laravel</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Vue.js</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Tailwind</span>
                                    </div>

                                    <!-- Project Info -->
                                    <h3
                                        class="text-xl font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">
                                        TenaMart - Online Pharmacy</h3>
                                    <p class="text-gray-400 text-sm mb-5">A modern e-commerce solution with advanced
                                        features and seamless user experience.</p>

                                    <!-- Actions -->
                                    <div class="flex justify-between items-center">
                                        <a href="#"
                                            class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                            View Project
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                        <a href="#"
                                            class="w-9 h-9 rounded-full flex items-center justify-center bg-[#F5D061]/10 hover:bg-[#F5D061]/20 transition-colors">
                                            <i class="ri-external-link-line text-[#F5D061]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div class="w-full flex-shrink-0 px-4 project-card">
                            <div
                                class="group relative overflow-hidden bg-[#11172E] rounded-xl p-0 transition-all duration-500 max-w-[400px] mx-auto hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1">
                                <!-- Image Container -->
                                <div class="relative h-52 overflow-hidden">
                                    <img :src="'/images/projects/dbslibrary.png'" alt="Project 2"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-40 group-hover:opacity-60 transition-opacity duration-500">
                                    </div>
                                    <!-- Feature badge -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="bg-[#F5D061]/90 text-black text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="relative z-10 p-6 pt-5">
                                    <!-- Tech stack badges -->
                                    <div class="flex flex-wrap gap-2 mb-3 -mt-8">
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Laravel</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Vue.js</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Tailwind</span>
                                    </div>

                                    <!-- Project Info -->
                                    <h3
                                        class="text-xl font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">
                                        DBS Library - Library Management System</h3>
                                    <p class="text-gray-400 text-sm mb-5">A modern library management system with
                                        advanced features like book borrowing, reservation, and analytics.</p>

                                    <!-- Actions -->
                                    <div class="flex justify-between items-center">
                                        <a href="#"
                                            class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                            View Project
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                        <a href="#"
                                            class="w-9 h-9 rounded-full flex items-center justify-center bg-[#F5D061]/10 hover:bg-[#F5D061]/20 transition-colors">
                                            <i class="ri-external-link-line text-[#F5D061]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project 3 -->
                        <div class="w-full flex-shrink-0 px-4 project-card">
                            <div
                                class="group relative overflow-hidden bg-[#11172E] rounded-xl p-0 transition-all duration-500 max-w-[400px] mx-auto hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1">
                                <!-- Image Container -->
                                <div class="relative h-52 overflow-hidden">
                                    <img :src="'/images/projects/habi.png'" alt="Project 3"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-40 group-hover:opacity-60 transition-opacity duration-500">
                                    </div>
                                    <!-- Feature badge -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="bg-[#F5D061]/90 text-black text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="relative z-10 p-6 pt-5">
                                    <!-- Tech stack badges -->
                                    <div class="flex flex-wrap gap-2 mb-3 -mt-8">
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Laravel</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Vue.js</span>
                                        <span
                                            class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-full border border-[#F5D061]/20">Tailwind</span>
                                    </div>

                                    <!-- Project Info -->
                                    <h3
                                        class="text-xl font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">
                                        Habi - Pending Project</h3>
                                    <p class="text-gray-400 text-sm mb-5">A modern water-proofing company e-commerce
                                        website</p>

                                    <!-- Actions -->
                                    <div class="flex justify-between items-center">
                                        <a href="#"
                                            class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                            View Project
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                        <a href="#"
                                            class="w-9 h-9 rounded-full flex items-center justify-center bg-[#F5D061]/10 hover:bg-[#F5D061]/20 transition-colors">
                                            <i class="ri-external-link-line text-[#F5D061]"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Dots -->
                <div class="flex justify-center gap-2 mt-8">
                    <button v-for="(_, index) in 3" :key="index" @click="currentSlide = index"
                        class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-[#F5D061] w-8' : 'bg-gray-600 hover:bg-gray-500'">
                    </button>
                </div>

                <!-- Navigation Arrows -->
                <button @click="prevSlide"
                    class="group absolute cursor-pointer left-0 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/5 hover:bg-[#F5D061]/30 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button @click="nextSlide"
                    class="group absolute cursor-pointer right-0 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/5 hover:bg-[#F5D061]/30 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'ProjectShowcaseComponent',
    data() {
        return {
            currentSlide: 0,
            totalSlides: 3,
            autoPlay: true,
            interval: null
        }
    },
    methods: {
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides
        },
        startAutoPlay() {
            this.autoPlay = true;
            if (!this.interval) {
                this.interval = setInterval(() => {
                    if (this.autoPlay) {
                        this.nextSlide()
                    }
                }, 5000)
            }
        },
        stopAutoPlay() {
            this.autoPlay = false;
            if (this.interval) {
                clearInterval(this.interval)
                this.interval = null
            }
        }
    },
    mounted() {
        this.startAutoPlay()
        
        // Add scroll animation observer
        this.$nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add visible class to section title and subtitle
                        const title = entry.target.querySelector('.section-title');
                        const subtitle = entry.target.querySelector('.section-subtitle');
                        const projectCards = entry.target.querySelectorAll('.project-card');
                        
                        if (title) title.classList.add('visible');
                        
                        setTimeout(() => {
                            if (subtitle) subtitle.classList.add('visible');
                        }, 200);
                        
                        // Animate project cards with staggered delay
                        projectCards.forEach((card, index) => {
                            setTimeout(() => {
                                card.classList.add('visible');
                            }, 300 + (150 * index));
                        });
                        
                        // Unobserve after animation
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            // Observe the portfolio section
            const portfolioSection = document.getElementById('portfolio');
            if (portfolioSection) {
                observer.observe(portfolioSection);
            }
        });
    },
    beforeUnmount() {
        this.stopAutoPlay()
    }
}
</script>

<style scoped>
/* Project card animations */
.project-card {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.project-card.visible {
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
</style>