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
            hasShownWelcome: localStorage.getItem('welcome_notification_shown') === 'true'
        }
    },
    methods: {
        showNotification(options = {}) {
            // Check if cookies are accepted
            const cookieConsent = localStorage.getItem('cookie_consent_status');
            if (cookieConsent !== 'accepted') {
                return; // Don't show notifications if cookies aren't accepted
            }

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
            // Check if cookies are accepted
            const cookieConsent = localStorage.getItem('cookie_consent_status');
            if (cookieConsent !== 'accepted') {
                return; // Don't show flash messages if cookies aren't accepted
            }

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
        // and cookies are accepted and welcome notification hasn't been shown before
        setTimeout(() => {
            const cookieConsent = localStorage.getItem('cookie_consent_status');
            if (!document.getElementById('laravel-success-message') && 
                cookieConsent === 'accepted' && 
                !this.hasShownWelcome) {
                this.showNotification()
                this.hasShownWelcome = true
                localStorage.setItem('welcome_notification_shown', 'true')
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