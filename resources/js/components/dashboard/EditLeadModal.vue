<template>
    <div v-if="show" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl md:text-2xl font-russo">Edit Lead</h3>
                <button @click="$emit('close')" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>
            
            <div class="space-y-4 sm:space-y-6">
                <!-- Lead Info Form -->
                <form @submit.prevent="saveLead" class="space-y-4 sm:space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="space-y-1 sm:space-y-2">
                            <label class="text-xs sm:text-sm text-gray-300">Name</label>
                            <input 
                                v-model="editedLead.name" 
                                type="text" 
                                class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                                required
                            >
                        </div>
                        <div class="space-y-1 sm:space-y-2">
                            <label class="text-xs sm:text-sm text-gray-300">Email</label>
                            <input 
                                v-model="editedLead.email" 
                                type="email" 
                                class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="space-y-1 sm:space-y-2">
                            <label class="text-xs sm:text-sm text-gray-300">Phone</label>
                            <input 
                                v-model="editedLead.phone" 
                                type="tel" 
                                class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                                required
                            >
                        </div>
                        <div class="space-y-1 sm:space-y-2">
                            <label class="text-xs sm:text-sm text-gray-300">Plan</label>
                            <select 
                                v-model="editedLead.plan" 
                                class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                                required
                            >
                                <option value="Basic">Basic</option>
                                <option value="Pro">Pro</option>
                                <option value="Enterprise">Enterprise</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="space-y-1 sm:space-y-2">
                        <label class="text-xs sm:text-sm text-gray-300">Status</label>
                        <select 
                            v-model="editedLead.status" 
                            class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                            required
                        >
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="qualified">Qualified</option>
                            <option value="converted">Converted</option>
                            <option value="rejected">Rejected</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>
                    
                    <div class="space-y-1 sm:space-y-2">
                        <label class="text-xs sm:text-sm text-gray-300">Message</label>
                        <textarea 
                            v-model="editedLead.message" 
                            rows="3" 
                            class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                        ></textarea>
                    </div>
                    
                    <div class="space-y-1 sm:space-y-2">
                        <label class="text-xs sm:text-sm text-gray-300">Note</label>
                        <textarea 
                            v-model="editedLead.note" 
                            rows="3" 
                            class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                        ></textarea>
                    </div>
                    
                    <div class="space-y-1 sm:space-y-2">
                        <label class="text-xs sm:text-sm text-gray-300">Source</label>
                        <input 
                            v-model="editedLead.source" 
                            type="text" 
                            class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50"
                        >
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-white/10">
                        <button 
                            type="button" 
                            @click="$emit('close')" 
                            class="w-full cursor-pointer sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white text-xs sm:text-sm"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="w-full cursor-pointer sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#F5D061] text-black font-russo hover:bg-[#F5D061]/90 transition-colors text-xs sm:text-sm"
                            :disabled="isSaving"
                        >
                            <span v-if="isSaving">Saving...</span>
                            <span v-else>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EditLeadModal',
    props: {
        show: {
            type: Boolean,
            default: false
        },
        lead: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            editedLead: {
                name: '',
                email: '',
                phone: '',
                message: '',
                plan: '',
                status: 'new',
                source: '',
                note: ''
            },
            isSaving: false
        }
    },
    watch: {
        lead: {
            immediate: true,
            handler(newLead) {
                if (newLead) {
                    this.editedLead = { ...newLead };
                }
            }
        }
    },
    methods: {
        async saveLead() {
            try {
                this.isSaving = true;
                
                // Emit an event to the parent component to update the lead
                this.$emit('update-lead', this.editedLead.id, this.editedLead);
                
                // Close the modal
                this.$emit('close');
            } catch (error) {
                console.error('Error updating lead:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to update lead'
                });
            } finally {
                // Add a small delay before hiding the loading indicator
                setTimeout(() => {
                    this.isSaving = false;
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

/* Improve touch targets on mobile */
@media (max-width: 640px) {
    input, select, textarea, button {
        min-height: 36px;
    }
}
</style> 