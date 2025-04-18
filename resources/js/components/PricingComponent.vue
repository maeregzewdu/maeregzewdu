<template>
    <section id="pricing" class="py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-russo mb-4">Choose Your Plan</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Select the perfect package for your website needs. All plans
                    include responsive design and modern technologies.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Basic Plan -->
                <div
                    class="glass-nav p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-russo mb-2">Basic</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-4xl font-russo">ETB 4999</span>
                            <span class="text-gray-400">/project</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            1-page modern website
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Responsive Design
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Custom branding
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Contact form integration
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Basic SEO Setup
                        </li>
                    </ul>
                    <button @click="openModal('Basic', 'ETB 4999', '1-page modern website')" class="w-full cursor-pointer glass-nav border border-[#F5D061]/30 px-6 py-3 rounded-full font-russo text-lg hover:bg-[#F5D061]/10 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg shadow-black/20">
                        Get Started
                    </button>
                </div>

                <!-- Pro Plan -->
                <div class="glass-nav p-8 rounded-xl border border-[#F5D061]/30 relative group">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-4 py-1 rounded-full text-sm font-russo shadow-lg shadow-[#F5D061]/20">Most Popular</span>
                    </div>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-russo mb-2">Pro</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-4xl font-russo">ETB 9999</span>
                            <span class="text-gray-400">/project</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Up to 5 pages
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Responsive design
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Branding + custom UI design
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Admin panel (if needed)
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Advanced SEO
                        </li>
                    </ul>
                    <button @click="openModal('Pro', 'ETB 9999', 'Up to 5 pages with custom UI design')" class="w-full cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 py-3 rounded-full font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 transform hover:-translate-y-0.5">
                        Get Started
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div
                    class="glass-nav p-8 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-russo mb-2">Enterprise</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-4xl font-russo">Custom</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Unlimited Pages
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Custom Features
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Priority Support
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            API Integration
                        </li>
                        <li class="flex items-center gap-2 text-gray-300">
                            <svg class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Custom Development
                        </li>
                    </ul>
                    <button @click="openModal('Enterprise', 'Custom Pricing', 'Custom solutions for your business')" class="w-full cursor-pointer glass-nav border border-[#F5D061]/30 px-6 py-3 rounded-full font-russo text-lg hover:bg-[#F5D061]/10 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg shadow-black/20">
                        Contact Us
                    </button>
                </div>
            </div>

            <div class="text-center mt-16">
                <p class="text-gray-400 mb-4">Need something different? Let's discuss your project!</p>
                <button onclick="window.location.href = 'https://wa.me/251965598182'" target="_blank" class="cta-button cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-8 py-3 rounded-full font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 transform hover:-translate-y-0.5">
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
        }
    }
}
</script>