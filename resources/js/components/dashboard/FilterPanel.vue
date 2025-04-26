<template>
    <div class="filter-panel bg-[#1A2332]/50 border border-white/10 rounded-xl p-3 sm:p-4 md:p-6 mt-4">
        <div class="flex justify-between items-center mb-3 sm:mb-4">
            <h3 class="text-xs sm:text-sm md:text-base font-russo text-white">Filter {{ type === 'leads' ? 'Leads' : 'Messages' }}</h3>
            <button @click="$emit('close')" class="text-gray-400 hover:text-[#F5D061] transition-colors">
                <i class="ri-close-line text-lg"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <!-- Date Range Filter -->
            <div class="space-y-1 sm:space-y-2">
                <label class="text-xs text-gray-400">Date Range</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="date" v-model="filters.dateFrom" class="date-from flex-1 bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50">
                    <input type="date" v-model="filters.dateTo" class="date-to flex-1 bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="space-y-1 sm:space-y-2">
                <label class="text-xs text-gray-400">Status</label>
                <select v-model="filters.status" name="status" class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50">
                    <option value="">All Status</option>
                    <template v-if="type === 'leads'">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="qualified">Qualified</option>
                        <option value="converted">Converted</option>
                        <option value="rejected">Rejected</option>
                        <option value="lost">Lost</option>
                    </template>
                    <template v-if="type === 'messages'">
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                        <option value="archived">Archived</option>
                        <option value="deleted">Deleted</option>
                    </template>
                    <template v-if="type === 'projects'">
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Cancelled">Cancelled</option>
                    </template>
                </select>
            </div>

            <div v-if="type === 'leads'" class="space-y-1 sm:space-y-2">
                <label class="text-xs text-gray-400">Plan</label>
                <select v-model="filters.plan" name="plan" class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50">
                    <option value="">All Plans</option>
                    <option value="Basic">Basic</option>
                    <option value="Pro">Pro</option>
                    <option value="Enterprise">Enterprise</option>
                </select>
            </div>
            
            <div v-if="type === 'projects'" class="space-y-1 sm:space-y-2">
                <label class="text-xs text-gray-400">Type</label>
                <select v-model="filters.type" name="type" class="w-full bg-[#0A1020] border border-white/10 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm text-white focus:outline-none focus:border-[#F5D061]/50">
                    <option value="" selected>All Types</option>
                    <option value="Website">Website</option>
                    <option value="Mobile App">Mobile App</option>
                    <option value="Desktop App">Desktop App</option>
                    <option value="Design">Design</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-4 sm:mt-6">
            <button @click="$emit('close')" class="w-full sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg border border-white/10 text-white hover:bg-white/5 transition-colors text-xs sm:text-sm">
                Cancel
            </button>
            <button @click="applyFilters" class="w-full sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg bg-[#F5D061] text-black font-russo hover:bg-[#F5D061]/90 transition-colors text-xs sm:text-sm">
                Apply Filters
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FilterPanel',
    props: {
        type: {
            type: String,
            required: true,
            validator: value => ['leads', 'messages', 'projects'].includes(value)
        }
    },
    data() {
        return {
            filters: {
                dateFrom: '',
                dateTo: '',
                status: '',
                category: '',
                plan: '',
                type: ''
            }
        }
    },
    methods: {
        applyFilters() {
            const filters = { ...this.filters };

            if (this.type !== 'messages') {
                delete filters.category;
            }

            if (this.type !== 'leads') {
                delete filters.plan;
            }

            if (this.type !== 'projects') {
                delete filters.type;
            }

            console.log(filters);

            this.$emit('apply-filters', filters);
        },

        closePanel() {
            this.$emit('close');
        },

        formatDate(date) {
            if (!date) return '';
            return new Date(date).toLocaleDateString();
        }
    }
}
</script>

<style scoped>
.filter-panel {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Add responsive styles for date inputs */
input[type="date"] {
    color-scheme: dark;
}

/* Improve touch targets on mobile */
@media (max-width: 640px) {
    select, input, button {
        min-height: 36px;
    }
}
</style> 