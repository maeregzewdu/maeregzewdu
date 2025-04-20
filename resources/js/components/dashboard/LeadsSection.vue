<template>
    <div class="space-y-6">
        <!-- Plan Filter Navigation -->
        <div 
            v-if="leads.length > 0" 
            class="flex flex-wrap justify-center gap-1 sm:gap-2 mb-4"
        >
            <button 
                @click="setPlanFilter('all')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-[#F5D061] text-black': planFilter === 'all',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': planFilter !== 'all'
                }">
                All Plans
            </button>
            <button 
                @click="setPlanFilter('Basic')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-blue-500 text-white': planFilter === 'Basic',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': planFilter !== 'Basic'
                }">
                Basic
            </button>
            <button 
                @click="setPlanFilter('Pro')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-purple-500 text-white': planFilter === 'Pro',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': planFilter !== 'Pro'
                }">
                Pro
            </button>
            <button 
                @click="setPlanFilter('Enterprise')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-green-500 text-white': planFilter === 'Enterprise',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': planFilter !== 'Enterprise'
                }">
                Enterprise
            </button>
        </div>

        <!-- Loading State -->
        <div v-if="localLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="i in 6" :key="i" class="bg-[#1A2332] dark:bg-gray-800 rounded-xl shadow-lg border border-white/5 p-4 sm:p-5">
                <!-- Lead Header Skeleton -->
                <div class="flex justify-between items-start mb-3 sm:mb-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-24 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                    </div>
                    <div class="w-16 h-4 bg-gray-700/50 rounded-full animate-pulse"></div>
                </div>
                
                <!-- Plan Badge Skeleton -->
                <div class="mb-3 sm:mb-4 p-2 rounded-lg bg-gray-700/30">
                    <div class="w-20 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
                
                <!-- Lead Message Skeleton -->
                <div class="mb-3 sm:mb-4">
                    <div class="w-full h-3 bg-gray-700/50 rounded animate-pulse mb-2"></div>
                    <div class="w-3/4 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
                
                <!-- Lead Footer Skeleton -->
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <div class="w-20 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                    <div class="flex space-x-2">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div v-else-if="errorMessage" class="text-center py-12">
            <p class="text-red-500 mb-4">{{ errorMessage }}</p>
            <button @click="$emit('retry')" class="bg-[#f5d061] text-black px-4 py-2 rounded-md hover:bg-[#9b8647] transition-colors">
                Try Again
            </button>
        </div>
        
        <!-- Skeleton Loading State -->
        <div v-else-if="isLoading && !leads.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="i in 6" :key="i" class="bg-[#1A2332] dark:bg-gray-800 rounded-xl shadow-lg border border-white/5 p-4 sm:p-5">
                <!-- Lead Header Skeleton -->
                <div class="flex justify-between items-start mb-3 sm:mb-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-24 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                    </div>
                    <div class="w-16 h-4 bg-gray-700/50 rounded-full animate-pulse"></div>
                </div>
                
                <!-- Plan Badge Skeleton -->
                <div class="mb-3 sm:mb-4 p-2 rounded-lg bg-gray-700/30">
                    <div class="w-20 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
                
                <!-- Lead Message Skeleton -->
                <div class="mb-3 sm:mb-4">
                    <div class="w-full h-3 bg-gray-700/50 rounded animate-pulse mb-2"></div>
                    <div class="w-3/4 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
                
                <!-- Lead Footer Skeleton -->
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <div class="w-20 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                    <div class="flex space-x-2">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else-if="!leads.length && !localLoading && !errorMessage" 
            class="flex flex-col items-center justify-center py-16 px-4 text-center">
            <div class="w-24 h-24 mb-6 text-gray-400 dark:text-gray-600">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-russo mb-2 text-gray-300 dark:text-gray-200">No Leads Yet</h3>
            <p class="text-gray-400 dark:text-gray-500 max-w-md mb-6">Your leads will appear here once you start receiving inquiries from potential clients. Stay tuned!</p>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Leads are automatically saved when someone fills out your contact form</span>
            </div>
        </div>

        <!-- Leads List -->
        <div v-if="!localLoading && leads.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="lead in validLeads" :key="lead.id" class="bg-[#1A2332] dark:bg-gray-800 rounded-xl shadow-lg border border-white/5 p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:border-[#F5D061]/20">
                <!-- Lead Header -->
                <div class="flex justify-between items-start mb-3 sm:mb-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div>
                            <h3 class="text-base sm:text-lg font-medium text-white line-clamp-1">{{ lead.name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-400">{{ lead.email }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center items-center">
                        <span
                            class="px-2 sm:px-3 py-0.5 sm:py-1 text-center text-xs sm:text-sm font-medium rounded-full shadow-sm capitalize transition-all duration-300"
                            :class="{
                                'bg-blue-500/20 text-blue-400': lead.status === 'new',
                                'bg-green-500/20 text-green-400': lead.status === 'contacted',
                                'bg-yellow-500/20 text-yellow-400': lead.status === 'qualified',
                                'bg-purple-500/20 text-purple-400': lead.status === 'converted',
                                'bg-red-500/20 text-red-400': lead.status === 'rejected',
                                'bg-gray-500/20 text-gray-400': lead.status === 'lost'
                            }"
                        >
                            {{ lead.status }}
                        </span>
                    </div>
                </div>
                
                <!-- Plan Badge - Emphasized -->
                <div class="mb-3 sm:mb-4 p-2 rounded-lg flex items-center justify-center" :class="{
                    'bg-blue-500/10 dark:bg-blue-900/20': lead.plan === 'Basic',
                    'bg-purple-500/10 dark:bg-purple-900/20': lead.plan === 'Pro',
                    'bg-green-500/10 dark:bg-green-900/20': lead.plan === 'Enterprise',
                    'bg-gray-500/10 dark:bg-gray-700/20': !lead.plan
                }">
                    <div class="flex items-center">
                        <i class="ri-vip-crown-line mr-2" :class="{
                            'text-blue-400 dark:text-blue-300': lead.plan === 'Basic',
                            'text-purple-400 dark:text-purple-300': lead.plan === 'Pro',
                            'text-green-400 dark:text-green-300': lead.plan === 'Enterprise',
                            'text-gray-400 dark:text-gray-300': !lead.plan
                        }"></i>
                        <span class="font-medium text-sm" :class="{
                            'text-blue-300 dark:text-blue-200': lead.plan === 'Basic',
                            'text-purple-300 dark:text-purple-200': lead.plan === 'Pro',
                            'text-green-300 dark:text-green-200': lead.plan === 'Enterprise',
                            'text-gray-300 dark:text-gray-200': !lead.plan
                        }">{{ lead.plan || 'No Plan' }}</span>
                </div>
                </div>
                
                <!-- Lead Message -->
                <div v-if="lead.message" class="mb-3 sm:mb-4">
                    <p class="text-xs sm:text-sm text-gray-300 dark:text-gray-300 line-clamp-2">{{ lead.message }}</p>
                </div>
                
                <!-- Lead Footer -->
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        {{ lead.created_at }}
                    </span>
                    <div class="flex space-x-2">
                        <button @click="viewLead(lead)" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-eye-line text-[#F5D061] text-sm sm:text-base"></i>
                        </button>
                        <button @click="editLead(lead)" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-pencil-line text-[#F5D061] text-sm sm:text-base"></i>
                    </button>
                        <button @click="confirmDeleteLead(lead)" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-red-500/10 flex items-center justify-center hover:bg-red-500/20 transition-colors">
                            <i class="ri-delete-bin-line text-red-400 text-sm sm:text-base"></i>
                    </button>
                </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.last_page > 1 && !localLoading" class="flex justify-center items-center space-x-2 mt-10">
            <button 
                @click="goToPage(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1 || localLoading"
                class="px-3 py-1 rounded-md text-sm font-medium"
                :class="{
                    'bg-[#f5d061] text-gray-900 cursor-pointer hover:bg-[#9b8647]': pagination.current_page !== 1 && !localLoading,
                    'bg-gray-500/20 text-gray-500 cursor-not-allowed': pagination.current_page === 1 || localLoading
                }">
                Previous
                </button>
            <span class="text-sm text-gray-600 dark:text-gray-400">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>
            <button 
                @click="goToPage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page || localLoading"
                class="px-3 py-1 rounded-md text-sm font-medium"
                :class="{
                    'bg-[#f5d061] text-gray-900 cursor-pointer hover:bg-[#9b8647]': pagination.current_page !== pagination.last_page && !localLoading,
                    'bg-gray-500/20 text-gray-500 cursor-not-allowed': pagination.current_page === pagination.last_page || localLoading
                }">
                Next
                </button>
        </div>
    </div>

    <!-- Lead View Modal -->
    <div v-if="selectedLead && showLeadModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl md:text-2xl font-russo">Lead Details</h3>
                <button @click="closeLeadModal" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>
            
            <div class="space-y-4 sm:space-y-6">
                <!-- Lead Info -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                        <i class="ri-user-line text-[#F5D061] text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl font-russo">{{ selectedLead.name }}</h4>
                        <p class="text-xs sm:text-sm text-gray-400">{{ selectedLead.email }}</p>
                        <p v-if="selectedLead.phone" class="text-xs sm:text-sm text-gray-400">{{ selectedLead.phone }}</p>
                    </div>
                </div>
                
                <!-- Lead Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Plan</h5>
                        <p class="text-sm sm:text-base text-[#F5D061]">{{ selectedLead.plan }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Status</h5>
                        <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-medium" :class="{ 
                            'bg-blue-500/20 text-blue-400': selectedLead.status === 'new',
                            'bg-green-500/20 text-green-400': selectedLead.status === 'contacted',
                            'bg-yellow-500/20 text-yellow-400': selectedLead.status === 'qualified',
                            'bg-purple-500/20 text-purple-400': selectedLead.status === 'converted',
                            'bg-red-500/20 text-red-400': selectedLead.status === 'rejected',
                            'bg-gray-500/20 text-gray-400': selectedLead.status === 'lost'
                        }">
                            {{ selectedLead.status }}
                        </span>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Created</h5>
                        <p class="text-xs sm:text-sm text-white">{{ formatDate(selectedLead.created_at) }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Source</h5>
                        <p class="text-xs sm:text-sm text-white">{{ selectedLead.source || 'Not specified' }}</p>
                    </div>
                </div>
                
                <!-- Lead Message -->
                <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                    <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Message</h5>
                    <p class="text-xs sm:text-sm text-white whitespace-pre-line">{{ selectedLead.message || 'No message provided' }}</p>
                </div>
                
                <!-- Lead Note -->
                <div v-if="selectedLead.note" class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                    <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Note</h5>
                    <p class="text-xs sm:text-sm text-white whitespace-pre-line">{{ selectedLead.note }}</p>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-white/10">
                    <button @click="editLead(selectedLead)" class="px-3 cursor-pointer sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white flex items-center gap-2 text-xs sm:text-sm">
                        <i class="ri-pencil-line"></i>
                        Edit Lead
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Lead Modal -->
    <edit-lead-modal
        v-if="showEditLeadModal && selectedLead"
        :show="showEditLeadModal"
        :lead="selectedLead"
        @close="closeEditLeadModal"
        @update-lead="handleUpdateLead"
        @notification="$emit('notification', $event)"
    />

    <!-- Delete Confirmation Modal -->
    <confirmation-modal
        v-if="showDeleteModal && selectedLead"
        :show="showDeleteModal"
        title="Delete Lead"
        :message="'Are you sure you want to delete ' + (selectedLead ? selectedLead.name : '') + '? This action cannot be undone.'"
        confirm-button-text="Delete Lead"
        :is-loading="isDeleting"
        @close="closeDeleteModal"
        @confirm="deleteLead"
    />
</template>

<script>
import axios from 'axios';
import EditLeadModal from './EditLeadModal.vue';
import ConfirmationModal from './ConfirmationModal.vue';

export default {
    name: 'LeadsSection',
    components: {
        EditLeadModal,
        ConfirmationModal
    },
    props: {
        leads: {
            type: Array,
            required: true,
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
        searchQuery: {
            type: String,
            default: ''
        },
        pagination: {
            type: Object,
            required: true,
            default: () => ({
                current_page: 1,
                last_page: 1,
                per_page: 6,
                total: 0
            })
        }
    },
    emits: ['retry', 'update:leads', 'go-to-page', 'notification', 'refresh', 'apply-filters', 'update-lead', 'delete-lead'],
    data() {
        return {
            statusFilter: 'all',
            planFilter: 'all',
            selectedLead: null,
            showLeadModal: false,
            showEditLeadModal: false,
            showDeleteModal: false,
            isDeleting: false,
            localLoading: false,
            _lastEmittedPlanFilter: 'all' // Track the last emitted plan filter
        }
    },
    computed: {
        validLeads() {
            // Filter out any undefined or null leads
            return this.leads.filter(lead => lead && lead.id);
        },
        filteredLeads() {
            let filtered = [...this.validLeads];
            
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
                    (lead.source && lead.source.toLowerCase().includes(query))
                );
            }
            
            return filtered;
        },
        
        filteredLeadsByPlan() {
            // Only emit the filter when it changes, not on every computed property access
            if (this.planFilter !== this._lastEmittedPlanFilter) {
                this._lastEmittedPlanFilter = this.planFilter;
                this.$emit('apply-filters', { plan: this.planFilter });
            }
            
            // Return the filtered leads based on the plan filter
            if (this.planFilter === 'all') {
                return this.filteredLeads;
            }
            return this.filteredLeads.filter(lead => lead.plan === this.planFilter);
        }
    },
    methods: {
        viewLead(lead) {
            this.selectedLead = { ...lead };
            this.showLeadModal = true;
        },
        closeLeadModal() {
            this.selectedLead = null;
            this.showLeadModal = false;
        },
        editLead(lead) {
            this.selectedLead = { ...lead };
            this.showEditLeadModal = true;
            this.showLeadModal = false;
        },
        closeEditLeadModal() {
            this.showEditLeadModal = false;
        },
        setPlanFilter(plan) {
            this.planFilter = plan;
            this.localLoading = true;
            this.$emit('apply-filters', { plan: this.planFilter });
            
            // Add a small delay before hiding the loading indicator
            setTimeout(() => {
                this.localLoading = false;
            }, 300);
        },
        async handleUpdateLead(leadId, leadData) {
            try {
                // Set local loading state
                this.localLoading = true;
                
                // Emit an event to the parent component to update the lead
                this.$emit('update-lead', leadId, leadData);
                
                // Update the local leads array
                this.$emit('update:leads', this.leads.map(lead => 
                    lead.id === leadId ? leadData : lead
                ));
                
                // Close the edit modal
                this.closeEditLeadModal();
                
                // Show success notification
                this.$emit('notification', {
                    type: 'success',
                    message: 'Lead updated successfully'
                });
            } catch (error) {
                console.error('Error updating lead:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to update lead'
                });
            } finally {
                // Add a small delay before hiding the loading indicator
                setTimeout(() => {
                    this.localLoading = false;
                }, 300);
            }
        },
        handleLeadUpdated(updatedLead) {
            // Update the leads array with the updated lead
            this.$emit('update:leads', this.leads.map(lead => 
                lead.id === updatedLead.id ? updatedLead : lead
            ));
            
            // Update selected lead if it's the one being viewed
            if (this.selectedLead && this.selectedLead.id === updatedLead.id) {
                this.selectedLead = updatedLead;
            }
            
            // Refresh the leads list
            this.$emit('refresh');
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },
        goToPage(page) {
            this.localLoading = true;
            this.$emit('go-to-page', page);
            
            // Add a small delay before hiding the loading indicator
            setTimeout(() => {
                this.localLoading = false;
            }, 300);
        },
        confirmDeleteLead(lead) {
            this.selectedLead = { ...lead };
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        async deleteLead() {
            if (!this.selectedLead) return;
            
            this.isDeleting = true;
            
            try {
                // Emit an event to the parent component to delete the lead
                this.$emit('delete-lead', this.selectedLead.id);
                
                // Remove the lead from the local leads array
                this.$emit('update:leads', this.leads.filter(lead => lead.id !== this.selectedLead.id));
                
                // Close the delete modal
                this.closeDeleteModal();
                
                // Show success notification
                this.$emit('notification', {
                    type: 'success',
                    message: 'Lead deleted successfully'
                });
            } catch (error) {
                console.error('Error deleting lead:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to delete lead'
                });
            } finally {
                // Add a small delay before hiding the loading indicator
                setTimeout(() => {
                    this.isDeleting = false;
                }, 300);
            }
        }
    }
}
</script> 

<style scoped>
.glass-nav {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px);
}

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

/* Add responsive styles */
@media (max-width: 640px) {
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
}
</style> 