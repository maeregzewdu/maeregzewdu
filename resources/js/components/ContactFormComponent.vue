<template>
    <div class="glass-nav p-8 rounded-xl border border-white/10">
        <h3 class="text-2xl font-russo mb-6">Send a Message</h3>
        
        <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-300 mb-2">Name</label>
                    <input 
                        type="text" 
                        v-model="form.name" 
                        class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-colors" 
                        placeholder="Your name"
                        :class="{'border-red-500/50': errors.name}">
                    <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Email</label>
                    <input 
                        type="email" 
                        v-model="form.email" 
                        class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-colors" 
                        placeholder="your@email.com"
                        :class="{'border-red-500/50': errors.email}">
                    <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
                </div>
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Subject</label>
                <input 
                    type="text" 
                    v-model="form.subject" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-colors" 
                    placeholder="Project type"
                    :class="{'border-red-500/50': errors.subject}">
                <p v-if="errors.subject" class="text-red-500 text-xs mt-1">{{ errors.subject[0] }}</p>
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Phone</label>
                <input 
                    type="tel" 
                    v-model="form.phone" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-colors" 
                    placeholder="+251 9XX XXX XXX"
                    :class="{'border-red-500/50': errors.phone}">
                <p v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone[0] }}</p>
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Message</label>
                <textarea 
                    v-model="form.message" 
                    class="w-full bg-[#1A2332] border border-white/10 rounded-lg px-4 py-3 focus:border-[#F5D061]/30 focus:outline-none transition-colors h-28" 
                    placeholder="Tell me about your project"
                    :class="{'border-red-500/50': errors.message}"></textarea>
                <p v-if="errors.message" class="text-red-500 text-xs mt-1">{{ errors.message[0] }}</p>
            </div>
            
            <button 
                type="submit" 
                class="w-full cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 py-3.5 rounded-full font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 flex items-center justify-center transform hover:-translate-y-0.5"
                :class="{ 'opacity-70 cursor-not-allowed': isSubmitting }" 
                :disabled="isSubmitting">
                <span v-if="!isSubmitting">Send Message</span>
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
            isSubmitting: false
        }
    },
    methods: {
        async submitForm() {
            this.isSubmitting = true
            this.errors = {}
            
            // Get the CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            
            try {
                const response = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(this.form)
                })
                
                const data = await response.json()
                
                if (response.ok) {
                    // Show success message via the notification system
                    if (window.showGlobalNotification) {
                        window.showGlobalNotification({
                            title: 'Success!',
                            message: 'Thank you for your message! I will get back to you as soon as possible.',
                            duration: 5000,
                            actionText: 'OK'
                        })
                    }
                    
                    // Reset form
                    this.form = {
                        name: '',
                        email: '',
                        subject: '',
                        phone: '',
                        message: ''
                    }
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors
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
                    })
                }
                console.error('Error submitting form:', error)
            } finally {
                this.isSubmitting = false
            }
        }
    }
}
</script> 