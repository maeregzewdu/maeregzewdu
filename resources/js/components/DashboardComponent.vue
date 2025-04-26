<template>
    <div class="dashboard-container bg-[#0F172A] min-h-[90vh] text-white">
        <!-- Overlay for blur effect -->
        <div v-if="!sidebarCollapsed && windowWidth < 640" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40"
            @click="toggleSidebar">
        </div>

        <!-- Floating Toggle Button -->
        <button v-if="sidebarCollapsed && windowWidth < 640" @click="toggleSidebar"
            class="fixed top-4 left-4 z-20 w-10 h-10 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
            <i class="ri-menu-unfold-line text-[#F5D061] text-xl"></i>
        </button>

        <!-- Logout Confirmation Modal -->
        <confirmation-modal :show="showLogoutModal" title="Confirm Logout"
            message="Are you sure you want to logout? You'll need to login again to access your dashboard."
            confirm-button-text="Logout" :is-loading="isLoading" @close="showLogoutModal = false"
            @confirm="confirmLogout" />

        <!-- Sidebar -->
        <div class="sidebar fixed left-0 top-0 h-full bg-[#0A1020] border-r border-white/5 p-4 sm:p-6 transition-all duration-300"
            :class="{
                'w-64': !sidebarCollapsed,
                'w-16 sm:w-16': sidebarCollapsed,
                'translate-x-0': !sidebarCollapsed || windowWidth >= 640,
                '-translate-x-full': sidebarCollapsed && windowWidth < 640,
                'z-50 shadow-xl': windowWidth < 640 && !sidebarCollapsed,
                'z-10': windowWidth >= 640 || sidebarCollapsed
            }">
            <div class="flex justify-between items-center mb-6 sm:mb-10">
                <a href="/">
                    <img v-if="!sidebarCollapsed" :src="'/images/logo/gold-logo.svg'" alt="Maereg Zewdu Logo"
                        class="w-[120px] sm:w-[150px]">
                </a>
                <button @click="toggleSidebar" class="cursor-pointer transition-all duration-300 ease-in-out">
                    <i class="ri-menu-fold-line hover:text-[#F5D061] text-lg sm:text-xl" v-if="!sidebarCollapsed"></i>
                    <i class="ri-menu-unfold-line hover:text-[#F5D061] text-lg sm:text-xl" v-else></i>
                </button>
            </div>
            <div v-if="!sidebarCollapsed" class="space-y-4 sm:space-y-6">
                <!-- Navigation Links -->
                <div class="space-y-2">
                    <a href="#" @click.prevent="handleNavClick('dashboard')"
                        class="nav-link flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors text-sm sm:text-base"
                        :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'dashboard' }">
                        <i class="ri-dashboard-line text-lg sm:text-xl"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" @click.prevent="handleNavClick('leads')"
                        class="nav-link flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors text-sm sm:text-base"
                        :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'leads' }">
                        <i class="ri-user-line text-lg sm:text-xl"></i>
                        <span>Leads</span>
                    </a>
                    <a href="#" @click.prevent="handleNavClick('messages')"
                        class="nav-link flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors text-sm sm:text-base"
                        :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'messages' }">
                        <i class="ri-mail-line text-lg sm:text-xl"></i>
                        <span>Messages</span>
                    </a>
                    <a href="#" @click.prevent="handleNavClick('projects')"
                        class="nav-link flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors text-sm sm:text-base"
                        :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'projects' }">
                        <i class="ri-folder-open-line text-lg sm:text-xl"></i>
                        <span>Projects</span>
                    </a>
                    <a href="#" @click.prevent="handleNavClick('settings')"
                        class="nav-link flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-[#F5D061]/10 text-gray-300 hover:text-[#F5D061] transition-colors text-sm sm:text-base"
                        :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'settings' }">
                        <i class="ri-settings-line text-lg sm:text-xl"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" @click.prevent="handleLogout"
                        class="nav-link flex cursor-pointer w-full items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-red-500/10 text-red-300 hover:red-[#F5D061] transition-colors text-sm sm:text-base">
                        <i class="ri-logout-box-line text-lg sm:text-xl"></i>
                        <span>Logout</span>
                    </a>
                </div>
                
                <!-- User Profile -->
                <div class="mt-auto pt-4 sm:pt-6 border-t border-white/5">
                    <div class="flex items-center gap-2 sm:gap-3 p-2 sm:p-3">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#F5D061]/20 flex items-center justify-center">
                            <i class="ri-user-fill text-[#F5D061]"></i>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-medium">Maereg Zewdu</p>
                            <p class="text-[10px] sm:text-xs text-gray-400">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-col items-center space-y-4 sm:space-y-6">
                <a href="#" @click.prevent="handleNavClick('dashboard')"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors"
                    :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'dashboard', 'text-gray-300': activeTab !== 'dashboard' }">
                    <i class="ri-dashboard-line text-lg sm:text-xl"></i>
                </a>
                <a href="#" @click.prevent="handleNavClick('leads')"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors"
                    :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'leads', 'text-gray-300': activeTab !== 'leads' }">
                    <i class="ri-user-line text-lg sm:text-xl"></i>
                </a>
                <a href="#" @click.prevent="handleNavClick('messages')"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors"
                    :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'messages', 'text-gray-300': activeTab !== 'messages' }">
                    <i class="ri-mail-line text-lg sm:text-xl"></i>
                </a>
                <a href="#" @click.prevent="handleNavClick('settings')"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors"
                    :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'settings', 'text-gray-300': activeTab !== 'settings' }">
                    <i class="ri-settings-line text-lg sm:text-xl"></i>
                </a>
                <a href="#" @click.prevent="handleNavClick('projects')"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/10 hover:text-[#F5D061] transition-colors"
                    :class="{ 'bg-[#F5D061]/10 text-[#F5D061]': activeTab === 'projects', 'text-gray-300': activeTab !== 'projects' }">
                    <i class="ri-folder-open-line text-lg sm:text-xl"></i>
                </a>
                <a href="/"
                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center text-gray-300 hover:text-[#F5D061] hover:bg-[#F5D061]/10 transition-colors">
                    <i class="ri-home-line text-lg sm:text-xl"></i>
                </a>

                <div class="mt-auto pt-4 sm:pt-6">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#F5D061]/20 flex items-center justify-center">
                        <i class="ri-user-fill text-[#F5D061]"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content transition-all duration-300 px-4 sm:px-6 h-[100vh]" :class="{
            'ml-0 mt-8': windowWidth < 640,
            'overflow-hidden': !sidebarCollapsed && windowWidth < 640,
            'overflow-y-auto': sidebarCollapsed || windowWidth >= 640,
            'ml-64': !sidebarCollapsed && windowWidth >= 640,
            'ml-16 sm:ml-16': sidebarCollapsed && windowWidth >= 640
        }">
            <!-- Header -->
            <header
                class="glass-nav p-3 sm:p-6 mx-auto rounded-xl my-3 sm:my-6 shadow-lg backdrop-blur-xl bg-opacity-20 border border-white/5 relative overflow-hidden">
                <!-- Decorative elements -->
                <div
                    class="absolute top-0 right-0 w-24 sm:w-32 h-24 sm:h-32 bg-[#F5D061]/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-16 sm:w-24 h-16 sm:h-24 bg-blue-500/5 rounded-full blur-xl translate-y-1/2 -translate-x-1/2">
                </div>

                <div class="gap-3 sm:gap-6">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div
                            class="w-8 h-8 sm:w-12 sm:h-12 rounded-md bg-[#F5D061]/10 flex items-center justify-center">
                            <i :class="{
                                'ri-dashboard-line text-[#F5D061] text-lg sm:text-2xl': activeTab === 'dashboard',
                                'ri-user-line text-[#F5D061] text-lg sm:text-2xl': activeTab === 'leads',
                                'ri-mail-line text-[#F5D061] text-lg sm:text-2xl': activeTab === 'messages',
                                'ri-settings-line text-[#F5D061] text-lg sm:text-2xl': activeTab === 'settings',
                                'ri-folder-open-line text-[#F5D061] text-lg sm:text-2xl': activeTab === 'projects'
                            }"></i>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-russo tracking-tight">{{
                                activeTab === 'dashboard' ? 'Dashboard' :
                                    (activeTab === 'leads' ? 'Leads Management' :
                                        (activeTab === 'messages' ? 'Messages Management' :
                                            (activeTab === 'projects' ? 'Projects Management' : 'Settings')))
                            }}</h1>
                            <p class="text-gray-400 text-[10px] sm:text-sm">Welcome back, Maereg</p>
                        </div>
                    </div>
                </div>

                <div v-if="activeTab !== 'dashboard' && activeTab !== 'settings'"
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-3 sm:mt-6 gap-2 sm:gap-4">
                    <div class="relative w-full flex-1 group">
                        <div
                            class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-[#F5D061] transition-colors">
                            <i class="ri-search-line text-sm sm:text-base"></i>
                        </div>
                        <input type="text" :name="activeTab === 'leads' ? 'searchLeads' : (activeTab === 'projects' ? 'searchProjects' : 'searchMessages')"
                            :placeholder="'Search ' + (activeTab === 'leads' ? 'leads' : (activeTab === 'projects' ? 'projects' : 'messages')) + '...'"
                            class="w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2.5 rounded-md bg-[#1A2332]/30 border border-white/5 text-white focus:outline-none focus:border-[#F5D061]/30 focus:bg-[#1A2332]/50 transition-all duration-300 text-sm"
                            v-model="searchQuery">
                    </div>
                    <div class="flex items-center gap-1 sm:gap-2 w-full sm:w-auto">
                        <button @click="toggleFilterPanel"
                            class="flex-1 cursor-pointer sm:flex-none px-2 sm:px-4 py-1.5 sm:py-2.5 rounded-md bg-[#1A2332]/30 border border-white/5 text-white hover:bg-[#1A2332]/50 transition-all duration-300 flex items-center justify-center gap-1 sm:gap-2 hover:scale-105">
                            <i class="ri-filter-3-line text-[#F5D061] text-sm sm:text-base"></i>
                            <span class="text-[10px] sm:text-sm">{{
                                activeTab === 'leads' ? 'Filter Leads' :
                                    activeTab === 'messages' ? 'Filter Messages' :
                                        activeTab === 'projects' ? 'Filter Projects' :
                                            'Filter'
                                }}
                            </span>
                    </button>
                        <button
                            @click="addNew(activeTab)"
                            class="flex-1 cursor-pointer sm:flex-none bg-[#F5D061] text-black px-2 sm:px-4 py-1.5 sm:py-2.5 rounded-md font-russo text-[10px] sm:text-sm flex items-center justify-center gap-1 sm:gap-2 hover:bg-[#F5D061]/90 transition-all duration-300 hover:scale-105">
                            <i class="ri-add-line text-sm sm:text-base"></i>
                            <span>{{
                                activeTab === 'leads' ? 'New Lead' :
                                    activeTab === 'messages' ? 'New Message' :
                                        activeTab === 'projects' ? 'New Project' :
                                            'Add New'
                            }}</span>
                    </button>
                    </div>
                </div>
            </header>

            <!-- Filter Panel -->
            <FilterPanel v-if="showFilterPanel && (activeTab === 'leads' || activeTab === 'messages' || activeTab === 'projects')" :type="activeTab"
                @apply-filters="handleFilters" @close="showFilterPanel = false" />

            <!-- Dashboard Content -->
            <div class="mt-4 sm:mt-4">
                <general-dashboard v-if="activeTab === 'dashboard'" :lead-count="leadCount"
                    :contact-count="contactCount" :recent-leads="recentLeads" :recent-messages="recentMessages"
                    :is-loading="isLoading" :error-message="errorMessage" :stats="statsData"
                    @change-tab="activeTab = $event" @retry="fetchDashboardData" />

                <!-- Leads Management Section -->
                <leads-section v-if="activeTab === 'leads'" :leads="leadsData.leads" :is-loading="isLoading"
                    :error-message="errorMessage" :search-query="searchQuery" :pagination="leadsData.pagination"
                    @apply-filters="handleFilters" @retry="fetchLeadsData" @go-to-page="handlePageChange"
                    @update:leads="updateLeads" @update-lead="updateLead" @notification="handleNotification"
                    @refresh="refreshCurrentTab" @delete-lead="deleteLead" />

                <!-- Messages Management Section -->
                <messages-section v-if="activeTab === 'messages'" :messages="messagesData.messages"
                    :is-loading="isLoading" :error-message="errorMessage" :search-query="searchQuery"
                    :pagination="messagesData.pagination" @retry="fetchMessagesData" @go-to-page="handlePageChange"
                    @refresh="fetchMessagesData(true)" @notification="handleNotification" @apply-filters="handleFilters" />

                <!-- Settings Section -->
                <SettingsSection v-if="activeTab === 'settings'" :is-loading="isLoading" :my-info="settingsData.myInfo"
                    :plans="settingsData.plans" :social-links="settingsData.socialLinks" :error-message="errorMessage"
                    @retry="fetchDashboardData" @notification="handleNotification" @link-deleted="handleLinkDeleted" />

                <!-- Projects Management Section -->
                <ProjectsSection v-if="activeTab === 'projects'" :projects="projectsData.projects" :is-loading="isLoading"
                    :error-message="errorMessage" :search-query="searchQuery" :pagination="projectsData.pagination"
                    @apply-filters="handleFilters" @retry="fetchProjectsData" @go-to-page="handlePageChange"
                    @refresh="fetchProjectsData(true)" @notification="handleNotification" />

            </div>
        </div>
    </div>
</template>

<script>
import GeneralDashboard from './dashboard/GeneralDashboard.vue';
import LeadsSection from './dashboard/LeadsSection.vue';
import MessagesSection from './dashboard/MessagesSection.vue';
import FilterPanel from './dashboard/FilterPanel.vue';
import SettingsSection from './dashboard/SettingsSection.vue';
import ConfirmationModal from './dashboard/ConfirmationModal.vue';
import ProjectsSection from './dashboard/ProjectsSection.vue';
import axios from 'axios';

export default {
    name: 'DashboardComponent',
    components: {
        GeneralDashboard,
        LeadsSection,
        MessagesSection,
        FilterPanel,
        SettingsSection,
        ProjectsSection,
        ConfirmationModal
    },
    data() {
        return {
            sidebarCollapsed: this.getSidebarState(),
            windowWidth: typeof window !== 'undefined' ? window.innerWidth : 1024,
            leadCount: 0,
            contactCount: 0,
            recentLeads: [],
            recentMessages: [],
            activeTab: 'dashboard',
            isLoading: false,
            errorMessage: null,
            showFilterPanel: false,
            showLogoutModal: false,
            searchQuery: '',
            filters: {},
            lastFetch: {
                leads: null,
                messages: null,
                projects: null
            },
            pagination: {
                leads: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                },
                messages: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                },
                projects: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                }
            },
            statsData: {
                leadIncrease: 0,
                messageIncrease: 0,
                activeProjects: 0,
                projectIncrease: 0,
                revenue: 0,
                revenueIncrease: 0
            },
            dashboardData: {
                stats: {},
                recentLeads: [],
                recentMessages: []
            },
            leadsData: {
                leads: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                }
            },
            messagesData: {
                messages: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                }
            },
            projectsData: {
                projects: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    per_page: 6,
                    total: 0
                }
            },
            settingsData: {
                myInfo: {},
                plans: [],
                socialLinks: []
            }
        }
    },

    methods: {
        // Cookie handling methods
        setCookie(name, value, days = 365) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        },

        getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        },

        getSidebarState() {
            const savedState = this.getCookie('sidebarCollapsed');
            return savedState ? savedState === 'true' : true;
        },

        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            this.setCookie('sidebarCollapsed', this.sidebarCollapsed);
        },

        handleResize() {
            this.windowWidth = window.innerWidth;
        },
        
        handleNavClick(tab) {
            this.searchQuery = '';
            this.filters = {};
            this.activeTab = tab;
            // Only collapse sidebar on mobile
            if (this.windowWidth < 640) {
                this.sidebarCollapsed = true;
            }

            // Set loading state when switching tabs
            this.isLoading = true;

            // Load data for the new tab
            if (tab === 'leads') {
                this.fetchLeadsData(true);
            } else if (tab === 'messages') {
                this.fetchMessagesData(true);
            } else if (tab === 'dashboard') {
                this.fetchDashboardData();
            } else if (tab === 'projects') {
                this.fetchProjectsData(true);
            } else if (tab === 'settings') {
                this.fetchSettingsData();
            }
        },

        toggleFilterPanel() {
            this.showFilterPanel = !this.showFilterPanel;
        },

        // Helper method to get CSRF token
        getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        },

        // Helper method for API requests
        async makeApiRequest(url, options = {}) {
            const token = this.getCsrfToken();
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            };

            try {
                const response = await fetch(url, { ...defaultOptions, ...options });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error(`API request failed: ${error.message}`);
                throw error;
            }
        },

        // API methods
        async fetchDashboardData() {
            this.isLoading = true;
            this.errorMessage = null;
            try {
                const response = await this.makeApiRequest('/api/dashboard/data');
                this.dashboardData = response;
                this.leadCount = response.leadCount;
                this.contactCount = response.contactCount;
                this.recentLeads = response.recentLeads;
                this.recentMessages = response.recentMessages;
                this.statsData = response.stats;
            } catch (error) {
                this.errorMessage = 'Failed to load dashboard data. Please try again.';
                console.error('Error fetching dashboard data:', error);
            } finally {
                this.isLoading = false;
            }
        },

        // Debounced search handler
        handleSearch() {
            // Clear any existing timeout
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            // Set a new timeout
            this.searchTimeout = setTimeout(() => {
                if (this.activeTab === 'leads') {
                    this.fetchLeadsData(true);
                } else if (this.activeTab === 'messages') {
                    this.fetchMessagesData(true);
                } else if (this.activeTab === 'projects') {
                    this.fetchProjectsData(true);
                }
            }, 300); // 300ms debounce delay
        },

        async handleFilters(filters) {
            try {
                // Store the filters for future use
                this.filters = { ...this.filters, ...filters };

                if (this.activeTab === 'leads') {
                    await this.fetchLeadsData(true, this.filters);
                } else if (this.activeTab === 'messages') {
                    await this.fetchMessagesData(true, this.filters);
                } else if (this.activeTab === 'projects') {
                    await this.fetchProjectsData(true, this.filters);
                }

                this.showFilterPanel = false;
            } catch (error) {
                console.error('Error applying filters:', error);
                this.errorMessage = 'Failed to apply filters. Please try again.';
            }
        },

        // Update the API methods to include pagination parameters
        async fetchLeadsData(force = false, filters = {}, page = 1) {
            const hasFilters = filters && Object.keys(filters).length > 0;

            // Only skip fetching if we have recent data and no filters/search query
            if (!force && this.lastFetch.leads &&
                (Date.now() - this.lastFetch.leads) < 300000 &&
                !this.searchQuery &&
                page === this.leadsData.pagination.current_page &&
                !hasFilters) {
                return;
            }

            this.isLoading = true;
            this.errorMessage = null;
            
            try {
                const searchParams = new URLSearchParams();

                if (hasFilters) {
                    Object.entries(filters).forEach(([key, value]) => {
                        // Only include non-empty and non-"all" values in the request
                        if (value !== '' && value !== 'all') {
                            searchParams.append(key, value);
                        }
                    });
                } else if (this.searchQuery) {
                    // If no filters, but a search query exists
                    searchParams.append('search', this.searchQuery);
                }

                searchParams.append('page', page);
                searchParams.append('per_page', this.leadsData.pagination.per_page);

                const endpoint = hasFilters
                    ? `/api/dashboard/leads/filter?${searchParams.toString()}`
                    : `/api/dashboard/leads?${searchParams.toString()}`;

                const data = await this.makeApiRequest(endpoint);

                this.leadsData.leads = data.leads;
                this.leadsData.pagination = data.pagination;
                this.lastFetch.leads = Date.now();
            } catch (error) {
                this.errorMessage = 'Failed to load leads data. Please try again.';
                console.error('Error fetching leads data:', error);
            } finally {
                    this.isLoading = false;
            }
        },

        async fetchMessagesData(force = false, filters = {}, page = 1) {
            const hasFilters = filters && Object.keys(filters).length > 0;

            // Only skip fetching if we have recent data and no filters/search query
            if (!force && this.lastFetch.messages &&
                (Date.now() - this.lastFetch.messages) < 300000 &&
                !this.searchQuery &&
                page === this.messagesData.pagination.current_page &&
                !hasFilters) {
                return;
            }

            this.isLoading = true;
            this.errorMessage = null;

            try {
                const searchParams = new URLSearchParams();

                // Apply filters if they exist
                if (hasFilters) {
                    Object.entries(filters).forEach(([key, value]) => {
                        if (value !== '') {
                            searchParams.append(key, value);
                        }
                    });
                } else if (this.searchQuery) {
                    // If no filters, but a search query exists
                    searchParams.append('search', this.searchQuery);
                }

                // Always add pagination parameters
                searchParams.append('page', page);
                searchParams.append('per_page', this.messagesData.pagination.per_page);

                // Determine the correct endpoint based on filters
                const endpoint = hasFilters
                    ? `/api/dashboard/messages/filter?${searchParams.toString()}`
                    : `/api/dashboard/messages?${searchParams.toString()}`;

                console.log(endpoint);

                const data = await this.makeApiRequest(endpoint);

                // Update the messages data and pagination
                this.messagesData.messages = data.messages;
                this.messagesData.pagination = data.pagination;
                this.lastFetch.messages = Date.now();
            } catch (error) {
                this.errorMessage = 'Failed to load messages data. Please try again.';
                console.error('Error fetching messages data:', error);
            } finally {
                    this.isLoading = false;
            }
        },
        
        async fetchProjectsData(force = false, filters = {}, page = 1) {
            const hasFilters = filters && Object.keys(filters).length > 0;

            // Only skip fetching if we have recent data and no filters/search query
            if (!force && this.lastFetch.projects &&
                (Date.now() - this.lastFetch.projects) < 300000 &&
                !this.searchQuery &&
                page === this.projectsData.pagination.current_page &&
                !hasFilters) {
                return;
            }

            this.isLoading = true;
            this.errorMessage = null;

            try {
                const searchParams = new URLSearchParams();

                // Apply filters if they exist
                if (hasFilters) {
                    Object.entries(filters).forEach(([key, value]) => {
                        if (value !== '') {
                            searchParams.append(key, value);
                        }
                    });
                } else if (this.searchQuery) {
                    // If no filters, but a search query exists
                    searchParams.append('search', this.searchQuery);
                }

                // Always add pagination parameters
                searchParams.append('page', page);
                searchParams.append('per_page', this.projectsData.pagination.per_page);

                // Determine the correct endpoint based on filters
                const endpoint = hasFilters
                    ? `/api/dashboard/projects/filter?${searchParams.toString()}`
                    : `/api/dashboard/projects?${searchParams.toString()}`;

                console.log(endpoint);

                const data = await this.makeApiRequest(endpoint);

                
                // Update the projects data and pagination
                this.projectsData.projects = data.projects;
                this.projectsData.pagination = data.pagination;
                this.lastFetch.projects = Date.now();
            } catch (error) {
                this.errorMessage = 'Failed to load projects data. Please try again.';
                console.error('Error fetching projects data:', error);
            } finally {
                    this.isLoading = false;
            }
        },

        // Pagination methods
        handlePageChange(page) {
            if (this.activeTab === 'leads') {
                this.fetchLeadsData(true, {}, page);
            } else if (this.activeTab === 'messages') {
                this.fetchMessagesData(true, {}, page);
            } else if (this.activeTab === 'projects') {
                this.fetchProjectsData(true, {}, page);
            }
        },

        // Refresh methods
        refreshCurrentTab() {
            switch (this.activeTab) {
                case 'dashboard':
                    this.fetchDashboardData();
                    break;
                case 'leads':
                    this.fetchLeadsData(true);
                    break;
                case 'messages':
                    this.fetchMessagesData(true);
                    break;
                case 'projects':
                    this.fetchProjectsData(true);
                    break;
            }
        },

        updateMessages(newMessages) {
            this.recentMessages = newMessages;
        },
        updateSearchQuery(event) {
            this.searchQuery = event.target.value;
        },

        // Handle notifications from child components
        handleNotification(notification) {
            // Use the global notification system if available
            if (window.showGlobalNotification) {
                window.showGlobalNotification({
                    title: notification.title || (notification.type === 'success' ? 'Success' : 'Error'),
                    message: notification.message,
                    duration: notification.duration || 5000,
                    actionText: notification.actionText || ''
                });
            } else {
                // Fallback to emitting the event if global notification is not available
                this.$emit('notification', notification);
            }
        },

        async applyFilters(filters) {
            this.isLoading = true;
            try {
                const endpoint = this.activeTab === 'leads'
                    ? '/api/dashboard/leads/filter'
                    : this.activeTab === 'messages'
                        ? '/api/dashboard/messages/filter'
                        : '/api/dashboard/projects/filter';

                const response = await axios.get(endpoint, { params: filters });

                if (this.activeTab === 'leads') {
                    this.leads = response.data.leads;
                    this.leadsPagination = response.data.pagination;
                } else if (this.activeTab === 'messages') {
                    this.messages = response.data.messages;
                    this.messagesPagination = response.data.pagination;
                } else if (this.activeTab === 'projects') {
                    this.projects = response.data.projects;
                    this.projectsPagination = response.data.pagination;
                }
            } catch (error) {
                console.error('Error applying filters:', error);
                this.error = 'Failed to apply filters. Please try again.';
            } finally {
                this.isLoading = false;
            }
        },

        // Update methods
        updateLeads(newLeads) {
            this.leadsData.leads = newLeads;
        },

        async updateLead(leadId, leadData) {
            this.isLoading = true;
            this.errorMessage = null;
            
            try {
                const response = await this.makeApiRequest(`/api/dashboard/leads/${leadId}`, {
                    method: 'PUT',
                    body: JSON.stringify(leadData)
                });

                // Update the lead in the leads array
                if (response.lead) {
                    this.leadsData.leads = this.leadsData.leads.map(lead =>
                        lead && lead.id === leadId ? response.lead : lead
                    ).filter(lead => lead); // Filter out any undefined leads
                }

                // Show success notification
                this.handleNotification({
                    type: 'success',
                    message: 'Lead updated successfully'
                });

                return response.lead;
            } catch (error) {
                this.errorMessage = 'Failed to update lead. Please try again.';
                console.error('Error updating lead:', error);

                // Show error notification
                this.handleNotification({
                    type: 'error',
                    message: 'Failed to update lead. Please try again.'
                });

                throw error;
            } finally {
                // Add a small delay before hiding the loading indicator to ensure it's visible
                setTimeout(() => {
                    this.isLoading = false;
                }, 300);
            }
        },

        async deleteLead(leadId) {
            this.isLoading = true;

            try {
                const response = await axios.delete(`/api/leads/${leadId}`);

                if (response.data.success) {
                    // Remove the lead from the local leads array
                    this.leadsData.leads = this.leadsData.leads.filter(lead => lead.id !== leadId);

                    // Show success notification
                    this.handleNotification({
                        type: 'success',
                        message: 'Lead deleted successfully'
                    });
                } else {
                    throw new Error(response.data.message || 'Failed to delete lead');
                }
            } catch (error) {
                console.error('Error deleting lead:', error);
                this.handleNotification({
                    type: 'error',
                    message: error.response?.data?.message || 'Failed to delete lead'
                });
            } finally {
                // Add a small delay before hiding the loading indicator
                setTimeout(() => {
                    this.isLoading = false;
                }, 300);
            }
        },

        async fetchSettingsData() {
            this.isLoading = true;
            this.errorMessage = null;
            
            try {
                const endpoint = '/api/dashboard/settings';
                const data = await this.makeApiRequest(endpoint);
                // Update the messages data and pagination
                this.settingsData.myInfo = data.myInfo;
                this.settingsData.plans = data.plans;
                this.settingsData.socialLinks = data.socialLinks;
            } catch (error) {
                this.errorMessage = 'Failed to load settings data. Please try again.';
                console.error('Error fetching settings data:', error);
            } finally {
                this.isLoading = false;
            }
        },

        handleLinkDeleted(deletedId) {
            this.settingsData.socialLinks = this.settingsData.socialLinks.filter(link => link.id !== deletedId);
        },

        async handleLogout() {
            if (this.windowWidth < 640) {
                this.sidebarCollapsed = true;
            }
            this.showLogoutModal = true;
        },

        async confirmLogout() {
            this.isLoading = true;

            try {
                // Send logout request to the server
                const response = await this.makeApiRequest('/api/logout', {
                    method: 'POST'
                });

                if (response.success) {
                    // Show success notification
                    this.handleNotification({
                        type: 'success',
                        message: 'Logged out successfully'
                    });

                    // Redirect to login page after a short delay
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1000);
                } else {
                    throw new Error(response.message || 'Logout failed');
                }
            } catch (error) {
                console.error('Logout error:', error);
                this.handleNotification({
                    type: 'error',
                    message: 'Failed to logout. Please try again.'
                });
                this.isLoading = false;
                this.showLogoutModal = false;
            }
        },
        addNew(tab) {
            if (tab === 'leads') {
                this.$emit('add-new-lead');
            } else if (tab === 'messages') {
                this.$emit('add-new-message');
            } else if (tab === 'projects') {
                window.location.href = '/projects/create';
            }
        }
    },
    watch: {
        // Add watcher for searchQuery
        searchQuery() {
            this.handleSearch();
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
            } else if (newTab === 'projects') {
                this.fetchProjectsData();
            } else if (newTab === 'settings') {
                this.fetchSettingsData();
            }
        });

        // Set up auto-refresh every 5 minutes
        this.refreshInterval = setInterval(() => {
            this.refreshCurrentTab();
        }, 300000);
    },
    mounted() {
        this.handleResize();
        window.addEventListener('resize', this.handleResize);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.handleResize);
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}
</script>

<style scoped>
.glass-nav {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px);
}

.sidebar {
    transition: all 0.3s ease-in-out;
}

@media (max-width: 640px) {
    .sidebar {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
}

.main-content {
    transition: all 0.3s ease-in-out;
    padding: 20px;
    -webkit-overflow-scrolling: touch;
    /* For smooth scrolling on iOS */
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
