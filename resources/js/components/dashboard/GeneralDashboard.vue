<template>
    <!-- Loading state -->
    <div v-if="isLoading" class="flex flex-col items-center justify-center py-20">
        <div class="w-12 h-12 border-4 border-[#F5D061]/30 border-t-[#F5D061] rounded-full animate-spin mb-4"></div>
        <p class="text-gray-400">Loading dashboard data...</p>
    </div>
    
    <!-- Error state -->
    <div v-else-if="errorMessage" class="glass-nav p-8 rounded-xl border border-red-500/50 flex flex-col items-center justify-center py-10">
        <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-4">
            <i class="ri-error-warning-line text-red-500 text-3xl"></i>
        </div>
        <h3 class="text-xl font-russo mb-2 text-red-400">Failed to Load Data</h3>
        <p class="text-gray-400 mb-4">{{ errorMessage }}</p>
        <button @click="$emit('retry')" class="px-4 py-2 rounded-full bg-[#F5D061] text-black font-russo text-sm flex items-center gap-2">
            <i class="ri-refresh-line"></i>
            Retry
        </button>
    </div>
    
    <!-- Dashboard content when data is loaded -->
    <template v-else>
        <div class="space-y-4">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Leads Card -->
                <div class="glass-nav p-6 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 cursor-pointer" @click="$emit('change-tab', 'leads')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Total Leads</p>
                            <h3 class="text-3xl font-russo mt-2">{{ leadCount }}</h3>
                            <p class="text-green-400 text-sm mt-2 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.leadIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                            <i class="ri-user-star-line text-[#F5D061] text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Messages Card -->
                <div class="glass-nav p-6 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 cursor-pointer" @click="$emit('change-tab', 'messages')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Messages</p>
                            <h3 class="text-3xl font-russo mt-2">{{ contactCount }}</h3>
                            <p class="text-green-400 text-sm mt-2 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.messageIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                            <i class="ri-message-3-line text-[#F5D061] text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="glass-nav p-6 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Active Projects</p>
                            <h3 class="text-3xl font-russo mt-2">{{ stats.activeProjects }}</h3>
                            <p class="text-green-400 text-sm mt-2 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.projectIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                            <i class="ri-code-box-line text-[#F5D061] text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="glass-nav p-6 rounded-xl border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-sm">Revenue</p>
                            <h3 class="text-3xl font-russo mt-2">ETB {{ stats.revenue.toLocaleString() }}</h3>
                            <p class="text-green-400 text-sm mt-2 flex items-center gap-1">
                                <i class="ri-arrow-up-s-line"></i>
                                <span>{{ stats.revenueIncrease }}% increase</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center">
                            <i class="ri-money-dollar-circle-line text-[#F5D061] text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Leads and Messages -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Leads -->
                <div class="glass-nav p-6 rounded-xl border border-white/10">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-russo">Recent Leads</h3>
                        <button @click="$emit('change-tab', 'leads')" class="text-[#F5D061] hover:underline text-sm font-russo flex items-center gap-1">
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                    <div class="space-y-4 max-h-[400px] overflow-auto pr-2">
                        <div v-for="(lead, index) in recentLeads.slice(0, 3)" :key="'lead-'+index" class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                                        <i class="ri-user-line text-[#F5D061]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ lead.name }}</p>
                                        <p class="text-sm text-gray-400">{{ lead.email }}</p>
                                        <p v-if="lead.phone" class="text-sm text-gray-400">{{ lead.phone }}</p>
                                        <p v-if="lead.plan" class="text-sm text-gray-400 mt-1">Plan: <span class="text-[#F5D061]">{{ lead.plan }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{ 
                                        'bg-green-500/20 text-green-400': lead.status === 'new',
                                        'bg-blue-500/20 text-blue-400': lead.status === 'contacted',
                                        'bg-yellow-500/20 text-yellow-400': lead.status === 'pending'
                                    }">
                                        {{ lead.status }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ lead.created_at }}</p>
                                </div>
                            </div>
                            <div v-if="lead.message" class="mt-3 pt-3 border-t border-white/5">
                                <p class="text-sm text-gray-300">{{ lead.message }}</p>
                            </div>
                        </div>
                        <div v-if="recentLeads.length === 0" class="text-center p-4">
                            <p class="text-gray-400">No leads yet</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="glass-nav p-6 rounded-xl border border-white/10">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-russo">Recent Messages</h3>
                        <button @click="$emit('change-tab', 'messages')" class="text-[#F5D061] hover:underline text-sm font-russo flex items-center gap-1">
                            View All
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                    <div class="space-y-4 max-h-[400px] overflow-auto pr-2">
                        <div v-for="(message, index) in recentMessages.slice(0, 3)" :key="'message-'+index" class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors" :class="{'bg-[#1A2332]/20': message.status === 'unread'}">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                                        <i class="ri-message-2-line text-[#F5D061]"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ message.name }}</p>
                                        <p class="text-sm text-gray-400">{{ message.email }}</p>
                                        <p v-if="message.phone" class="text-sm text-gray-400">{{ message.phone }}</p>
                                        <p v-if="message.subject" class="text-sm text-gray-400 mt-1">Subject: <span class="text-[#F5D061]">{{ message.subject }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{
                                        'bg-green-500/20 text-green-400': message.status === 'unread',
                                        'bg-gray-500/20 text-gray-400': message.status === 'read'
                                    }">
                                        {{ message.status }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ message.created_at }}</p>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-white/5">
                                <p class="text-sm text-gray-300">{{ message.message }}</p>
                            </div>
                        </div>
                        <div v-if="recentMessages.length === 0" class="text-center p-4">
                            <p class="text-gray-400">No messages yet</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-nav p-6 rounded-xl border border-white/10">
                <h3 class="text-xl font-russo mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <button class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors text-center">
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="ri-add-line text-[#F5D061] text-xl"></i>
                        </div>
                        <p class="text-sm">New Project</p>
                    </button>
                    <button class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors text-center">
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="ri-mail-send-line text-[#F5D061] text-xl"></i>
                        </div>
                        <p class="text-sm">Send Email</p>
                    </button>
                    <button class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors text-center">
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="ri-file-chart-line text-[#F5D061] text-xl"></i>
                        </div>
                        <p class="text-sm">Generate Report</p>
                    </button>
                    <button class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors text-center">
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="ri-user-add-line text-[#F5D061] text-xl"></i>
                        </div>
                        <p class="text-sm">Add User</p>
                    </button>
                    <button class="p-4 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors text-center">
                        <div class="w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="ri-settings-4-line text-[#F5D061] text-xl"></i>
                        </div>
                        <p class="text-sm">Settings</p>
                    </button>
                </div>
            </div>
        </div>
    </template>
</template>

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
    emits: ['change-tab', 'retry']
}
</script> 