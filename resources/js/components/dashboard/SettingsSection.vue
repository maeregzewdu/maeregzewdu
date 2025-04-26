<template>
    <div class="space-y-6">
        <!-- Loading State -->
        <div v-if="localLoading" class="flex flex-col items-center justify-center py-12 sm:py-20">
            <div class="w-10 h-10 sm:w-12 sm:h-12 border-4 border-[#F5D061]/30 border-t-[#F5D061] rounded-full animate-spin mb-3 sm:mb-4"></div>
            <p class="text-gray-400 text-sm sm:text-base">Loading settings...</p>
        </div>
        
        <!-- Error State -->
        <div v-else-if="errorMessage" class="text-center py-12">
            <p class="text-red-500 mb-4">{{ errorMessage }}</p>
            <button @click="$emit('retry')" class="btn-[#f5d061]">
                Try Again
            </button>
        </div>

        <!-- Settings Content -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Settings Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-[#1A2332] rounded-xl border border-white/5 p-4 sm:p-5">
                    <h3 class="text-base sm:text-lg font-medium text-white mb-4">Settings</h3>
                    <div class="space-y-1">
                        <button 
                            v-for="tab in settingsTabs" 
                            :key="tab.id"
                            @click="activeTab = tab.id"
                            class="w-full cursor-pointer text-left px-3 py-2 rounded-lg transition-all duration-300 flex items-center gap-2"
                            :class="{
                                'bg-[#F5D061]/10 text-[#F5D061]': activeTab === tab.id,
                                'text-gray-400 hover:bg-[#F5D061]/5 hover:text-[#F5D061]': activeTab !== tab.id
                            }"
                        >
                            <i :class="tab.icon + ' text-lg'"></i>
                            <span class="text-sm">{{ tab.name }}</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Settings Content -->
            <div class="lg:col-span-3">
                <!-- Profile Settings -->
                <div v-if="activeTab === 'profile'" class="bg-[#1A2332] rounded-xl border border-white/5 p-5 sm:p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-user-line text-[#F5D061] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-white">Profile Information</h3>
                            <p class="text-xs sm:text-sm text-gray-400">Update your personal information</p>
                        </div>
                    </div>
                    
                    <form @submit.prevent="updateProfile" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                            <!-- First Name -->
                            <form-input
                                v-model="myInfo.name"
                                label="First Name"
                                type="text"
                                icon="ri-user-line"
                                required
                            />
                            
                            <!-- Email Address -->
                            <form-input
                                v-model="myInfo.email"
                                label="Email Address"
                                type="email"
                                icon="ri-mail-line"
                                required
                            />
                            
                            <!-- Phone Number -->
                            <form-input
                                v-model="myInfo.phone"
                                label="Phone Number"
                                type="tel"
                                icon="ri-phone-line"
                            />
                            
                            <!-- Address -->
                            <form-input
                                v-model="myInfo.address"
                                label="Address"
                                type="text"
                                icon="ri-map-pin-line"
                            />
                        </div>
                        
                        <!-- Save Button -->
                        <div class="flex justify-end pt-2">
                            <button 
                                type="submit" 
                                class="px-5 py-2.5 cursor-pointer rounded-xl bg-[#F5D061] text-black font-medium hover:bg-[#F5D061]/90 transition-all duration-300 flex items-center gap-2 shadow-lg shadow-[#F5D061]/10"
                                :disabled="isUpdating"
                            >
                                <i v-if="isUpdating" class="ri-loader-4-line animate-spin"></i>
                                <i v-else class="ri-save-line"></i>
                                <span v-if="isUpdating">Saving...</span>
                                <span v-else>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Password Settings -->
                <div v-if="activeTab === 'password'" class="bg-[#1A2332] rounded-xl border border-white/5 p-5 sm:p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-shield-keyhole-line text-[#F5D061] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-white">Change Password</h3>
                            <p class="text-xs sm:text-sm text-gray-400">Update your account security</p>
                        </div>
                    </div>
                    
                    <!-- Change Password Form -->
                    <form @submit.prevent="updatePassword" class="space-y-5">
                        <!-- Error Alert -->
                        <div v-if="passwordErrors.general" class="p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                            {{ passwordErrors.general }}
                        </div>
                        
                        <form-input
                            v-model="passwordForm.currentPassword"
                            label="Current Password"
                            placeholder="Enter your current password"
                            type="password"
                            icon="ri-lock-line"
                            required
                            :error="passwordErrors.currentPassword"
                        />
                        
                        <form-input
                            v-model="passwordForm.newPassword"
                            label="New Password"
                            placeholder="Enter your new password"
                            type="password"
                            icon="ri-lock-password-line"
                            required
                            :error="passwordErrors.newPassword"
                        />
                        
                        <form-input
                            v-model="passwordForm.newPassword_confirmation"
                            label="Confirm New Password"
                            placeholder="Confirm your new password"
                            type="password"
                            icon="ri-lock-password-line"
                            required
                            :error="passwordErrors.newPassword_confirmation"
                        />
                        
                        <div class="flex justify-end pt-2">
                            <button 
                                type="submit" 
                                class="px-5 py-2.5 cursor-pointer rounded-xl bg-[#F5D061] text-black font-medium hover:bg-[#F5D061]/90 transition-all duration-300 flex items-center gap-2 shadow-lg shadow-[#F5D061]/10"
                                :disabled="isUpdatingPassword"
                            >
                                <i v-if="isUpdatingPassword" class="ri-loader-4-line animate-spin"></i>
                                <i v-else class="ri-save-line"></i>
                                <span v-if="isUpdatingPassword">Updating...</span>
                                <span v-else>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Plans & Pricing -->
                <div v-if="activeTab === 'plans'" class="bg-[#1A2332] rounded-xl border border-white/5 p-5 sm:p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-vip-crown-line text-[#F5D061] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-white">Plans & Pricing</h3>
                            <p class="text-xs sm:text-sm text-gray-400">Manage subscription plans and pricing</p>
                        </div>
                    </div>
                    
                    <!-- Plans Management -->
                    <div class="space-y-6">
                        <!-- Plans List -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-base font-medium text-white">Available Plans</h4>
                                <button 
                                    @click="addNewPlan" 
                                    class="px-3 py-1.5 cursor-pointer rounded-lg bg-[#F5D061] text-black text-sm font-medium hover:bg-[#F5D061]/90 transition-colors flex items-center gap-1"
                                >
                                    <i class="ri-add-line"></i>
                                    <span>Add Plan</span>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div 
                                    v-for="plan in plans" 
                                    :key="plan.id"
                                    class="group p-5 rounded-xl border hover:border-[#F5D061]/30 hover:shadow-lg hover:shadow-[#F5D061]/5 transition-all duration-300 bg-[#1A2332]/50 backdrop-blur-sm"
                                    :class="plan.is_popular ? 'border-[#F5D061]/30' : 'border-white/10'"
                                >
                                    <div :class="plan.is_popular ? 'opacity-100' : 'opacity-0'" class="absolute -top-3 left-1/2 -translate-x-1/2">
                                        <span
                                            class="bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-4 py-1 rounded-full text-xs font-russo shadow-lg shadow-[#F5D061]/20">
                                            Most Popular
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300"
                                            :class="plan.status === 'active' ? 'bg-[#F5D061]/10 group-hover:bg-[#F5D061]/20' : 'bg-white/5 group-hover:bg-white/10'">
                                            <i class="ri-vip-crown-line text-2xl transition-transform group-hover:scale-110"
                                                :class="plan.status === 'active' ? 'text-[#F5D061]' : 'text-gray-400'"></i>
                                        </div>
                                        <div>
                                            <p class="text-base font-medium text-white">{{ plan.name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ plan.description || 'No description' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-lg font-medium text-[#F5D061]">{{ plan.price ? 'ETB ' + plan.price + '/project' : 'Custom' }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h5 class="text-xs font-medium text-gray-400 mb-2">Features</h5>
                                        <ul class="space-y-1">
                                            <li v-for="(feature, index) in plan.features" :key="index" class="flex items-start gap-2">
                                                <i class="ri-check-line text-[#F5D061] mt-0.5 text-xs"></i>
                                                <span class="text-xs text-gray-300">{{ feature }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                        <!-- Status toggle -->
                                        <div class="flex items-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    :checked="plan.status === 'active'"
                                                    @change="togglePlanStatus(plan)"
                                                    class="sr-only peer"
                                                />
                                                <div class="w-9 h-5 bg-[#0F172A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#F5D061]"></div>
                                            </label>
                                            <span class="ml-2 text-xs font-medium" :class="plan.status === 'active' ? 'text-[#F5D061]' : 'text-gray-400'">
                                                {{ plan.status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        
                                        <!-- Action buttons -->
                                        <div class="flex items-center gap-1">
                                            <button 
                                                @click="editPlan(plan)" 
                                                class="w-7 h-7 cursor-pointer rounded-lg bg-[#F5D061]/10 hover:bg-[#F5D061]/20 flex items-center justify-center transition-all duration-300"
                                            >
                                                <i class="ri-pencil-line text-xs text-[#F5D061]"></i>
                                            </button>
                                            <button 
                                                @click="confirmDeletePlan(plan)" 
                                                class="w-7 h-7 cursor-pointer rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center transition-all duration-300"
                                            >
                                                <i class="ri-delete-bin-line text-xs text-red-500"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div v-if="activeTab === 'social'" class="bg-[#1A2332] rounded-xl border border-white/5 p-4 sm:p-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#F5D061]/10 flex items-center justify-center">
                            <i class="ri-global-line text-[#F5D061] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-white">Social Links</h3>
                            <p class="text-xs sm:text-sm text-gray-400">Manage your social media links</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
                        <div v-for="link in socialLinks" :key="link.id" 
                            class="group p-3 rounded-xl border border-white/10 hover:border-[#F5D061]/30 hover:shadow-lg hover:shadow-[#F5D061]/5 transition-all duration-300 bg-[#1A2332]/50 backdrop-blur-sm">
                            <!-- Header with icon and name -->
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300"
                                    :class="link.is_active ? 'bg-[#F5D061]/10 group-hover:bg-[#F5D061]/20' : 'bg-white/5 group-hover:bg-white/10'">
                                    <i :class="link.icon + ' ' + (link.is_active ? 'text-[#F5D061]' : 'text-gray-400') + ' text-2xl transition-transform group-hover:scale-110'"></i>
                                </div>
                                <div>
                                    <p class="text-base font-medium text-white">{{ link.name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ link.username || 'Not connected' }}</p>
                                </div>
                            </div>
                            
                            <!-- Status and actions -->
                            <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                <!-- Status toggle -->
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            :checked="link.is_active"
                                            @change="toggleSocialLinkStatus($event, link)"
                                            class="sr-only peer"
                                        />
                                        <div class="w-9 h-5 bg-[#0F172A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#F5D061]"></div>
                                    </label>
                                    <span class="ml-2 text-xs font-medium" :class="link.is_active ? 'text-[#F5D061]' : 'text-gray-400'">
                                        {{ link.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                
                                <!-- Action buttons -->
                                <div class="flex items-center gap-1">
                                    <button 
                                        v-if="link.is_active" 
                                        @click="editSocialLink(link)" 
                                        class="w-7 h-7 cursor-pointer rounded-lg bg-[#F5D061]/10 hover:bg-[#F5D061]/20 flex items-center justify-center transition-all duration-300"
                                    >
                                        <i class="ri-pencil-line text-xs text-[#F5D061]"></i>
                                    </button>
                                    <button 
                                        @click="confirmDeleteSocialLink(link)" 
                                        class="w-7 h-7 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center transition-all duration-300"
                                    >
                                        <i class="ri-delete-bin-line text-xs text-red-500"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button @click="addSocialLink" class="px-4 py-2 rounded-lg bg-[#F5D061] text-black font-medium hover:bg-[#F5D061]/90 transition-colors flex items-center gap-2">
                            <i class="ri-add-line"></i>
                            <span>Add Social Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Social Link Confirmation Modal -->
    <confirmation-modal
        :show="showDeleteSocialLinkModal"
        :title="'Delete Social Link'"
        :message="'Are you sure you want to delete this social link? This action cannot be undone.'"
        :confirm-button-text="'Delete'"
        @confirm="deleteSocialLink"
        @close="closeDeleteSocialLinkModal"
    />

    <!-- Social Link Modal -->
    <div v-if="showSocialModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-lg">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <h3 class="text-lg sm:text-xl font-medium text-white">
                    {{ editingLink ? 'Edit Social Link' : 'Add Social Link' }}
                </h3>
                <button @click="closeSocialModal" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>

            <form @submit.prevent="saveSocialLink" class="space-y-4">
                <!-- Platform -->
                <form-input
                    v-model="socialForm.platform"
                    label="Platform"
                    type="text"
                    icon="ri-global-line"
                    placeholder="e.g., Twitter, Facebook, Instagram"
                    required
                />

                <!-- Username -->
                <form-input
                    v-model="socialForm.username"
                    label="Username"
                    type="text"
                    icon="ri-user-line"
                    placeholder="Enter your username"
                    required
                />

                <!-- URL -->
                <form-input
                    v-model="socialForm.url"
                    label="Profile URL"
                    type="url"
                    icon="ri-link"
                    placeholder="https://example.com/your-profile"
                    required
                />

                <!-- Icon -->
                <form-input
                    v-model="socialForm.icon"
                    label="Icon Class"
                    type="text"
                    icon="ri-remixicon-line"
                    placeholder="e.g., ri-twitter-fill"
                    required
                    hint="Choose an icon from Remix Icons"
                />

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-3 border-t border-white/10">
                    <button 
                        type="button" 
                        @click="closeSocialModal" 
                        class="px-4 py-2 cursor-pointer rounded-lg bg-[#1A2332] text-white font-medium hover:bg-[#232f45] transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 cursor-pointer rounded-lg bg-[#F5D061] text-black font-medium hover:bg-[#F5D061]/90 transition-colors"
                        :disabled="isSavingSocial"
                    >
                        <span v-if="isSavingSocial">Saving...</span>
                        <span v-else>{{ editingLink ? 'Save Changes' : 'Add Link' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Plan Management Modals -->
    <div v-if="showPlanModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-3 sm:p-4">
        <div class="glass-nav rounded-xl border border-white/10 p-4 sm:p-6 w-full max-w-lg my-8 h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-4 sm:mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#F5D061]/10 flex items-center justify-center">
                        <i class="ri-vip-crown-line text-[#F5D061] text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-medium text-white">
                            {{ editingPlan ? 'Edit Plan' : 'Add Plan' }}
                        </h3>
                        <p class="text-xs text-gray-400">Configure plan details and features</p>
                    </div>
                </div>
                <button @click="closePlanModal" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-[#1A2332] flex items-center justify-center hover:bg-[#232f45] transition-colors">
                    <i class="ri-close-line text-gray-400 text-sm sm:text-base"></i>
                </button>
            </div>

            <form @submit.prevent="savePlan" class="space-y-5">
                <!-- Plan Name -->
                <form-input
                    v-model="planForm.name"
                    label="Plan Name"
                    type="text"
                    icon="ri-vip-crown-line"
                    placeholder="e.g., Premium, Enterprise"
                    required
                />

                <!-- Plan Description -->
                <form-input
                    v-model="planForm.description"
                    label="Plan Description"
                    type="textarea"
                    placeholder="Enter a brief description of the plan"
                />

                <!-- Plan Price -->
                <form-input
                    v-model="planForm.price"
                    label="Plan Price"
                    type="number"
                    icon="ri-money-dollar-circle-line"
                    placeholder="Enter price in ETB"
                />

                <!-- Plan Features -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h5 class="text-base font-medium text-gray-300">Plan Features</h5>
                        <button 
                            type="button" 
                            @click="addFeature" 
                            class="px-3 py-1 rounded-lg bg-[#F5D061]/10 hover:bg-[#F5D061]/20 text-[#F5D061] text-sm font-medium transition-colors flex items-center gap-1"
                        >
                            <i class="ri-add-line"></i>
                            <span>Add Feature</span>
                        </button>
                    </div>
                    
                    <div class="space-y-2">
                        <div 
                            v-for="(feature, index) in planForm.features" 
                            :key="index"
                            class="group flex items-center gap-2 p-2 rounded-lg bg-[#1A2332] border border-white/5 hover:border-[#F5D061]/20 transition-all duration-300"
                        >
                            <div class="w-6 h-6 rounded-lg bg-[#F5D061]/10 flex items-center justify-center">
                                <i class="ri-check-line text-[#F5D061] text-xs"></i>
                            </div>
                            <input
                                v-model="planForm.features[index]"
                                type="text"
                                placeholder="Enter feature"
                                class="flex-1 bg-transparent border-none focus:outline-none text-sm text-white placeholder-gray-500"
                            />
                            <button 
                                type="button" 
                                @click="removeFeature(index)" 
                                class="w-6 h-6 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center transition-all duration-300 opacity-0 group-hover:opacity-100"
                            >
                                <i class="ri-delete-bin-line text-red-500 text-xs"></i>
                            </button>
                        </div>
                        
                        <div v-if="planForm.features.length === 0" class="text-center py-4 text-gray-400 text-sm">
                            No features added yet. Click "Add Feature" to get started.
                        </div>
                    </div>
                </div>

                <!-- Plan Status -->
                <div class="space-y-2">
                    <h5 class="text-base font-medium text-gray-300">Plan Status</h5>
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-[#1A2332] border border-white/5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                v-model="planForm.status"
                                type="checkbox"
                                :true-value="'active'"
                                :false-value="'inactive'"
                                class="sr-only peer"
                            />
                            <div class="w-9 h-5 bg-[#0F172A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#F5D061]"></div>
                        </label>
                        <span class="text-sm font-medium" :class="planForm.status === 'active' ? 'text-[#F5D061]' : 'text-gray-400'">
                            {{ planForm.status === 'active' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <!-- Plan Popularity -->
                <div class="space-y-2">
                    <h5 class="text-base font-medium text-gray-300">Plan Popularity</h5>
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-[#1A2332] border border-white/5">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                v-model="planForm.is_popular"
                                type="checkbox"
                                class="sr-only peer"
                            />
                            <div class="relative w-9 h-5 bg-[#0F172A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#F5D061]"></div>
                        </label>
                        <span class="text-sm font-medium" :class="planForm.is_popular ? 'text-[#F5D061]' : 'text-gray-400'">
                            {{ planForm.is_popular ? 'Marked as Popular' : 'Not Popular' }}
                        </span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-3 border-t border-white/10">
                    <button 
                        type="button" 
                        @click="closePlanModal" 
                        class="px-4 py-2 cursor-pointer rounded-lg bg-[#1A2332] text-white font-medium hover:bg-[#232f45] transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 cursor-pointer rounded-lg bg-[#F5D061] text-black font-medium hover:bg-[#F5D061]/90 transition-colors flex items-center gap-2"
                        :disabled="isSavingPlan"
                    >
                        <i v-if="isSavingPlan" class="ri-loader-4-line animate-spin"></i>
                        <span v-if="isSavingPlan">Saving...</span>
                        <span v-else>{{ editingPlan ? 'Save Changes' : 'Add Plan' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Plan Confirmation Modal -->
    <confirmation-modal
        :show="showDeletePlanModal"
        :title="'Delete Plan'"
        :message="'Are you sure you want to delete this plan? This action cannot be undone.'"
        :confirm-button-text="'Delete'"
        @confirm="deletePlan"
        @close="closeDeletePlanModal"
    />

</template>

<script>
import axios from 'axios';
import ConfirmationModal from './ConfirmationModal.vue';
import FormInput from '../common/FormInput.vue';

export default {
    name: 'SettingsSection',
    props: {
        myInfo: {
            type: Object,
            required: true
        },
        plans: {
            type: Array,
            required: true
        },
        socialLinks: {
            type: Array,
            required: true
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
    emits: ['retry', 'notification', 'link-deleted'],
    components: {
        ConfirmationModal,
        FormInput,
    },
    data() {
        return {
            localLoading: false,
            activeTab: 'profile',
            isUpdating: false,
            isUpdatingPassword: false,
            showUpgradeModal: false,
            twoFactorEnabled: false,
            
            // Password form data
            passwordForm: {
                currentPassword: '',
                newPassword: '',
                newPassword_confirmation: ''
            },
            
            // Password errors
            passwordErrors: {
                general: '',
                currentPassword: '',
                newPassword: '',
                newPassword_confirmation: ''
            },
            
            // Social link modal
            showSocialModal: false,
            isSavingSocial: false,
            editingLink: null,
            socialForm: {
                platform: '',
                username: '',
                url: '',
                icon: '',
            },
            
            // Available platforms for adding new links
            availablePlatforms: [
                { id: 'github', name: 'GitHub' },
                { id: 'linkedin', name: 'LinkedIn' },
                { id: 'twitter', name: 'Twitter' },
                { id: 'instagram', name: 'Instagram' },
                { id: 'facebook', name: 'Facebook' },
                { id: 'youtube', name: 'YouTube' },
                { id: 'medium', name: 'Medium' },
                { id: 'dribbble', name: 'Dribbble' },
                { id: 'behance', name: 'Behance' },
                { id: 'pinterest', name: 'Pinterest' },
                { id: 'reddit', name: 'Reddit' },
                { id: 'tiktok', name: 'TikTok' }
            ],
            showDeleteSocialLinkModal: false,
            socialLinkToDelete: null,
            
            // Plan management
            showPlanModal: false,
            isSavingPlan: false,
            editingPlan: null,
            planForm: {
                name: '',
                description: '',
                price: '',
                features: [],
                status: 'active',
                is_popular: false
            },
            showDeletePlanModal: false,
            planToDelete: null,
        }
    },
    computed: {
        settingsTabs() {
            return [
                { id: 'profile', name: 'Profile', icon: 'ri-user-line' },
                { id: 'password', name: 'Password', icon: 'ri-shield-keyhole-line' },
                { id: 'plans', name: 'Plans & Pricing', icon: 'ri-vip-crown-line' },
                { id: 'social', name: 'Social Links', icon: 'ri-share-line' }
            ]
        }
    },
    methods: {
        async updateProfile() {
            this.isUpdating = true;
            
            try {

                console.log(this.myInfo);

                await axios.put(`/api/my-info/${this.myInfo.id}`, this.myInfo);
                
                // Show success notification
                this.$emit('notification', {
                    type: 'success',
                    message: 'Profile updated successfully'
                });
            } catch (error) {
                console.error('Error updating profile:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to update profile'
                });
            } finally {
                this.isUpdating = false;
            }
        },
        
        async updatePassword() {
            // Reset errors
            this.passwordErrors = {
                general: '',
                currentPassword: '',
                newPassword: '',
                newPassword_confirmation: ''
            };
            
            // Validate passwords match
            if (this.passwordForm.newPassword !== this.passwordForm.newPassword_confirmation) {
                this.passwordErrors.newPassword_confirmation = 'Passwords do not match';
                return;
            }
            
            // Validate password length
            if (this.passwordForm.newPassword.length < 8) {
                this.passwordErrors.newPassword = 'Password must be at least 8 characters';
                return;
            }
            
            this.isUpdatingPassword = true;
            
            try {
                await axios.put('/api/update-password', {
                    current_password: this.passwordForm.currentPassword,
                    new_password: this.passwordForm.newPassword,
                    new_password_confirmation: this.passwordForm.newPassword_confirmation
                });
                
                // Reset form
                this.passwordForm = {
                    currentPassword: '',
                    newPassword: '',
                    newPassword_confirmation: ''
                };
                
                // Show success notification using the custom notification popup
                this.$emit('notification', {
                    type: 'success',
                    title: 'Password Updated',
                    message: 'Your password has been successfully updated.',
                    duration: 5000
                });
            } catch (error) {
                console.error('Error updating password:', error);
                
                // Handle specific error messages from the server
                if (error.response && error.response.data) {
                    const data = error.response.data;
                    
                    // Handle validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            if (key === 'current_password') {
                                this.passwordErrors.currentPassword = data.errors[key][0];
                            } else if (key === 'new_password') {
                                this.passwordErrors.newPassword = data.errors[key][0];
                            } else if (key === 'new_password_confirmation') {
                                this.passwordErrors.newPassword_confirmation = data.errors[key][0];
                            }
                        });
                    } 
                    // Handle general error message
                    else if (data.message) {
                        this.passwordErrors.general = data.message;
                    } else if (data.error) {
                        this.passwordErrors.general = data.error;
                    }
                } else {
                    this.passwordErrors.general = 'Failed to update password. Please try again.';
                }
                
                // Show error notification using the custom notification popup
                this.$emit('notification', {
                    type: 'error',
                    title: 'Update Failed',
                    message: error.response?.data?.message || error.response?.data?.error || 'Failed to update password',
                    duration: 5000
                });
            } finally {
                this.isUpdatingPassword = false;
            }
        },
        
        selectPlan(plan) {
            if (plan.id === this.currentPlan.id) {
                return;
            }
            
            // Update current plan
            this.currentPlan = {
                ...plan,
                nextBilling: 'June 15, 2023'
            };
            
            // Close modal if open
            this.showUpgradeModal = false;
            
            // Show success notification
            this.$emit('notification', {
                type: 'success',
                message: `Plan upgraded to ${plan.name}`
            });
        },
        
        // Social links methods
        addSocialLink() {
            this.editingLink = null;
            this.socialForm = {
                platform: '',
                url: ''
            };
            this.showSocialModal = true;
        },

        async toggleSocialLinkStatus(event, link) {
            const originalStatus = link.is_active;
            const newStatus = event.target.checked;
            link.is_active = newStatus;
            link.loading = true;

            try {
                await axios.put(`/api/social-links/${link.id}/toggle-status`, {
                is_active: newStatus
                });
            } catch (error) {
                link.is_active = originalStatus;
                alert("Something went wrong.");
            } finally {
                link.loading = false;
                this.$emit('notification', { type: 'success', message: 'Social link status updated successfully' });
            }
        },
        
        editSocialLink(link) {
            this.editingLink = link;
            this.socialForm = {
                platform: link.platform,
                username: link.username,
                url: link.url,
                icon: link.icon
            };
            this.showSocialModal = true;
        },
        
        closeSocialModal() {
            this.showSocialModal = false;
            this.editingLink = null;
            this.socialForm = {
                platform: '',
                url: ''
            };
        },
        
        getPlatformName(platformId) {
            const platform = this.availablePlatforms.find(p => p.id === platformId);
            return platform ? platform.name : '';
        },
        
        async saveSocialLink() {
            this.isSavingSocial = true;

            try {
                const url = this.editingLink 
                    ? `/api/social-links/${this.editingLink.id}` 
                    : '/api/social-links';

                const method = this.editingLink ? 'put' : 'post';

                const response = await axios[method](url, this.socialForm);
                const savedLink = response.data.socialLink;

                if (this.editingLink) {
                    const index = this.socialLinks.findIndex(link => link.id === this.editingLink.id);
                    if (index !== -1) this.socialLinks[index] = savedLink;
                    this.$emit('notification', { type: 'success', message: 'Updated successfully' });
                } else {
                    this.socialLinks.push(savedLink);
                    this.$emit('notification', { type: 'success', message: 'Added successfully' });
                }

                this.closeSocialModal();
            } catch (error) {
                console.error(error);
                this.$emit('notification', { type: 'error', message: 'Failed to save social link' });
            } finally {
                this.isSavingSocial = false;
            }
        },
        confirmDeleteSocialLink(link) {
            this.socialLinkToDelete = link;
            this.showDeleteSocialLinkModal = true;
        },
        
        closeDeleteSocialLinkModal() {
            this.showDeleteSocialLinkModal = false;
            this.socialLinkToDelete = null;
        },
        
        async deleteSocialLink() {
            if (!this.socialLinkToDelete) return;

            try {
                await axios.delete(`/api/social-links/${this.socialLinkToDelete.id}`);

                this.$emit('link-deleted', this.socialLinkToDelete.id);

                this.$emit('notification', {
                    type: 'success',
                    message: `${this.socialLinkToDelete.name} social link has been deleted.`
                });

                this.socialLinkToDelete = null;
                this.closeDeleteSocialLinkModal();

            } catch (error) {
                console.error('Failed to delete social link:', error);

                this.$emit('notification', {
                    type: 'error',
                    message: `Failed to delete ${this.socialLinkToDelete.name} social link.`
                });
            }
        },
        
        // Plan management methods
        addNewPlan() {
            this.editingPlan = null;
            this.planForm = {
                name: '',
                description: '',
                price: '',
                features: [],
                status: 'active',
                is_popular: false
            };
            this.showPlanModal = true;
        },
        
        editPlan(plan) {
            console.log(plan);
            this.editingPlan = plan;
            this.planForm = {
                name: plan.name,
                description: plan.description || '',
                price: plan.price || '',
                features: [...plan.features],
                status: plan.status,
                is_popular: plan.is_popular === 1 ? true : false
            };
            this.showPlanModal = true;
        },

        closePlanModal() {
            this.showPlanModal = false;
            this.editingPlan = null;
            this.planForm = {
                name: '',
                description: '',
                price: '',
                features: [],
                status: 'active',
                is_popular: false
            };
        },
        
        addFeature() {
            this.planForm.features.push('');
        },
        
        removeFeature(index) {
            this.planForm.features.splice(index, 1);
        },
        
        async togglePlanStatus(plan) {
            const originalStatus = plan.status;
            const newStatus = plan.status === 'active' ? 'inactive' : 'active';
            plan.status = newStatus;
            
            try {
                await axios.put(`/api/plans/${plan.id}/toggle-status`, {
                    status: newStatus
                });
                
                this.$emit('notification', {
                    type: 'success',
                    message: `Plan status updated to ${newStatus}`
                });
            } catch (error) {
                plan.status = originalStatus;
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to update plan status'
                });
            }
        },
        
        confirmDeletePlan(plan) {
            this.planToDelete = plan;
            this.showDeletePlanModal = true;
        },
        
        closeDeletePlanModal() {
            this.showDeletePlanModal = false;
            this.planToDelete = null;
        },
        
        async deletePlan() {
            if (!this.planToDelete) return;
            
            try {
                await axios.delete(`/api/plans/${this.planToDelete.id}`);
                
                // Remove plan from the list
                const index = this.plans.findIndex(p => p.id === this.planToDelete.id);
                if (index !== -1) {
                    this.plans.splice(index, 1);
                }
                
                this.$emit('notification', {
                    type: 'success',
                    message: `Plan "${this.planToDelete.name}" has been deleted`
                });
                
                this.closeDeletePlanModal();
            } catch (error) {
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to delete plan'
                });
            }
        },
        
        async savePlan() {
            this.isSavingPlan = true;
            
            try {
                // Filter out empty features
                const features = this.planForm.features.filter(feature => feature.trim() !== '');
                
                const planData = {
                    ...this.planForm,
                    features
                };
                
                if (this.editingPlan) {
                    // Update existing plan
                    await axios.put(`/api/plans/${this.editingPlan.id}`, planData);
                    
                    // Update plan in the list
                    const index = this.plans.findIndex(p => p.id === this.editingPlan.id);
                    if (index !== -1) {
                        this.plans[index] = { ...this.editingPlan, ...planData };
                    }
                    
                    this.$emit('notification', {
                        type: 'success',
                        message: `Plan "${planData.name}" updated successfully`
                    });
                } else {
                    // Create new plan
                    const response = await axios.post('/api/plans', planData);
                    
                    // Add the new plan to the list
                    if (response.data && response.data.plan) {
                        this.plans.push(response.data.plan);
                    } else {
                        // If the response doesn't include the plan, create a temporary one with an ID
                        const newPlan = {
                            id: Date.now(), // Temporary ID
                            ...planData
                        };
                        this.plans.push(newPlan);
                    }
                    
                    this.$emit('notification', {
                        type: 'success',
                        message: `Plan "${planData.name}" created successfully`
                    });
                }
                
                this.closePlanModal();
            } catch (error) {
                console.error('Error saving plan:', error);
                this.$emit('notification', {
                    type: 'error',
                    message: 'Failed to save plan'
                });
            } finally {
                this.isSavingPlan = false;
            }
        },
    }
}
</script>

<style scoped>
.glass-nav {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(10px);
}
</style> 