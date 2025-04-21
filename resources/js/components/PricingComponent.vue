<template>
    <section id="pricing" class="py-16 md:py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <!-- Futuristic grid lines -->
            <div class="absolute inset-0 grid-lines"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-russo mb-3 md:mb-4 section-title">Choose Your Plan</h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base section-subtitle">Select the perfect package for your website needs. All plans
                    include responsive design and modern technologies.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Pro Plan -->
                <div v-for="(plan, index) in plans" :key="plan.name" 
                    class="glass-nav p-8 md:p-8 rounded-xl border relative group pricing-card" 
                    :class="[plan.is_popular ? 'border-[#F5D061]/30' : 'border-gray-800', `card-${index}`]">
                    <!-- Glowing border effect for popular plan -->
                    <div v-if="plan.is_popular" class="glow-border"></div>
                    
                    <div :class="plan.is_popular ? 'opacity-100' : 'opacity-0'" class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                        <span
                            class="bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-3 md:px-4 py-1 rounded-full text-xs md:text-sm font-russo shadow-lg shadow-[#F5D061]/20 popular-badge">
                            Most Popular
                        </span>
                    </div>
                    <div class="text-center mb-6 md:mb-8">
                        <h3 class="text-xl md:text-2xl font-russo mb-2 plan-title">{{ plan.name }}</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-3xl md:text-4xl price font-russo plan-price">{{ plan.price ? 'ETB ' + plan.price : 'Custom' }}</span>
                            <span class="text-gray-400 text-sm md:text-base" :class="plan.price ? '' : 'hidden'">/project</span>
                        </div>
                    </div>
                    <ul class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                        <li v-for="(feature, fIndex) in plan.features" :key="fIndex" 
                            class="flex items-center gap-2 text-gray-300 text-sm md:text-base feature-item">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-[#F5D061] flex-shrink-0 feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="leading-relaxed">{{ feature }}</span>
                        </li>
                    </ul>
                    <button @click="plan.status == 'active' ? openModal('Pro', 'ETB 9999', 'Up to 5 pages with custom UI design') : ''"
                        class="w-full text-black px-4 md:px-6 py-2.5 md:py-3 rounded-full font-russo text-sm md:text-lg transition-all duration-300 transform hover:-translate-y-0.5 plan-button" 
                        :class="plan.status == 'inactive' ? 'cursor-not-allowed text-gray-400 bg-gray-800 border border-gray-700' : 
                        (plan.is_popular ? 'hover:from-[#e9b730] cursor-pointer hover:to-[#F5D061] bg-gradient-to-r from-[#F5D061] to-[#e9b730] shadow-lg shadow-[#F5D061]/20' : 
                        'border border-gray-500 text-white cursor-pointer hover:bg-gray-200/20')">

                        {{ plan.status == 'active' ? (plan.price ? 'Get Started' : 'Contact Me') : 'Coming Soon' }}
                    </button>
                </div>
            </div>

            <div class="text-center mt-10 md:mt-16">
                <p id="font-russo" class="text-gray-400 mb-3 md:mb-4 text-sm md:text-base cta-text">Need something different? Let's discuss your project!</p>
                <button @click="scheduleCall" target="_blank"
                    class="cta-button cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 md:px-8 py-2.5 md:py-3 rounded-full font-russo text-sm md:text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 transform hover:-translate-y-0.5">
                    Schedule a Call
                </button>
            </div>
        </div>
        <modal-component :show="showModal" :selected-plan="selectedPlan" @close="closeModal" />
    </section>
</template>

<script>
import ModalComponent from './ModalComponent.vue';

export default {
    name: 'PricingComponent',
    components: {
        ModalComponent
    },
    props: {
        plans: Array,
        myInfo: Object
    },
    data() {
        return {
            showModal: false,
            selectedPlan: {
                name: '',
                price: '',
                description: ''
            }
        }
    },
    methods: {
        openModal(planName, planPrice, planDescription) {
            this.selectedPlan = {
                name: planName,
                price: planPrice,
                description: planDescription
            };
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        scheduleCall() {
            const phone = this.myInfo.phone.replace('+', '');
            const waUrl = `https://wa.me/${phone}`;
            window.open(waUrl, '_blank');
        }
    },
    mounted() {
        // Add scroll animation observer
        this.$nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add visible class to section title and subtitle
                        const title = entry.target.querySelector('.section-title');
                        const subtitle = entry.target.querySelector('.section-subtitle');
                        const pricingCards = entry.target.querySelectorAll('.pricing-card');
                        const ctaText = entry.target.querySelector('.cta-text');
                        
                        if (title) title.classList.add('visible');
                        
                        setTimeout(() => {
                            if (subtitle) subtitle.classList.add('visible');
                        }, 200);
                        
                        // Animate pricing cards with staggered delay
                        pricingCards.forEach((card, index) => {
                            setTimeout(() => {
                                card.classList.add('visible');
                                
                                // Animate features within each card
                                const features = card.querySelectorAll('.feature-item');
                                features.forEach((feature, fIndex) => {
                                    setTimeout(() => {
                                        feature.classList.add('visible');
                                    }, 300 + (100 * fIndex));
                                });
                            }, 300 + (150 * index));
                        });
                        
                        // Animate CTA text
                        setTimeout(() => {
                            if (ctaText) ctaText.classList.add('visible');
                        }, 1000);
                        
                        // Unobserve after animation
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            // Observe the pricing section
            const pricingSection = document.getElementById('pricing');
            if (pricingSection) {
                observer.observe(pricingSection);
            }
        });
    }
}
</script>

