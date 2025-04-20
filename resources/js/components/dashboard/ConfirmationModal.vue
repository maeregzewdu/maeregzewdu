<template>
    <div v-if="show" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-md">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl font-russo">{{ title }}</h3>
                <button @click="$emit('close')" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>
            
            <div class="space-y-4 sm:space-y-6">
                <p class="text-gray-300 text-sm sm:text-base">{{ message }}</p>
                
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-white/10">
                    <button 
                        @click="$emit('close')" 
                        class="w-full cursor-pointer sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#1A2332] hover:bg-[#232f45] transition-colors border border-white/10 text-white text-xs sm:text-sm"
                    >
                        Cancel
                    </button>
                    <button 
                        @click="$emit('confirm')" 
                        class="w-full cursor-pointer sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-red-500 hover:bg-red-600 transition-colors text-white text-xs sm:text-sm"
                        :disabled="isLoading"
                    >
                        <span v-if="isLoading">Processing...</span>
                        <span v-else>{{ confirmButtonText }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ConfirmationModal',
    props: {
        show: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: 'Confirm Action'
        },
        message: {
            type: String,
            default: 'Are you sure you want to proceed with this action?'
        },
        confirmButtonText: {
            type: String,
            default: 'Confirm'
        },
        isLoading: {
            type: Boolean,
            default: false
        }
    },
    emits: ['close', 'confirm']
}
</script>

<style scoped>
.glass-nav {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px);
}
</style> 