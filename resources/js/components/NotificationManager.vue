<template>
    <div>
        <notification-popup
            ref="notification"
            :title="notification.title"
            :message="notification.message"
            :duration="notification.duration"
            :action-text="notification.actionText"
            @close="onClose"
            @action="onAction"
        />
    </div>
</template>

<script>
import NotificationPopup from './NotificationPopup.vue';

export default {
    name: 'NotificationManager',
    components: {
        NotificationPopup
    },
    data() {
        return {
            notification: {
                title: 'Welcome!',
                message: 'Thanks for visiting my portfolio website. Feel free to explore my projects and services.',
                duration: 8000,
                actionText: 'Explore Projects',
                callback: null
            },
            hasShownWelcome: false
        }
    },
    methods: {
        showNotification(options = {}) {
            // Merge default options with provided options
            this.notification = {
                ...this.notification,
                ...options
            }
            this.$refs.notification.show()
        },
        onClose() {
            // Placeholder for any close actions
        },
        onAction() {
            // Execute callback if provided
            if (typeof this.notification.callback === 'function') {
                this.notification.callback()
            } else {
                // Default action - scroll to projects section
                const portfolioSection = document.getElementById('portfolio')
                if (portfolioSection) {
                    portfolioSection.scrollIntoView({ behavior: 'smooth' })
                }
            }
        },
        checkForFlashMessages() {
            // Check if there's a success message in Laravel's session
            const successElement = document.getElementById('laravel-success-message')
            if (successElement) {
                const message = successElement.getAttribute('data-message')
                if (message) {
                    // Show success notification
                    this.showNotification({
                        title: 'Success!',
                        message: message,
                        duration: 5000,
                        actionText: ''
                    })
                    
                    // Remove the element to prevent showing the message again on page refresh
                    successElement.remove()
                }
            }
        }
    },
    mounted() {
        // Check for Laravel flash messages first
        this.checkForFlashMessages()
        
        // Then show welcome notification after a delay, but only if no flash message was shown
        setTimeout(() => {
            if (!document.getElementById('laravel-success-message')) {
                this.showNotification()
                this.hasShownWelcome = true
            }
        }, 1500)
        
        // Add event listener for page navigation/form submissions
        window.addEventListener('pageshow', () => {
            // Check again for flash messages when navigating back
            if (this.hasShownWelcome) {
                this.checkForFlashMessages()
            }
        })
    }
}
</script> 