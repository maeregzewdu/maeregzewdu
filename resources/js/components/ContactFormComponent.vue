<template>
    <div class="glass-nav p-8 rounded-xl border border-white/10 contact-form-container">
        <h3 class="text-2xl font-russo mb-6 section-title">Send a Message</h3>
        
        <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label class="block text-gray-300 mb-2 label">Name</label>
                    <input 
                        type="text" 
                        v-model="form.name" 
                        class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-all duration-300 input-field" 
                        placeholder="Your name"
                        :class="{'border-red-500/50': errors.name}">
                    <p v-if="errors.name" class="text-red-500 text-xs mt-1 error-message">{{ errors.name[0] }}</p>
                </div>
                <div class="form-group">
                    <label class="block text-gray-300 mb-2 label">Email</label>
                    <input 
                        type="email" 
                        v-model="form.email" 
                        class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-all duration-300 input-field" 
                        placeholder="your@email.com"
                        :class="{'border-red-500/50': errors.email}">
                    <p v-if="errors.email" class="text-red-500 text-xs mt-1 error-message">{{ errors.email[0] }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="block text-gray-300 mb-2 label">Subject</label>
                <input 
                    type="text" 
                    v-model="form.subject" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-all duration-300 input-field" 
                    placeholder="Project type"
                    :class="{'border-red-500/50': errors.subject}">
                <p v-if="errors.subject" class="text-red-500 text-xs mt-1 error-message">{{ errors.subject[0] }}</p>
            </div>
            <div class="form-group">
                <label class="block text-gray-300 mb-2 label">Phone</label>
                <input 
                    type="tel" 
                    v-model="form.phone" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-all duration-300 input-field" 
                    placeholder="+251 9XX XXX XXX"
                    :class="{'border-red-500/50': errors.phone}">
                <p v-if="errors.phone" class="text-red-500 text-xs mt-1 error-message">{{ errors.phone[0] }}</p>
            </div>
            <div class="form-group">
                <label class="block text-gray-300 mb-2 label">Message</label>
                <textarea 
                    v-model="form.message" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-all duration-300 input-field h-28" 
                    placeholder="Tell me about your project"
                    :class="{'border-red-500/50': errors.message}"></textarea>
                <p v-if="errors.message" class="text-red-500 text-xs mt-1 error-message">{{ errors.message[0] }}</p>
            </div>
            
            <button 
                type="submit" 
                class="w-full cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 py-3.5 rounded-full font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 flex items-center justify-center transform hover:-translate-y-0.5 submit-button"
                :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" 
                :disabled="isSubmitting">
                <span v-if="!isSubmitting" class="button-content">Send Message</span>
                <span v-else class="flex items-center button-content">
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
        </form>
    </div>
</template>

<script>
export default {
    name: 'ContactFormComponent',
    data() {
        return {
            form: {
                name: '',
                email: '',
                subject: '',
                phone: '',
                message: ''
            },
            errors: {},
            isSubmitting: false,
            loading: false,
            error: null,
            success: false
        }
    },
    methods: {
        async submitForm() {
            this.isSubmitting = true
            this.errors = {}
            this.loading = true
            this.error = null
            this.success = false
            
            try {
                const response = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.form)
                })
                
                const data = await response.json()
                
                if (response.status === 422) {
                    this.errors = data.errors || {}
                    throw new Error(data.message || 'Validation failed')
                }

                if (data.success) {
                    this.success = true
                    this.form = {
                        name: '',
                        email: '',
                        subject: '',
                        phone: '',
                        message: ''
                    }
                    // Show success notification using global function
                    window.showGlobalNotification?.({
                        title: 'Success!',
                        message: data.message || 'Your message has been sent successfully!',
                        duration: 5000,
                        actionText: ''
                    })
                } else {
                    throw new Error(data.message || 'Failed to send message')
                }
            } catch (error) {
                console.error('Error submitting form:', error)
                this.error = error.message || 'An unexpected error occurred. Please try again.'
                // Show error notification using global function
                window.showGlobalNotification?.({
                    title: 'Error',
                    message: this.error,
                    duration: 5000,
                    actionText: ''
                })
            } finally {
                this.isSubmitting = false
                this.loading = false
            }
        }
    },
    mounted() {
        // Add scroll animation observer
        this.$nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add visible class to section title first
                        const sectionTitle = entry.target.querySelector('.section-title');
                        if (sectionTitle) {
                            sectionTitle.classList.add('visible');
                        }

                        // Add visible class to form elements with staggered delay
                        const formGroups = entry.target.querySelectorAll('.form-group');
                        const submitButton = entry.target.querySelector('.submit-button');
                        
                        // Animate form groups
                        formGroups.forEach((group, index) => {
                            setTimeout(() => {
                                group.classList.add('visible');
                            }, 200 + (100 * index));
                        });
                        
                        // Animate submit button last
                        setTimeout(() => {
                            if (submitButton) submitButton.classList.add('visible');
                        }, 200 + (100 * formGroups.length));
                        
                        // Unobserve after animation
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            // Observe the contact form container
            const formContainer = document.querySelector('.contact-form-container');
            if (formContainer) {
                observer.observe(formContainer);
            }
        });
    }
}
</script>

<style scoped>
/* Base styles */
.contact-form-container {
    position: relative;
    overflow: hidden;
}

.contact-form-container::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent, rgba(245, 208, 97, 0.05), transparent);
    opacity: 0;
    transition: opacity 0.5s ease;
}

.contact-form-container:hover::before {
    opacity: 1;
}

/* Section title animation */
.section-title {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.section-title.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Form group animations */
.form-group {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.form-group.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Label animations */
.label {
    position: relative;
    display: inline-block;
    transition: color 0.3s ease;
}

.label::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #F5D061, #e9b730);
    transition: width 0.3s ease;
}

.form-group:hover .label::after {
    width: 100%;
}

/* Input field animations */
.input-field {
    position: relative;
    transition: all 0.3s ease;
}

.input-field:focus {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 208, 97, 0.1);
}

.input-field::placeholder {
    transition: opacity 0.3s ease;
}

.input-field:focus::placeholder {
    opacity: 0.5;
}

/* Error message animation */
.error-message {
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.error-message.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Submit button animations */
.submit-button {
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.submit-button.visible {
    opacity: 1;
    transform: translateY(0);
}

.submit-button::before {
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

.submit-button:hover::before {
    transform: translateX(100%);
}

.button-content {
    position: relative;
    z-index: 1;
}

/* Loading spinner animation */
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style> 