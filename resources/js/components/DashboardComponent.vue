<template>
    <div class="dashboard-container bg-[#0F172A] min-h-screen text-white">
        <!-- Sidebar -->
        <div class="sidebar fixed left-0 top-0 h-full w-64 bg-[#0A1020] border-r border-white/5 p-6 transition-all duration-300 z-10" :class="{'sidebar-collapsed': sidebarCollapsed}">
            <div class="flex justify-between items-center mb-10">
                <img v-if="!sidebarCollapsed" :src="'/images/logo/gold-logo.svg'" alt="Maereg Zewdu Logo" class="w-[150px]">
                <button @click="toggleSidebar" class="w-10 h-10 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                    <i class="ri-menu-fold-line text-[#F5D061]" v-if="!sidebarCollapsed"></i>
                    <i class="ri-menu-unfold-line text-[#F5D061]" v-else></i>
                </button>
            </div>
            <div v-if="!sidebarCollapsed" class="space-y-6">
                <!-- Navigation Links -->
                <div class="space-y-2">
                    <a href="#" @click.prevent="activeTab = 'dashboard'" class="nav-link flex items-center gap-3 p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'dashboard'}">
                        <i class="ri-dashboard-line text-xl"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" @click.prevent="activeTab = 'leads'" class="nav-link flex items-center gap-3 p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'leads'}">
                        <i class="ri-user-line text-xl"></i>
                        <span>Leads</span>
                    </a>
                    <a href="#" @click.prevent="activeTab = 'messages'" class="nav-link flex items-center gap-3 p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'messages'}">
                        <i class="ri-mail-line text-xl"></i>
                        <span>Messages</span>
                    </a>
                    <a href="#" class="nav-link flex items-center gap-3 p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors">
                        <i class="ri-settings-line text-xl"></i>
                        <span>Settings</span>
                    </a>
                    <a href="/" class="nav-link flex items-center gap-3 p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors">
                        <i class="ri-home-line text-xl"></i>
                        <span>Back to Home</span>
                    </a>
                </div>
                
                <!-- User Profile -->
                <div class="mt-auto pt-6 border-t border-white/5">
                    <div class="flex items-center gap-3 p-3">
                        <div class="w-10 h-10 rounded-full bg-[#F5D061]/20 flex items-center justify-center">
                            <i class="ri-user-fill text-[#F5D061]"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Maereg Zewdu</p>
                            <p class="text-xs text-gray-400">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-col items-center space-y-6">
                <a href="#" @click.prevent="activeTab = 'dashboard'" class="w-10 h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'dashboard', 'text-gray-300': activeTab !== 'dashboard'}">
                    <i class="ri-dashboard-line text-xl"></i>
                </a>
                <a href="#" @click.prevent="activeTab = 'leads'" class="w-10 h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'leads', 'text-gray-300': activeTab !== 'leads'}">
                    <i class="ri-user-line text-xl"></i>
                </a>
                <a href="#" @click.prevent="activeTab = 'messages'" class="w-10 h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors" :class="{'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'messages', 'text-gray-300': activeTab !== 'messages'}">
                    <i class="ri-mail-line text-xl"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-300 hover:text-[#F5D061] hover:bg-[#F5D061]/10 transition-colors">
                    <i class="ri-settings-line text-xl"></i>
                </a>
                <a href="/" class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-300 hover:text-[#F5D061] hover:bg-[#F5D061]/10 transition-colors">
                    <i class="ri-home-line text-xl"></i>
                </a>
                
                <div class="mt-auto pt-6">
                    <div class="w-10 h-10 rounded-full bg-[#F5D061]/20 flex items-center justify-center">
                        <i class="ri-user-fill text-[#F5D061]"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content transition-all duration-300" :class="{'ml-64': !sidebarCollapsed, 'ml-20': sidebarCollapsed}">
            <!-- Header -->
            <header class="glass-nav p-5 mx-auto rounded-xl my-6 shadow-lg backdrop-blur-xl bg-opacity-30 border border-white/10 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-russo">{{ activeTab === 'dashboard' ? 'Dashboard' : (activeTab === 'leads' ? 'Leads Management' : (activeTab === 'messages' ? 'Messages Management' : 'Dashboard')) }}</h1>
                    <p class="text-gray-400 text-sm">Welcome back, Maereg</p>
                </div>
                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                        <i class="ri-notification-3-line text-[#F5D061]"></i>
                    </button>
                    <button class="cta-button bg-[#F5D061] text-black px-4 py-2 rounded-full font-russo text-sm flex items-center gap-2">
                        <i class="ri-add-line"></i>
                        New Project
                    </button>
                </div>
            </header>

            <!-- Dashboard Content -->
            <general-dashboard 
                v-if="activeTab === 'dashboard'" 
                :lead-count="leadCount"
                :contact-count="contactCount"
                :recent-leads="recentLeads"
                :recent-messages="recentMessages"
                :is-loading="isLoading"
                :error-message="errorMessage"
                :stats="statsData"
                @change-tab="activeTab = $event"
                @retry="fetchDashboardData"
            />

            <!-- Leads Management Section -->
            <leads-section 
                v-if="activeTab === 'leads'" 
                :leads="recentLeads"
                :is-loading="isLoading"
                :error-message="errorMessage"
                @retry="fetchLeadsData"
            />

            <!-- Messages Management Section -->
            <messages-section 
                v-if="activeTab === 'messages'" 
                :messages="recentMessages"
                :is-loading="isLoading"
                :error-message="errorMessage"
                @retry="fetchMessagesData"
                @update:messages="updateMessages"
            />
        </div>
    </div>
</template>

<script>
import GeneralDashboard from './dashboard/GeneralDashboard.vue';
import LeadsSection from './dashboard/LeadsSection.vue';
import MessagesSection from './dashboard/MessagesSection.vue';

export default {
    name: 'DashboardComponent',
    components: {
        GeneralDashboard,
        LeadsSection,
        MessagesSection
    },
    data() {
        return {
            sidebarCollapsed: false,
            leadCount: 0,
            contactCount: 0,
            recentLeads: [],
            recentMessages: [],
            activeTab: 'dashboard',
            isLoading: true,
            errorMessage: null,
            statsData: {
                leadIncrease: 0,
                messageIncrease: 0,
                activeProjects: 0,
                projectIncrease: 0,
                revenue: 0,
                revenueIncrease: 0
            }
        }
    },
    methods: {
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
        },
        // API methods
        fetchDashboardData() {
            this.isLoading = true;
            this.errorMessage = null;
            
            fetch('/api/dashboard/data')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the component data with the API response
                    this.leadCount = data.leadCount;
                    this.contactCount = data.contactCount;
                    this.recentLeads = data.recentLeads;
                    this.recentMessages = data.recentMessages;
                    
                    // Update stats data
                    this.statsData = data.stats;
                    
                    this.isLoading = false;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                    this.errorMessage = 'Failed to load dashboard data. Please try again.';
                    this.isLoading = false;
                });
        },
        fetchLeadsData() {
            this.isLoading = true;
            this.errorMessage = null;
            
            fetch('/api/dashboard/leads')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.recentLeads = data.leads;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.error('Error fetching leads data:', error);
                    this.errorMessage = 'Failed to load leads data. Please try again.';
                    this.isLoading = false;
                });
        },
        fetchMessagesData() {
            this.isLoading = true;
            this.errorMessage = null;
            
            fetch('/api/dashboard/messages')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.recentMessages = data.messages;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.error('Error fetching messages data:', error);
                    this.errorMessage = 'Failed to load messages data. Please try again.';
                    this.isLoading = false;
                });
        },
        updateMessages(newMessages) {
            this.recentMessages = newMessages;
        }
    },
    created() {
        // Fetch the dashboard data when the component is created
        this.fetchDashboardData();
        
        // Add event listeners for tab changes to load the appropriate data
        this.$watch('activeTab', (newTab) => {
            if (newTab === 'leads') {
                this.fetchLeadsData();
            } else if (newTab === 'messages') {
                this.fetchMessagesData();
            }
        });
    }
}
</script>

<style scoped>
.glass-nav {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px);
}

.sidebar {
    width: 256px;
}

.sidebar-collapsed {
    width: 80px;
}

.main-content {
    padding: 20px;
}

/* Custom scrollbar for Webkit browsers */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(15, 23, 42, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: rgba(245, 208, 97, 0.3);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(245, 208, 97, 0.5);
}
</style>
