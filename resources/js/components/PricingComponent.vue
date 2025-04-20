<template>
    <section id="pricing" class="py-16 md:py-24 bg-[#0F172A] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-russo mb-3 md:mb-4">Choose Your Plan</h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">Select the perfect package for your website needs. All plans
                    include responsive design and modern technologies.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Pro Plan -->
                <div v-for="plan in plans" :key="plan.name" class="glass-nav p-8 md:p-8 rounded-xl border relative group" :class="plan.is_popular ? 'border-[#F5D061]/30' : 'border-gray-800'">
                    <div :class="plan.is_popular ? 'opacity-100' : 'opacity-0'" class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span
                            class="bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-3 md:px-4 py-1 rounded-full text-xs md:text-sm font-russo shadow-lg shadow-[#F5D061]/20">
                            Most Popular
                        </span>
                    </div>
                    <div class="text-center mb-6 md:mb-8">
                        <h3 class="text-xl md:text-2xl font-russo mb-2">{{ plan.name }}</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-3xl md:text-4xl price font-russo">{{ plan.price ? 'ETB ' + plan.price : 'Custom' }}</span>
                            <span class="text-gray-400 text-sm md:text-base" :class="plan.price ? '' : 'hidden'">/project</span>
                        </div>
                    </div>
                    <ul class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                        <li v-for="feature in plan.features" class="flex items-center gap-2 text-gray-300 text-sm md:text-base">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-[#F5D061] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="leading-relaxed">{{ feature }}</span>
                        </li>
                    </ul>
                    <button @click="plan.status == 'active' ? openModal('Pro', 'ETB 9999', 'Up to 5 pages with custom UI design') : ''"
                        class="w-full text-black px-4 md:px-6 py-2.5 md:py-3 rounded-full font-russo text-sm md:text-lg transition-all duration-300 transform hover:-translate-y-0.5" 
                        :class="plan.status == 'inactive' ? 'cursor-not-allowed text-gray-400 bg-gray-800 border border-gray-700' : 
                        (plan.is_popular ? 'hover:from-[#e9b730] cursor-pointer hover:to-[#F5D061] bg-gradient-to-r from-[#F5D061] to-[#e9b730] shadow-lg shadow-[#F5D061]/20' : 
                        'border border-gray-500 text-white cursor-pointer hover:bg-gray-200/20')">

                        {{ plan.status == 'active' ? (plan.price ? 'Get Started' : 'Contact Me') : 'Coming Soon' }}
                    </button>
                </div>
            </div>

            <div class="text-center mt-10 md:mt-16">
                <p class="text-gray-400 mb-3 md:mb-4 text-sm md:text-base">Need something different? Let's discuss your project!</p>
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
    }
}
</script>

<style scoped>
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
}

@media (max-width: 640px) {
    .glass-nav {
        margin: 0 -0.5rem;
    }
}
</style>