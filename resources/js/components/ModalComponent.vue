<template>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Background overlay with increased blur -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-lg transition-opacity duration-500" @click="$emit('close')"></div>

        <!-- Modal panel -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-[#11172E]/90 backdrop-blur-md rounded-2xl max-w-2xl w-full p-8 border border-[#F5D061]/20 shadow-[0_0_60px_rgba(245,208,97,0.2)] transform transition-all duration-500"
                :class="{ 'opacity-100 translate-y-0 scale-100': modalReady, 'opacity-0 -translate-y-10 scale-95': !modalReady }">
                <!-- Decorative elements -->
                <div class="absolute -z-10 top-0 right-0 w-64 h-64 bg-[#F5D061]/5 rounded-full blur-[100px] animate-pulse-slow"></div>
                <div class="absolute -z-10 bottom-0 left-0 w-64 h-64 bg-[#F5D061]/5 rounded-full blur-[100px] animate-pulse-slow"></div>
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-blue-500/5 rounded-full blur-[80px] animate-pulse-slow"></div>
                
                <!-- Close button with better hover effect -->
                <button 
                    @click="$emit('close')"
                >
                    <i class="ri-close-line text-xl absolute top-5 right-5 w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full cursor-pointer border border-white/10 hover:border-white/20 text-gray-300 hover:text-white hover:rotate-90 transition-all duration-300"></i>
                </button>

                <!-- Modal content -->
                <div>
                    <!-- Header with improved glowing effect -->
                    <div class="mb-8 text-center">
                        <h3 class="text-3xl font-russo text-white mb-3 relative">
                            Get Started with <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F5D061] to-[#e9b730] drop-shadow-[0_0_8px_rgba(245,208,97,0.5)]">{{ selectedPlan.name }}</span>
                        </h3>
                        <p class="text-gray-300 text-sm">Fill in the form below to start your project journey</p>
                    </div>

                    <!-- Plan summary - enhanced glass card -->
                    <div class="bg-[#0F172A]/70 backdrop-blur-md p-5 rounded-xl mb-8 flex items-center border border-[#F5D061]/20 hover:border-[#F5D061]/30 transition-colors shadow-inner">
                        <div class="w-14 h-14 bg-gradient-to-br from-[#F5D061]/20 to-[#F5D061]/10 rounded-full flex items-center justify-center mr-5 shadow-[0_0_20px_rgba(245,208,97,0.25)] backdrop-blur-lg">
                            <svg class="w-7 h-7 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-russo text-white text-xl">{{ selectedPlan.name }} Plan</h4>
                            <p class="text-gray-400 text-sm">{{ selectedPlan.price }} · {{ selectedPlan.description }}</p>
                        </div>
                    </div>

                    <!-- Form with improved styling -->
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div>
                            <label class="block text-gray-200 mb-2 text-sm font-semibold">Your Name</label>
                            <input type="text" v-model="form.name"
                                class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all placeholder:text-gray-500"
                                placeholder="John Doe" required
                                :class="{'border-red-500/50': errors.name}">
                            <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-gray-200 mb-2 text-sm font-semibold">Email Address</label>
                                <input type="email" v-model="form.email"
                                    class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all placeholder:text-gray-500"
                                    placeholder="your@email.com" required
                                    :class="{'border-red-500/50': errors.email}">
                                <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-200 mb-2 text-sm font-semibold">Phone Number</label>
                                <input type="tel" v-model="form.phone"
                                    class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all placeholder:text-gray-500"
                                    placeholder="+251 9XX XXX XXX"
                                    :class="{'border-red-500/50': errors.phone}">
                                <p v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone[0] }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-200 mb-2 text-sm font-semibold">Project Details</label>
                            <textarea v-model="form.details"
                                class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all h-28 resize-none placeholder:text-gray-500"
                                placeholder="Tell us about your project requirements..."
                                :class="{'border-red-500/50': errors.message}"></textarea>
                            <p v-if="errors.message" class="text-red-500 text-xs mt-1">{{ errors.message[0] }}</p>
                        </div>

                        <input type="hidden" name="plan" :value="selectedPlan.name">

                        <div class="pt-3">
                            <button type="submit"
                                class="w-full cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 py-4 rounded-xl font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 flex items-center justify-center transform hover:-translate-y-1 hover:shadow-xl hover:shadow-[#F5D061]/30"
                                :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" :disabled="isSubmitting">
                                <span v-if="!isSubmitting" class="flex items-center">
                                    Submit Request
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ModalComponent',
    props: {
        show: {
            type: Boolean,
            default: false
        },
        selectedPlan: {
            type: Object,
            default: () => ({
                name: '',
                price: '',
                description: ''
            })
        }
    },
    data() {
        return {
            modalReady: false,
            form: {
                name: '',
                email: '',
                phone: '',
                details: ''
            },
            isSubmitting: false,
            errors: {}
        }
    },
    watch: {
        show(newVal) {
            if (newVal) {
                // Add a small delay to trigger the animation
                setTimeout(() => {
                    this.modalReady = true;
                }, 50);

                // Prevent body scrolling
                document.body.style.overflow = 'hidden';
            } else {
                this.modalReady = false;

                // Reset form
                this.form = {
                    name: '',
                    email: '',
                    phone: '',
                    details: '',
                };

                // Re-enable body scrolling
                document.body.style.overflow = 'auto';
            }
        }
    },
    methods: {
        async submitForm() {
            this.isSubmitting = true;
            this.errors = {};
            
            // Set subject field from plan name
            this.form.subject = `New ${this.selectedPlan.name} Plan Inquiry`;
            
            // Prepare form data with message field
            const formData = {
                name: this.form.name,
                email: this.form.email,
                phone: this.form.phone,
                description: this.form.details,
                plan: this.selectedPlan.name
            };
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            try {
                const response = await fetch('/lead', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Show success message via notification system
                    if (window.showGlobalNotification) {
                        window.showGlobalNotification({
                            title: 'Success!',
                            message: data.message || 'Your request has been submitted successfully. We will contact you soon.',
                            duration: 5000,
                            actionText: 'OK'
                        });
                    }
                    
                    // Reset form
                    this.form = {
                        name: '',
                        email: '',
                        phone: '',
                        details: '',
                        subject: ''
                    };
                    
                    // Close modal
                    this.$emit('close');
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                }
            } catch (error) {
                // Show error notification
                if (window.showGlobalNotification) {
                    window.showGlobalNotification({
                        title: 'Error',
                        message: 'Something went wrong. Please try again later.',
                        duration: 5000,
                        actionText: 'OK'
                    });
                }
                console.error('Error submitting form:', error);
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}
</script>

<style>
@keyframes pulse-slow {
  0%, 100% {
    opacity: 0.4;
  }
  50% {
    opacity: 0.7;
  }
}

.animate-pulse-slow {
  animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>