<style scoped>
/* Base styles */
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
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.cta-button:hover::before {
    transform: translateX(100%);
}

.glass-nav {
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
}

/* Futuristic grid lines background */
.grid-lines {
    background-image: 
        linear-gradient(rgba(245, 208, 97, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(245, 208, 97, 0.1) 1px, transparent 1px);
    background-size: 30px 30px;
    opacity: 0.5;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 30px 30px;
    }
}

/* Glowing border for popular plan */
.glow-border {
    position: absolute;
    inset: 0;
    border-radius: 0.75rem;
    padding: 1px;
    background: linear-gradient(45deg, #F5D061, #e9b730, #F5D061);
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.pricing-card:hover .glow-border {
    opacity: 1;
}

/* Popular badge animation */
.popular-badge {
    animation: pulse 2s infinite;
    position: relative;
    display: inline-block;
    white-space: nowrap;
    z-index: 10;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(245, 208, 97, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(245, 208, 97, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(245, 208, 97, 0);
    }
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

/* Pricing card animations */
.pricing-card {
    opacity: 0;
    transform: translateY(40px) scale(0.95);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin-top: 1.5rem; /* Increased margin to accommodate the popular badge */
    position: relative;
    overflow: visible; /* Allow the badge to overflow */
}

.pricing-card.visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

.pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

/* Plan title animation */
.plan-title {
    position: relative;
    display: inline-block;
}

.plan-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #F5D061, #e9b730);
    transition: width 0.3s ease;
}

.pricing-card:hover .plan-title::after {
    width: 100%;
}

/* Plan price animation */
.plan-price {
    background: linear-gradient(90deg, #F5D061, #e9b730);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    transition: all 0.3s ease;
}

.pricing-card:hover .plan-price {
    transform: scale(1.05);
}

/* Feature item animations */
.feature-item {
    opacity: 0;
    transform: translateX(-10px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.feature-item.visible {
    opacity: 1;
    transform: translateX(0);
}

.feature-icon {
    transition: transform 0.3s ease;
}

.pricing-card:hover .feature-icon {
    transform: scale(1.2) rotate(5deg);
}

/* Plan button animation */
.plan-button {
    position: relative;
    overflow: hidden;
}

.plan-button::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    opacity: 0;
    transform: scale(0.5);
    transition: transform 0.5s ease, opacity 0.5s ease;
}

.plan-button:hover::after {
    opacity: 1;
    transform: scale(1);
}

/* CTA text animation */
.cta-text {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.cta-text.visible {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 640px) {
    .pricing-card {
        margin-top: 2rem; /* More space for the badge on mobile */
    }
    
    .popular-badge {
        font-size: 0.75rem; /* Slightly smaller text on mobile */
        padding: 0.25rem 0.75rem; /* Adjusted padding for mobile */
    }
}
</style>