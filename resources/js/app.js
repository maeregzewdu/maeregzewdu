import './bootstrap';
import { createApp } from 'vue';

// Import components
import App from './components/App.vue';
import PricingComponent from './components/PricingComponent.vue';
import ProjectShowcaseComponent from './components/ProjectShowcaseComponent.vue';
import ProjectsPageComponent from './components/ProjectsPageComponent.vue';
import NotificationManager from './components/NotificationManager.vue';
import ContactFormComponent from './components/ContactFormComponent.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import CookieConsent from './components/CookieConsent.vue';
import ProjectFormComponent from './components/project/Form.vue';

// Expose notification function globally
window.showGlobalNotification = null;

// Mount the main Vue application if the element exists
if (document.getElementById('app')) {
    createApp(App).mount("#app");
}

// Mount the pricing component if the element exists
if (document.getElementById('pricing-app')) {
    const el = document.getElementById('pricing-app');
    const plans = JSON.parse(el.dataset.plans);
    const myInfo = JSON.parse(el.dataset.myInfo);

    createApp(PricingComponent, {
        plans,
        myInfo
    }).mount("#pricing-app");
}

// Mount the project showcase component if the element exists
if (document.getElementById('portfolio-app')) {
    createApp(ProjectShowcaseComponent).mount("#portfolio-app");
}

// Mount the projects page component if the element exists
if (document.getElementById('projects-app')) {
    const el = document.getElementById('projects-app');
    
    // Safely parse JSON data with error handling
    let projects = [];
    let myInfo = {};
    
    try {
        projects = JSON.parse(el.dataset.projects || '[]');
        console.log('Parsed projects data:', projects);
    } catch (e) {
        console.error('Error parsing projects data:', e);
        projects = [];
    }
    
    try {
        myInfo = JSON.parse(el.dataset.myInfo || '{}');
    } catch (e) {
        console.error('Error parsing myInfo data:', e);
        myInfo = {};
    }

    try {
        const app = createApp(ProjectsPageComponent, {
            initialProjects: projects,
            myInfo
        });
        
        // Add error handler
        app.config.errorHandler = (err, vm, info) => {
            console.error('Vue Error:', err);
            console.error('Component:', vm);
            console.error('Error Info:', info);
        };
        
        app.mount("#projects-app");
        console.log('Projects app mounted successfully');
    } catch (e) {
        console.error('Failed to mount projects app:', e);
    }
}

// Mount the contact form component if the element exists
if (document.getElementById('contact-form-app')) {
    createApp(ContactFormComponent).mount("#contact-form-app");
}

// Mount the dashboard component if the element exists
if (document.getElementById('dashboard-app')) {
    createApp(DashboardComponent).mount("#dashboard-app");
}

// Mount the project form component if the element exists
if (document.getElementById('project-form-app')) {
    createApp(ProjectFormComponent).mount("#project-form-app");
}

if (document.getElementById('cookie-consent-app')) {
    createApp(CookieConsent).mount("#cookie-consent-app");
}

// Mount the notification manager
if (document.getElementById('notification-app')) {
    const notificationApp = createApp(NotificationManager);
    const notificationVM = notificationApp.mount("#notification-app");
    
    // Make notification function globally available
    window.showGlobalNotification = notificationVM.showNotification;
}
