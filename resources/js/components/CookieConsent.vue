<template>
    <Transition name="fade">
        <div v-if="showConsent" class="fixed -bottom-[1px] left-0 right-0 z-50 px-4 pt-4 md:p-6">
            <div class="glass-nav mx-auto max-w-4xl rounded-2xl border border-white/10 p-4 md:p-6 shadow-lg backdrop-blur-xl">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#F5D061]" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            <h3 class="text-lg md:text-xl font-russo text-white">Cookie Settings</h3>
                        </div>
                        <p class="text-sm md:text-base text-gray-300 leading-relaxed">
                            We use cookies to enhance your browsing experience and analyze site traffic.
                            By clicking "Accept", you consent to our use of cookies.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button @click="acceptCookies"
                            class="cta-button bg-[#F5D061] cursor-pointer text-black px-6 py-2.5 rounded-full font-russo text-sm hover:bg-[#F5D061]/90 transition-all duration-300 transform hover:scale-105 min-w-[120px]">
                            Accept All
                        </button>
                        <button @click="declineCookies"
                            class="secondary-button border cursor-pointer border-white/10 px-6 py-2.5 rounded-full font-russo text-sm text-white hover:bg-white/5 transition-all duration-300 transform hover:scale-105 min-w-[120px]">
                            Decline
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const showConsent = ref(false);

const COOKIE_CONSENT_KEY = 'cookie_consent_status';

const checkCookieConsent = () => {
    const consentStatus = localStorage.getItem(COOKIE_CONSENT_KEY);
    if (!consentStatus) {
        showConsent.value = true;
    }
};

const acceptCookies = () => {
    localStorage.setItem(COOKIE_CONSENT_KEY, 'accepted');
    showConsent.value = false;
    
    // Show welcome notification after 2 seconds
    setTimeout(() => {
        if (window.showGlobalNotification) {
            window.showGlobalNotification({
                title: 'Welcome!',
                message: 'Thanks for visiting my portfolio website. Feel free to explore my projects and services.',
                duration: 8000,
                actionText: 'Explore Projects'
            });
        }
    }, 2000);
    
    // Here you would typically initialize your tracking functionality
};

const declineCookies = () => {
    localStorage.setItem(COOKIE_CONSENT_KEY, 'declined');
    showConsent.value = false;
};

onMounted(() => {
    checkCookieConsent();
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

.glass-nav {
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.cta-button {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(245, 208, 97, 0.2);
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

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 208, 97, 0.3);
}

.secondary-button {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.05);
}

.secondary-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
}

.secondary-button:hover::before {
    transform: translateX(100%);
}

.secondary-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

@media (max-width: 640px) {
    .glass-nav {
        margin: 0 -1rem;
        border-radius: 1rem 1rem 0 0;
    }
}
</style>