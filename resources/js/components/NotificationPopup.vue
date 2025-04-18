<template>
    <div v-if="visible" class="fixed bottom-8 right-8 z-[100] max-w-md w-full transform transition-all duration-500"
        :class="[visible ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0']">
        <div class="group relative bg-[#11172E]/90 backdrop-blur-md rounded-xl p-5 pr-10 border border-[#F5D061]/20 shadow-[0_0_50px_rgba(245,208,97,0.15)]">
            <!-- Decorative elements -->
            <div class="absolute -z-10 top-0 right-0 w-32 h-32 bg-[#F5D061]/5 rounded-full blur-[60px]"></div>
            <div class="absolute -z-10 bottom-0 left-0 w-32 h-32 bg-[#F5D061]/5 rounded-full blur-[60px]"></div>
            
            <!-- Close button -->
            <button @click="closeNotification" class="group absolute top-3 right-3 p-1.5 rounded-full bg-white/5 hover:bg-white/10 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Icon and content -->
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 flex-shrink-0 bg-[#F5D061]/10 rounded-full flex items-center justify-center shadow-[0_0_15px_rgba(245,208,97,0.2)]">
                    <i class="ri-notification-3-line text-[#F5D061] text-xl"></i>
                </div>
                <div>
                    <h3 class="font-russo text-white text-lg mb-1">{{ title }}</h3>
                    <p class="text-gray-400 text-sm">{{ message }}</p>
                    
                    <!-- Action button if provided -->
                    <button v-if="actionText" @click="handleAction" 
                        class="mt-3 px-4 py-2 bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black rounded-full text-sm font-russo hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-sm shadow-[#F5D061]/20 transform hover:-translate-y-0.5">
                        {{ actionText }}
                    </button>
                </div>
            </div>
            
            <!-- Progress bar -->
            <div class="absolute bottom-0 left-0 h-1 bg-[#F5D061]/40 rounded-b-xl" :style="{ width: `${progress}%` }"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NotificationPopup',
    props: {
        title: {
            type: String,
            default: 'Notification'
        },
        message: {
            type: String,
            default: 'This is a notification message'
        },
        duration: {
            type: Number,
            default: 5000 // 5 seconds
        },
        actionText: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            visible: false,
            progress: 100,
            timer: null,
            progressInterval: null
        }
    },
    methods: {
        show() {
            this.visible = true
            this.progress = 100
            
            // Clear any existing timers
            this.clearTimers()
            
            // Set up auto-close timer
            if (this.duration > 0) {
                this.timer = setTimeout(() => {
                    this.closeNotification()
                }, this.duration)
                
                // Set up progress bar
                const updateTime = 100 // Update every 100ms
                const steps = this.duration / updateTime
                const decrementAmount = 100 / steps
                
                this.progressInterval = setInterval(() => {
                    this.progress = Math.max(0, this.progress - decrementAmount)
                }, updateTime)
            }
        },
        closeNotification() {
            this.visible = false
            this.clearTimers()
            this.$emit('close')
        },
        handleAction() {
            this.closeNotification()
            this.$emit('action')
        },
        clearTimers() {
            if (this.timer) {
                clearTimeout(this.timer)
                this.timer = null
            }
            if (this.progressInterval) {
                clearInterval(this.progressInterval)
                this.progressInterval = null
            }
        }
    },
    beforeUnmount() {
        this.clearTimers()
    }
}
</script> 