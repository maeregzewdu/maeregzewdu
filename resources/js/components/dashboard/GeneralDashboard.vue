<template>
    <!-- Loading state -->
    <div v-if="isLoading" class="flex flex-col items-center justify-center py-12 sm:py-20">
        <div class="w-10 h-10 sm:w-12 sm:h-12 border-4 border-[#F5D061]/30 border-t-[#F5D061] rounded-full animate-spin mb-3 sm:mb-4"></div>
        <p class="text-gray-400 text-sm sm:text-base">Loading dashboard data...</p>
    </div>
    
    <!-- Error state -->
    <div v-else-if="errorMessage" class="glass-nav p-6 sm:p-8 rounded-xl border border-red-500/50 flex flex-col items-center justify-center py-8 sm:py-10">
        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-3 sm:mb-4">
            <i class="ri-error-warning-line text-red-500 text-2xl sm:text-3xl"></i>
        </div>
        <h3 class="text-lg sm:text-xl font-russo mb-2 text-red-400">Failed to Load Data</h3>
        <p class="text-gray-400 text-sm sm:text-base mb-3 sm:mb-4 text-center">{{ errorMessage }}</p>
        <button @click="$emit('retry')" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-[#F5D061] text-black font-russo text-xs sm:text-sm flex items-center gap-2">
            <i class="ri-refresh-line"></i>
            Retry
        </button>
    </div>
    
    <!-- Dashboard content when data is loaded -->
    <template v-else>
        <div class="space-y-4 sm:space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Leads Card -->
                <div class="glass-nav p-3 sm:p-4 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300 cursor-pointer group" @click="$emit('change-tab', 'leads')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs">Total Leads</p>
                            <h3 class="text-xl sm:text-2xl font-russo mt-1">{{ leadCount }}</h3>
                            <p class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.leadIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-[#F5D061]/10 rounded-lg flex items-center justify-center group-hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-user-star-line text-[#F5D061] text-base sm:text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Messages Card -->
                <div class="glass-nav p-3 sm:p-4 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300 cursor-pointer group" @click="$emit('change-tab', 'messages')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs">Messages</p>
                            <h3 class="text-xl sm:text-2xl font-russo mt-1">{{ contactCount }}</h3>
                            <p class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.messageIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-[#F5D061]/10 rounded-lg flex items-center justify-center group-hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-message-3-line text-[#F5D061] text-base sm:text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="glass-nav p-3 sm:p-4 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs">Active Projects</p>
                            <h3 class="text-xl sm:text-2xl font-russo mt-1">{{ stats.activeProjects }}</h3>
                            <p class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.projectIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-[#F5D061]/10 rounded-lg flex items-center justify-center group-hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-code-box-line text-[#F5D061] text-base sm:text-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="glass-nav p-3 sm:p-4 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-xs">Revenue</p>
                            <h3 class="text-xl sm:text-2xl font-russo mt-1">ETB {{ formatNumberK(stats.revenue) }}</h3>
                            <p class="text-green-400 text-xs mt-1 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.revenueIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-[#F5D061]/10 rounded-lg flex items-center justify-center group-hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-money-dollar-circle-line text-[#F5D061] text-base sm:text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Leads and Messages -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Recent Leads -->
                <div class="glass-nav p-4 sm:p-5 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                                <i class="ri-user-line text-[#F5D061]"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-russo">Recent Leads</h3>
                        </div>
                        <button @click="$emit('change-tab', 'leads')" class="text-[#F5D061] hover:text-[#9b8647] text-xs sm:text-sm font-medium flex items-center gap-1 transition-colors">
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                    <div class="space-y-2 sm:space-y-3 max-h-[280px] sm:max-h-[320px] overflow-auto pr-2">
                        <div v-for="(lead, index) in recentLeads.slice(0, 3)" :key="'lead-'+index" 
                             class="p-3 rounded-lg bg-[#1A2332]/80 hover:bg-[#232f45] transition-all duration-300 group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">{{ lead.name }}</p>
                                    <p class="text-xs text-gray-400">{{ lead.email }}</p>
                                    <p v-if="lead.phone" class="text-xs text-gray-400">{{ lead.phone }}</p>
                                    <p v-if="lead.plan" class="text-xs text-gray-400 mt-1">Plan: <span class="text-[#F5D061]">{{ lead.plan }}</span></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium" :class="{ 
                                        'bg-green-500/20 text-green-400': lead.status === 'new',
                                        'bg-blue-500/20 text-blue-400': lead.status === 'contacted',
                                        'bg-yellow-500/20 text-yellow-400': lead.status === 'pending',
                                        'bg-gray-500/20 text-gray-400': lead.status === 'lost',
                                        'bg-red-500/20 text-red-400': lead.status === 'rejected'

                                    }">
                                        {{ lead.status }}
                                    </span>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ lead.created_at }}</p>
                                </div>
                            </div>
                            <div v-if="lead.message" class="mt-2 pt-2 border-t border-white/5">
                                <p class="text-xs text-gray-300 line-clamp-2">{{ lead.message }}</p>
                            </div>
                        </div>
                        <div v-if="recentLeads.length === 0" class="text-center p-3">
                            <p class="text-gray-400 text-sm">No leads yet</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="glass-nav p-4 sm:p-5 rounded-xl border border-white/10 backdrop-blur-sm hover:border-[#F5D061]/20 transition-all duration-300">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                                <i class="ri-message-2-line text-[#F5D061]"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-russo">Recent Messages</h3>
                        </div>
                        <button @click="$emit('change-tab', 'messages')" class="text-[#F5D061] hover:text-[#9b8647] text-xs sm:text-sm font-medium flex items-center gap-1 transition-colors">
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                    <div class="space-y-2 sm:space-y-3 max-h-[280px] sm:max-h-[320px] overflow-auto pr-2">
                        <div v-for="(message, index) in recentMessages.slice(0, 3)" :key="'message-'+index" 
                             class="p-3 rounded-lg transition-all duration-300 group" 
                             :class="{
                                'bg-[#1A2332]/80 hover:bg-[#232f45]': message.status === 'read',
                                'bg-[#1A2332]/90 hover:bg-[#232f45] border-l-2 border-[#F5D061]': message.status === 'unread'
                             }">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">{{ message.name }}</p>
                                    <p class="text-xs text-gray-400">{{ message.email }}</p>
                                    <p v-if="message.phone" class="text-xs text-gray-400">{{ message.phone }}</p>
                                    <p v-if="message.subject" class="text-xs text-gray-400 mt-1">Subject: <span class="text-[#F5D061]">{{ message.subject }}</span></p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium" :class="{
                                        'bg-green-500/20 text-green-400': message.status === 'unread',
                                        'bg-gray-500/20 text-gray-400': message.status === 'read'
                                    }">
                                        {{ message.status }}
                                    </span>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ message.created_at }}</p>
                                </div>
                            </div>
                            <div class="mt-2 pt-2 border-t border-white/5">
                                <p class="text-xs text-gray-300 line-clamp-2">{{ message.message }}</p>
                            </div>
                        </div>
                        <div v-if="recentMessages.length === 0" class="text-center p-3">
                            <p class="text-gray-400 text-sm">No messages yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</template>

<style>
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

<script>
export default {
    name: 'GeneralDashboard',
    props: {
        leadCount: {
            type: Number,
            default: 0
        },
        contactCount: {
            type: Number,
            default: 0
        },
        recentLeads: {
            type: Array,
            default: () => []
        },
        recentMessages: {
            type: Array,
            default: () => []
        },
        isLoading: {
            type: Boolean,
            default: false
        },
        errorMessage: {
            type: String,
            default: null
        },
        stats: {
            type: Object,
            default: () => ({
                leadIncrease: 0,
                messageIncrease: 0,
                activeProjects: 0,
                projectIncrease: 0,
                revenue: 0,
                revenueIncrease: 0
            })
        }
    },
    emits: ['change-tab', 'retry'],
    methods: {
        formatNumberK(number) {
            if (number >= 1000000) {
                return (number / 1000000).toFixed(1) + 'M';
            } else if (number >= 1000) {
                return (number / 1000).toFixed(1) + 'K';
            } else {
                return number.toLocaleString();
            }
        }
    }
}
</script> 