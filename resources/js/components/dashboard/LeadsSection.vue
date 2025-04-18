<template>
    <div class="p-6 space-y-8">
        <!-- Filter and Actions Bar -->
        <div class="glass-nav p-4 rounded-xl border border-white/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" v-model="searchQuery" placeholder="Search leads..." class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50">
                </div>
                <div class="w-full md:w-auto">
                    <select v-model="statusFilter" class="w-full px-4 py-2 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50 appearance-none">
                        <option value="all">All Status</option>
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="pending">Pending</option>
                        <option value="converted">Converted</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button class="cta-button bg-[#F5D061] text-black px-4 py-2 rounded-full font-russo text-sm flex items-center gap-2 w-full md:w-auto justify-center">
                    <i class="ri-add-line"></i>
                    Add Lead
                </button>
                <button class="px-4 py-2 rounded-full border border-white/10 hover:bg-[#1A2332] transition-colors flex items-center gap-2 w-full md:w-auto justify-center">
                    <i class="ri-download-line"></i>
                    Export
                </button>
            </div>
        </div>

        <!-- Loading state -->
        <div v-if="isLoading" class="flex flex-col items-center justify-center py-20">
            <div class="w-12 h-12 border-4 border-[#F5D061]/30 border-t-[#F5D061] rounded-full animate-spin mb-4"></div>
            <p class="text-gray-400">Loading leads...</p>
        </div>
        
        <!-- Error state -->
        <div v-else-if="errorMessage" class="glass-nav p-8 rounded-xl border border-red-500/50 flex flex-col items-center justify-center py-10">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-4">
                <i class="ri-error-warning-line text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-russo mb-2 text-red-400">Failed to Load Leads</h3>
            <p class="text-gray-400 mb-4">{{ errorMessage }}</p>
            <button @click="$emit('retry')" class="px-4 py-2 rounded-full bg-[#F5D061] text-black font-russo text-sm flex items-center gap-2">
                <i class="ri-refresh-line"></i>
                Retry
            </button>
        </div>

        <!-- Leads List -->
        <div v-else class="glass-nav rounded-xl border border-white/10">
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 p-4 border-b border-white/10 bg-[#1A2332]/50">
                <div class="col-span-3 font-russo text-sm text-gray-300">Name/Contact</div>
                <div class="col-span-2 font-russo text-sm text-gray-300">Plan</div>
                <div class="col-span-3 font-russo text-sm text-gray-300">Message</div>
                <div class="col-span-2 font-russo text-sm text-gray-300">Date</div>
                <div class="col-span-1 font-russo text-sm text-gray-300">Status</div>
                <div class="col-span-1 font-russo text-sm text-gray-300 text-right">Actions</div>
            </div>

            <!-- Leads Rows -->
            <div v-for="(lead, index) in filteredLeads" :key="'full-lead-'+index" class="grid grid-cols-12 gap-4 p-4 border-b border-white/5 hover:bg-[#1A2332]/50 transition-colors items-center">
                <div class="col-span-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-user-line text-[#F5D061]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ lead.name }}</p>
                            <p class="text-xs text-gray-400">{{ lead.email }}</p>
                            <p v-if="lead.phone" class="text-xs text-gray-400">{{ lead.phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <p v-if="lead.plan" class="text-sm px-3 py-1 bg-[#F5D061]/10 rounded-lg text-[#F5D061] inline-block">{{ lead.plan }}</p>
                    <p v-else class="text-sm text-gray-400">Not specified</p>
                </div>
                <div class="col-span-3">
                    <p class="text-sm text-gray-300 truncate">{{ lead.message || 'No message' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-300">{{ lead.created_at }}</p>
                </div>
                <div class="col-span-1">
                    <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{ 
                        'bg-green-500/20 text-green-400': lead.status === 'new',
                        'bg-blue-500/20 text-blue-400': lead.status === 'contacted',
                        'bg-yellow-500/20 text-yellow-400': lead.status === 'pending',
                        'bg-purple-500/20 text-purple-400': lead.status === 'converted',
                        'bg-red-500/20 text-red-400': lead.status === 'lost'
                    }">
                        {{ lead.status }}
                    </span>
                </div>
                <div class="col-span-1 flex justify-end gap-2">
                    <button @click="editLead(lead)" class="w-8 h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                        <i class="ri-edit-line text-[#F5D061]"></i>
                    </button>
                    <button @click="viewLead(lead)" class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center hover:bg-blue-500/20 transition-colors">
                        <i class="ri-eye-line text-blue-400"></i>
                    </button>
                </div>
            </div>

            <!-- No Results -->
            <div v-if="filteredLeads.length === 0" class="p-8 text-center">
                <div class="w-16 h-16 bg-[#1A2332] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-search-line text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-russo mb-2">No leads found</h3>
                <p class="text-gray-400">Try adjusting your search or filters</p>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && !errorMessage" class="flex justify-between items-center">
            <p class="text-sm text-gray-400">Showing {{ filteredLeads.length }} leads</p>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-arrow-left-s-line text-gray-400"></i>
                </button>
                <button class="w-8 h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center text-[#F5D061]">
                    1
                </button>
                <button class="w-8 h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors text-gray-400">
                    2
                </button>
                <button class="w-8 h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-arrow-right-s-line text-gray-400"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Lead View Modal -->
    <div v-if="selectedLead && showLeadModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-2xl font-russo">Lead Details</h3>
                <button @click="closeLeadModal" class="w-8 h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400"></i>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Lead Info -->
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                        <i class="ri-user-line text-[#F5D061] text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-russo">{{ selectedLead.name }}</h4>
                        <p class="text-gray-400">{{ selectedLead.email }}</p>
                        <p v-if="selectedLead.phone" class="text-gray-400">{{ selectedLead.phone }}</p>
                    </div>
                </div>
                
                <!-- Lead Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Plan</h5>
                        <p class="text-[#F5D061]">{{ selectedLead.plan || 'Not specified' }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Lead Status</h5>
                        <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{ 
                            'bg-green-500/20 text-green-400': selectedLead.status === 'new',
                            'bg-blue-500/20 text-blue-400': selectedLead.status === 'contacted',
                            'bg-yellow-500/20 text-yellow-400': selectedLead.status === 'pending',
                            'bg-purple-500/20 text-purple-400': selectedLead.status === 'converted',
                            'bg-red-500/20 text-red-400': selectedLead.status === 'lost'
                        }">
                            {{ selectedLead.status }}
                        </span>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Created</h5>
                        <p class="text-white">{{ selectedLead.created_at }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Source</h5>
                        <p class="text-white">Website Lead Form</p>
                    </div>
                </div>
                
                <!-- Lead Message -->
                <div class="bg-[#1A2332] p-4 rounded-lg">
                    <h5 class="text-sm font-russo mb-2 text-gray-300">Message</h5>
                    <p class="text-white whitespace-pre-line">{{ selectedLead.message || 'No message provided' }}</p>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t border-white/10">
                    <button class="cta-button bg-[#F5D061] text-black px-4 py-2 rounded-full font-russo text-sm flex items-center gap-2">
                        <i class="ri-mail-send-line"></i>
                        Send Email
                    </button>
                    <select v-model="selectedLead.status" class="px-4 py-2 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="pending">Pending</option>
                        <option value="converted">Converted</option>
                        <option value="lost">Lost</option>
                    </select>
                </div>
                
                <!-- Notes Input -->
                <div>
                    <h5 class="text-sm font-russo mb-2 text-gray-300">Add Note</h5>
                    <textarea class="w-full px-4 py-3 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50 min-h-[100px]" placeholder="Enter notes about this lead..."></textarea>
                    <button class="mt-2 px-4 py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white">
                        Add Note
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LeadsSection',
    props: {
        leads: {
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
        }
    },
    emits: ['retry'],
    data() {
        return {
            searchQuery: '',
            statusFilter: 'all',
            selectedLead: null,
            showLeadModal: false
        }
    },
    computed: {
        filteredLeads() {
            let filtered = [...this.leads];
            
            // Filter by status if not "all"
            if (this.statusFilter !== 'all') {
                filtered = filtered.filter(lead => lead.status === this.statusFilter);
            }
            
            // Filter by search query if not empty
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase().trim();
                filtered = filtered.filter(lead => 
                    lead.name.toLowerCase().includes(query) || 
                    lead.email.toLowerCase().includes(query) || 
                    (lead.phone && lead.phone.toLowerCase().includes(query)) ||
                    (lead.message && lead.message.toLowerCase().includes(query)) ||
                    (lead.plan && lead.plan.toLowerCase().includes(query))
                );
            }
            
            return filtered;
        }
    },
    methods: {
        viewLead(lead) {
            this.selectedLead = { ...lead };
            this.showLeadModal = true;
        },
        editLead(lead) {
            this.selectedLead = { ...lead };
            this.showLeadModal = true;
        },
        closeLeadModal() {
            this.selectedLead = null;
            this.showLeadModal = false;
        }
    }
}
</script> 