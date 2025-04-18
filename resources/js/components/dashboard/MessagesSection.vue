<template>
    <div class="p-6 space-y-8">
        <!-- Filter and Actions Bar -->
        <div class="glass-nav p-4 rounded-xl border border-white/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" v-model="searchQuery" placeholder="Search messages..." class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50">
                </div>
                <div class="w-full md:w-auto">
                    <select v-model="statusFilter" class="w-full px-4 py-2 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50 appearance-none">
                        <option value="all">All Status</option>
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button class="px-4 py-2 rounded-full border border-white/10 hover:bg-[#1A2332] transition-colors flex items-center gap-2 w-full md:w-auto justify-center">
                    <i class="ri-mail-send-line"></i>
                    Send Message
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
            <p class="text-gray-400">Loading messages...</p>
        </div>
        
        <!-- Error state -->
        <div v-else-if="errorMessage" class="glass-nav p-8 rounded-xl border border-red-500/50 flex flex-col items-center justify-center py-10">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mb-4">
                <i class="ri-error-warning-line text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-russo mb-2 text-red-400">Failed to Load Messages</h3>
            <p class="text-gray-400 mb-4">{{ errorMessage }}</p>
            <button @click="$emit('retry')" class="px-4 py-2 rounded-full bg-[#F5D061] text-black font-russo text-sm flex items-center gap-2">
                <i class="ri-refresh-line"></i>
                Retry
            </button>
        </div>

        <!-- Messages List -->
        <div v-else class="glass-nav rounded-xl border border-white/10">
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 p-4 border-b border-white/10 bg-[#1A2332]/50">
                <div class="col-span-3 font-russo text-sm text-gray-300">From</div>
                <div class="col-span-2 font-russo text-sm text-gray-300">Subject</div>
                <div class="col-span-3 font-russo text-sm text-gray-300">Message</div>
                <div class="col-span-2 font-russo text-sm text-gray-300">Date</div>
                <div class="col-span-1 font-russo text-sm text-gray-300">Status</div>
                <div class="col-span-1 font-russo text-sm text-gray-300 text-right">Actions</div>
            </div>

            <!-- Messages Rows -->
            <div v-for="(message, index) in filteredMessages" :key="'full-message-'+index" class="grid grid-cols-12 gap-4 p-4 border-b border-white/5 hover:bg-[#1A2332]/50 transition-colors items-center" :class="{'bg-[#1A2332]/20': message.status === 'unread'}">
                <div class="col-span-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-user-line text-[#F5D061]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ message.name }}</p>
                            <p class="text-xs text-gray-400">{{ message.email }}</p>
                            <p v-if="message.phone" class="text-xs text-gray-400">{{ message.phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <p v-if="message.subject" class="text-sm text-gray-300">{{ message.subject }}</p>
                    <p v-else class="text-sm text-gray-400">No subject</p>
                </div>
                <div class="col-span-3">
                    <p class="text-sm text-gray-300 truncate">{{ message.message }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-300">{{ message.created_at }}</p>
                </div>
                <div class="col-span-1">
                    <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{ 
                        'bg-green-500/20 text-green-400': message.status === 'unread',
                        'bg-gray-500/20 text-gray-400': message.status === 'read'
                    }">
                        {{ message.status }}
                    </span>
                </div>
                <div class="col-span-1 flex justify-end gap-2">
                    <button v-if="message.status === 'read'" @click="markMessageAsUnread(message)" class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center hover:bg-blue-500/20 transition-colors">
                        <i class="ri-mail-unread-line text-blue-400"></i>
                    </button>
                    <button v-else @click="markMessageAsRead(message)" class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center hover:bg-green-500/20 transition-colors">
                        <i class="ri-mail-check-line text-green-400"></i>
                    </button>
                    <button @click="viewMessage(message)" class="w-8 h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                        <i class="ri-eye-line text-[#F5D061]"></i>
                    </button>
                </div>
            </div>

            <!-- No Results -->
            <div v-if="filteredMessages.length === 0" class="p-8 text-center">
                <div class="w-16 h-16 bg-[#1A2332] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-search-line text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-russo mb-2">No messages found</h3>
                <p class="text-gray-400">Try adjusting your search or filters</p>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="!isLoading && !errorMessage" class="flex justify-between items-center">
            <p class="text-sm text-gray-400">Showing {{ filteredMessages.length }} messages</p>
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

    <!-- Message View Modal -->
    <div v-if="selectedMessage && showMessageModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-2xl font-russo">Message Details</h3>
                <button @click="closeMessageModal" class="w-8 h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400"></i>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Message Info -->
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#F5D061]/10 flex items-center justify-center">
                        <i class="ri-user-line text-[#F5D061] text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-russo">{{ selectedMessage.name }}</h4>
                        <p class="text-gray-400">{{ selectedMessage.email }}</p>
                        <p v-if="selectedMessage.phone" class="text-gray-400">{{ selectedMessage.phone }}</p>
                    </div>
                </div>
                
                <!-- Message Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Subject</h5>
                        <p class="text-[#F5D061]">{{ selectedMessage.subject || 'No subject' }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Status</h5>
                        <span class="px-3 py-1 rounded-full text-xs font-medium" :class="{ 
                            'bg-green-500/20 text-green-400': selectedMessage.status === 'unread',
                            'bg-gray-500/20 text-gray-400': selectedMessage.status === 'read'
                        }">
                            {{ selectedMessage.status }}
                        </span>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Received</h5>
                        <p class="text-white">{{ selectedMessage.created_at }}</p>
                    </div>
                    <div class="bg-[#1A2332] p-4 rounded-lg">
                        <h5 class="text-sm font-russo mb-2 text-gray-300">Source</h5>
                        <p class="text-white">Contact Form</p>
                    </div>
                </div>
                
                <!-- Message Content -->
                <div class="bg-[#1A2332] p-4 rounded-lg">
                    <h5 class="text-sm font-russo mb-2 text-gray-300">Message</h5>
                    <p class="text-white whitespace-pre-line">{{ selectedMessage.message }}</p>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t border-white/10">
                    <button class="cta-button bg-[#F5D061] text-black px-4 py-2 rounded-full font-russo text-sm flex items-center gap-2">
                        <i class="ri-reply-line"></i>
                        Reply
                    </button>
                    <button v-if="selectedMessage.status === 'read'" @click="markMessageAsUnread(selectedMessage)" class="px-4 py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white flex items-center gap-2">
                        <i class="ri-mail-unread-line"></i>
                        Mark as Unread
                    </button>
                    <button v-else @click="markMessageAsRead(selectedMessage)" class="px-4 py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white flex items-center gap-2">
                        <i class="ri-mail-check-line"></i>
                        Mark as Read
                    </button>
                </div>
                
                <!-- Reply Form -->
                <div>
                    <h5 class="text-sm font-russo mb-2 text-gray-300">Quick Reply</h5>
                    <textarea class="w-full px-4 py-3 rounded-lg bg-[#1A2332] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/50 min-h-[100px]" placeholder="Type your reply here..."></textarea>
                    <button class="mt-2 px-4 py-2 rounded-full bg-[#F5D061] text-black font-russo text-sm flex items-center gap-2 hover:bg-[#e9b730] transition-colors">
                        <i class="ri-send-plane-line"></i>
                        Send Reply
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MessagesSection',
    props: {
        messages: {
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
    emits: ['retry', 'update:messages'],
    data() {
        return {
            searchQuery: '',
            statusFilter: 'all',
            selectedMessage: null,
            showMessageModal: false
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
        viewMessage(message) {
            this.selectedMessage = { ...message };
            this.showMessageModal = true;
            
            // If message is unread, mark it as read when viewed
            if (message.status === 'unread') {
                this.markMessageAsRead(message);
            }
        },
        closeMessageModal() {
            this.selectedMessage = null;
            this.showMessageModal = false;
        },
        markMessageAsRead(message) {
            const updatedMessage = { ...message, status: 'read' };
            this.updateMessage(message, updatedMessage);
            
            if (this.selectedMessage && this.selectedMessage.id === message.id) {
                this.selectedMessage.status = 'read';
            }
        },
        markMessageAsUnread(message) {
            const updatedMessage = { ...message, status: 'unread' };
            this.updateMessage(message, updatedMessage);
            
            if (this.selectedMessage && this.selectedMessage.id === message.id) {
                this.selectedMessage.status = 'unread';
            }
        },
        updateMessage(oldMessage, newMessage) {
            // Create a new messages array with the updated message
            const updatedMessages = this.messages.map(message => 
                message.id === oldMessage.id ? newMessage : message
            );
            
            // Emit the update to the parent component
            this.$emit('update:messages', updatedMessages);
        }
    }
}
</script> 