<template>
    <div class="space-y-6">
        <!-- Loading State -->
        <div v-if="localLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="i in 6" :key="i" class="bg-[#1A2332] dark:bg-gray-800 rounded-xl shadow-lg border border-white/5 p-4 sm:p-5">
                <!-- Message Header Skeleton -->
                <div class="flex justify-between items-start mb-3 sm:mb-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-24 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                    </div>
                    <div class="w-16 h-4 bg-gray-700/50 rounded-full animate-pulse"></div>
                </div>
                
                <!-- Message Content Skeleton -->
                <div class="mb-3 sm:mb-4">
                    <div class="w-3/4 h-3 bg-gray-700/50 rounded animate-pulse mb-2"></div>
                    <div class="w-full h-3 bg-gray-700/50 rounded animate-pulse mb-1"></div>
                    <div class="w-2/3 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
        
                <!-- Message Footer Skeleton -->
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <div class="w-20 h-3 bg-gray-700/50 rounded animate-pulse"></div>
                    <div class="flex space-x-2">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-700/50 animate-pulse"></div>
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
            <button @click="$emit('retry')" class="btn-[#f5d061]">
                Try Again
            </button>
        </div>

        <!-- Empty State -->
        <div v-else-if="!messages.length" 
            class="flex flex-col items-center justify-center py-16 px-4 text-center">
            <div class="w-24 h-24 mb-6 text-gray-400 dark:text-gray-600">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <h3 class="text-xl font-russo mb-2 text-gray-300 dark:text-gray-200">No Messages Yet</h3>
            <p class="text-gray-400 dark:text-gray-500 max-w-md mb-6">Your contact form messages will appear here once you start receiving inquiries from visitors. Get ready to connect!</p>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Messages are automatically saved when someone uses your contact form</span>
            </div>
        </div>

        <div 
            v-if="messages.length > 0" 
            class="flex flex-wrap justify-center gap-1 sm:gap-2 mb-4"
        >
            <button 
                @click="setStatusFilter('all')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-[#F5D061] text-black': statusFilter === 'all',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': statusFilter !== 'all'
                }">
                All Messages
            </button>
            <button 
                @click="setStatusFilter('unread')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-blue-500 text-white': statusFilter === 'Unread',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': statusFilter !== 'Unread'
                }">
                Unread
            </button>
            <button 
                @click="setStatusFilter('read')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-purple-500 text-white': statusFilter === 'Read',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': statusFilter !== 'Read'
                }">
                Read
            </button>
            <button 
                @click="setStatusFilter('archived')" 
                class="px-2 sm:px-3 cursor-pointer py-1 sm:py-1.5 text-xs sm:text-sm rounded-lg font-medium transition-colors w-auto"
                :class="{
                    'bg-green-500 text-white': statusFilter === 'Archived',
                    'bg-[#1A2332] text-white hover:bg-[#232f45]': statusFilter !== 'Archived'
                }">
                Archived
            </button>
        </div>

        <!-- Messages List -->
        <div v-if="!localLoading && messages.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div v-for="message in messages" :key="message.id" class="bg-[#1A2332] dark:bg-gray-800 rounded-xl shadow-lg border border-white/5 p-4 sm:p-5 transition-all duration-300 hover:shadow-xl hover:border-[#F5D061]/20">
                <!-- Message Header -->
                <div class="flex justify-between items-start mb-3 sm:mb-4">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div>
                            <h3 class="text-base sm:text-lg font-medium text-white line-clamp-1">{{ message.name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-400">{{ message.email }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center items-center">
                        <span
                            class="px-2 sm:px-3 py-0.5 sm:py-1 text-center text-xs sm:text-sm font-medium rounded-full shadow-sm capitalize transition-all duration-300"
                            :class="{
                                'bg-blue-500/20 text-blue-400': message.status === 'unread',
                                'bg-green-500/20 text-green-400': message.status === 'read',
                                'bg-yellow-500/20 text-yellow-400': message.status === 'archived',
                                'bg-red-500/20 text-red-400': message.status === 'deleted'
                            }"
                        >
                            {{ message.status }}
                        </span>
                </div>
                </div>
                
                <!-- Message Content -->
                <div class="mb-3 sm:mb-4">
                    <p class="text-xs sm:text-sm font-medium text-[#F5D061] line-clamp-1 mb-1">{{ message.subject }}</p>
                    <p class="text-xs sm:text-sm text-gray-300 dark:text-gray-300 line-clamp-3">{{ message.message }}</p>
                </div>
                
                <!-- Message Footer -->
                <div class="flex justify-between items-center pt-3 border-t border-white/5">
                    <span class="text-xs text-gray-400 dark:text-gray-500">
                        {{ message.created_at }}
                    </span>
                    <div class="flex space-x-2">
                        <button title="View Message" @click="viewMessage(message); if (message.status === 'unread') markMessageAsRead(message);" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                            <i class="ri-eye-line text-[#F5D061] text-sm sm:text-base"></i>
                        </button>
                        <button :title="message.status === 'read' ? 'mark as unread' : 'mark as read'" @click="message.status === 'read' ? markMessageAsUnread(message) : markMessageAsRead(message)" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors" :class="{'hidden': message.status === 'archived' || message.status === 'deleted'}">
                            <i :class="message.status === 'read' ? 'ri-mail-check-line text-[#F5D061] text-sm sm:text-base' : 'ri-mail-unread-line text-[#F5D061] text-sm sm:text-base'"></i>
                        </button>
                        <button :title="message.status === 'archived' ? 'unarchive' : 'archive'" @click="message.status === 'archived' ? markMessageAsUnarchived(message) : markMessageAsArchived(message)" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors" :class="{'hidden': message.status === 'deleted'}">
                            <i :class="message.status === 'archived' ? 'ri-inbox-unarchive-line text-[#F5D061] text-sm sm:text-base' : 'ri-inbox-archive-line text-[#F5D061] text-sm sm:text-base'"></i>
                    </button>
                        <button :title="message.status === 'deleted' ? 'restore' : 'delete'" @click="message.status === 'deleted' ? markMessageAsRestored(message) : confirmDelete(message)" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg flex items-center justify-center transition-colors" :class="message.status === 'deleted' ? 'bg-[#F5D061]/10 hover:bg-[#F5D061]/20' : 'bg-red-500/10 hover:bg-red-500/20'">
                            <i :class="message.status === 'deleted' ? 'ri-loop-left-line text-[#F5D061] text-sm sm:text-base' : 'ri-delete-bin-line text-red-400 text-sm sm:text-base'"></i>
                    </button>
                        <button title="Permanently Delete" @click="confirmPermanentDelete(message)" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-red-500/10 flex items-center justify-center hover:bg-red-500/20 transition-colors" :class="message.status === 'deleted' ? '' : 'hidden'">
                            <i class="ri-delete-bin-line text-red-400 text-sm sm:text-base"></i>
                    </button>
                </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.last_page > 1" class="flex justify-center items-center space-x-2 mt-10">
            <button 
                @click="handlePageChange(pagination.current_page - 1)"
                :disabled="pagination.current_page === 1"
                class="px-3 py-1 rounded-md text-sm font-medium"
                :class="{
                    'bg-[#f5d061] text-gray-900 cursor-pointer hover:bg-[#9b8647]': pagination.current_page !== 1,
                    'bg-gray-500/20 text-gray-500 cursor-not-allowed': pagination.current_page === 1
                }">
                Previous
                </button>
            <span class="text-sm text-gray-600 dark:text-gray-400">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>
            <button 
                @click="handlePageChange(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page"
                class="px-3 py-1 rounded-md text-sm font-medium"
                :class="{
                    'bg-[#f5d061] text-gray-900 cursor-pointer hover:bg-[#9b8647]': pagination.current_page !== pagination.last_page,
                    'bg-gray-500/20 text-gray-500 cursor-not-allowed': pagination.current_page === pagination.last_page
                }">
                Next
                </button>
        </div>
    </div>

    <!-- Message View Modal -->
    <div v-if="selectedMessage && showMessageModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl md:text-2xl font-russo">Message Details</h3>
                <button @click="closeMessageModal" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>
            
            <div class="space-y-4 sm:space-y-6">
                <!-- Message Info -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                        <i class="ri-user-line text-[#F5D061] text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg sm:text-xl font-russo">{{ selectedMessage.name }}</h4>
                        <p class="text-xs sm:text-sm text-gray-400">{{ selectedMessage.email }}</p>
                        <p v-if="selectedMessage.phone" class="text-xs sm:text-sm text-gray-400">{{ selectedMessage.phone }}</p>
                    </div>
                </div>
                
                <!-- Message Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Subject</h5>
                        <p class="text-sm sm:text-base text-[#F5D061]">{{ selectedMessage.subject || 'No subject' }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Status</h5>
                        <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-medium" :class="{ 
                            'bg-green-500/20 text-green-400': selectedMessage.status === 'unread',
                            'bg-gray-500/20 text-gray-400': selectedMessage.status === 'read'
                        }">
                            {{ selectedMessage.status }}
                        </span>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Received</h5>
                        <p class="text-xs sm:text-sm text-white">{{ selectedMessage.created_at }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                        <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Source</h5>
                        <p class="text-xs sm:text-sm text-white">Contact Form</p>
                    </div>
                </div>
                
                <!-- Message Content -->
                <div class="bg-[#1A2332] p-3 sm:p-4 rounded-lg">
                    <h5 class="text-xs sm:text-sm font-russo mb-1 sm:mb-2 text-gray-300">Message</h5>
                    <p class="text-xs sm:text-sm text-white whitespace-pre-line">{{ selectedMessage.message }}</p>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-white/10">
                    <button v-if="selectedMessage.status === 'read'" @click="markMessageAsUnread(selectedMessage)" class="px-3 cursor-pointer sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white flex items-center gap-2 text-xs sm:text-sm">
                        <i class="ri-mail-unread-line"></i>
                        Mark as Unread
                    </button>
                    <button v-else @click="markMessageAsRead(selectedMessage)" class="px-3 cursor-pointer sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white flex items-center gap-2 text-xs sm:text-sm">
                        <i class="ri-mail-check-line"></i>
                        Mark as Read
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <confirmation-modal
        :show="showDeleteConfirmation"
        title="Delete Message"
        message="Are you sure you want to move this message to trash? You can restore it later."
        confirm-text="Delete"
        @close="showDeleteConfirmation = false"
        @confirm="confirmDeleteAction"
    />

    <confirmation-modal
        :show="showPermanentDeleteConfirmation"
        title="Permanently Delete Message"
        message="Are you sure you want to permanently delete this message? This action cannot be undone."
        confirm-text="Permanently Delete"
        @close="showPermanentDeleteConfirmation = false"
        @confirm="confirmPermanentDeleteAction"
    />
</template>

<script>
import { callWithAsyncErrorHandling } from 'vue';
import axios from 'axios';
import ConfirmationModal from './ConfirmationModal.vue';

export default {
    name: 'MessagesSection',
    components: {
        ConfirmationModal
    },
    props: {
        messages: {
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
    emits: ['retry', 'update:messages', 'go-to-page', 'notification', 'refresh', 'apply-filters'],
    data() {
        return {
            statusFilter: 'all',
            selectedMessage: null,
            showMessageModal: false,
            localLoading: false,
            showDeleteConfirmation: false,
            showPermanentDeleteConfirmation: false,
            messageToDelete: null,
            loadingTimeout: null
        }
    },
    watch: {
        // Watch for changes in the isLoading prop from parent
        isLoading: {
            immediate: true,
            handler(newValue) {
                this.localLoading = newValue;
            }
        }
    },
    computed: {
        filteredMessages() {
            let filtered = [...this.messages];
            
            // Filter by status if not "all"
            if (this.statusFilter !== 'all') {
                filtered = filtered.filter(message => message.status === this.statusFilter);
            }
            
            // Filter by search query if not empty
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase().trim();
                filtered = filtered.filter(message => 
                    message.name.toLowerCase().includes(query) || 
                    message.email.toLowerCase().includes(query) || 
                    (message.phone && message.phone.toLowerCase().includes(query)) ||
                    (message.message && message.message.toLowerCase().includes(query)) ||
                    (message.subject && message.subject.toLowerCase().includes(query))
                );
            }
            
            return filtered;
        }
    },
    methods: {
        // Handle page change with loading state
        handlePageChange(page) {
            // Set loading state
            this.localLoading = true;
            
            // Clear any existing timeout
            if (this.loadingTimeout) {
                clearTimeout(this.loadingTimeout);
            }
            
            // Set a timeout to ensure loading state is reset if something goes wrong
            this.loadingTimeout = setTimeout(() => {
                this.localLoading = false;
            }, 5000); // 5 seconds max loading time
            
            // Emit the page change event
            this.$emit('go-to-page', page);
        },
        
        viewMessage(message) {
            this.selectedMessage = { ...message };
            this.showMessageModal = true;
        },
        closeMessageModal() {
            this.selectedMessage = null;
            this.showMessageModal = false;
        },
        
        // Confirmation methods
        confirmDelete(message) {
            this.messageToDelete = message;
            this.showDeleteConfirmation = true;
        },
        
        confirmPermanentDelete(message) {
            this.messageToDelete = message;
            this.showPermanentDeleteConfirmation = true;
        },
        
        confirmDeleteAction() {
            this.showDeleteConfirmation = false;
            if (this.messageToDelete) {
                this.markMessageAsDeleted(this.messageToDelete);
                this.messageToDelete = null;
            }
        },
        
        confirmPermanentDeleteAction() {
            this.showPermanentDeleteConfirmation = false;
            if (this.messageToDelete) {
                this.permanentlyDeleteMessage(this.messageToDelete);
                this.messageToDelete = null;
            }
        },
        
        async markMessageAsRead(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'read'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'read' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
            if (this.selectedMessage && this.selectedMessage.id === message.id) {
                this.selectedMessage.status = 'read';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message marked as read'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error marking message as read:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to mark message as read'
                });
            } finally {
                this.localLoading = false;
            }
        },

        async markMessageAsUnread(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'unread'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'unread' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
            if (this.selectedMessage && this.selectedMessage.id === message.id) {
                this.selectedMessage.status = 'unread';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message marked as unread'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error marking message as unread:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to mark message as unread'
                });
            } finally {
                this.localLoading = false;
            }
        },

        async markMessageAsArchived(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'archived'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'archived' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
                    if (this.selectedMessage && this.selectedMessage.id === message.id) {
                        this.selectedMessage.status = 'archived';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message archived'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error archiving message:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to archive message'
                });
            } finally {
                this.localLoading = false;
            }
        },

        async markMessageAsUnarchived(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'unarchived'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'unarchived' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
                    if (this.selectedMessage && this.selectedMessage.id === message.id) {
                        this.selectedMessage.status = 'unarchived';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message unarchived'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error unarchiving message:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to unarchive message'
                });
            } finally {
                this.localLoading = false;
            }
        },
        
        async markMessageAsDeleted(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'deleted'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'deleted' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
                    if (this.selectedMessage && this.selectedMessage.id === message.id) {
                        this.selectedMessage.status = 'deleted';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message deleted'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error deleting message:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to delete message'
                });
            } finally {
                this.localLoading = false;
            }
        },
        
        async markMessageAsRestored(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.post(`/api/messages/${message.id}/status`, {
                    status: 'unarchived'
                });
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.map(m => 
                        m.id === message.id ? { ...m, status: 'unarchived' } : m
                    ));
                    
                    // Update selected message if it's the one being viewed
                    if (this.selectedMessage && this.selectedMessage.id === message.id) {
                        this.selectedMessage.status = 'unarchived';
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message restored'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error restoring message:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to restore message'
                });
            } finally {
                this.localLoading = false;
            }
        },
        
        async permanentlyDeleteMessage(message) {
            try {
                // Show loading state
                this.localLoading = true;
                
                // Send API request to update message status
                const response = await axios.delete(`/api/messages/${message.id}`);
                
                if (response.data.success) {
                    // Update local state
                    this.$emit('update:messages', this.messages.filter(m => m.id !== message.id));
                    
                    // Update selected message if it's the one being viewed
                    if (this.selectedMessage && this.selectedMessage.id === message.id) {
                        this.selectedMessage = null;
                    }
                    
                    // Show success notification
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Message permanently deleted'
                    });
                    
                    // Refresh the leads list
                    this.$emit('refresh');
                }
            } catch (error) {
                console.error('Error permanently deleting message:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to permanently delete message'
                });
            } finally {
                this.localLoading = false;
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },

        setStatusFilter(status) {
            this.statusFilter = status;
            this.localLoading = true;
            this.$emit('apply-filters', { status: this.statusFilter });
            
            // Add a small delay before hiding the loading indicator
            setTimeout(() => {
                this.localLoading = false;
            }, 300);
        },
    }
}
</script> 

<style scoped>
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