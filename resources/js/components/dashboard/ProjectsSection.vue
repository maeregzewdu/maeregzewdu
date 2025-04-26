<template>
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
    <div v-else-if="!projects.length" 
        class="flex flex-col items-center justify-center py-16 px-4 text-center">
        <div class="w-24 h-24 mb-6 text-gray-400 dark:text-gray-600">
            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </div>
        <h3 class="text-xl font-russo mb-2 text-gray-300 dark:text-gray-200">No Projects Yet</h3>
        <p class="text-gray-400 dark:text-gray-500 max-w-md mb-6">Your projects will appear here once you start creating them. Get ready to showcase your work!</p>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Projects are automatically saved when you create them</span>
        </div>
    </div>

    <div v-if="projects.length > 0 && !isLoading" class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="project in projects" :key="project.id" 
                class="bg-[#1E293B] border border-white/10 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group flex flex-col"
            >
                <!-- Thumbnail Image -->
                <div class="relative aspect-video overflow-hidden bg-[#0F172A]">
                    <img v-if="project.thumbnail" :src="project.thumbnail" alt="Project thumbnail" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div v-else class="w-full h-full flex items-center justify-center text-gray-500 bg-[#0F172A]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </div>
                    
                    <!-- Status badge -->
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 text-xs rounded-full" 
                              :class="{
                                'bg-green-500/20 text-green-400 border border-green-500/30': project.status === 'Completed',
                                'bg-blue-500/20 text-blue-400 border border-blue-500/30': project.status === 'In Progress',
                                'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30': project.status === 'On Hold',
                                'bg-red-500/20 text-red-400 border border-red-500/30': project.status === 'Cancelled'
                              }">
                            {{ project.status }}
                        </span>
                    </div>
                    
                    <!-- Featured badge if applicable -->
                    <div v-if="project.is_featured" class="absolute top-3 left-3">
                        <span class="px-3 py-1 text-xs rounded-full bg-[#F5D061]/20 text-[#F5D061] border border-[#F5D061]/30">
                            Featured
                        </span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-5 flex-grow flex flex-col">
                    <div class="flex items-start justify-between">
                        <div>
                            <a :href="`/projects/${project.id}`" class="text-xl font-bold text-white hover:text-[#F5D061] truncate">{{ project.title }}</a>
                            <p class="text-gray-400 text-sm mb-2">{{ project.subtitle }}</p>
                        </div>
                        <div class="px-2 py-1 rounded-lg text-xs bg-[#0F172A] text-gray-400">
                            {{ project.type }}
                        </div>
                    </div>
                    
                    <p class="text-gray-300 text-sm line-clamp-2 mt-2 mb-3">{{ project.description }}</p>
                    
                    <!-- Technologies -->
                    <div v-if="project.technologies" class="mt-auto">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span v-for="(tech, index) in parseTechnologies(project.technologies)" :key="index"
                                  class="px-2 py-1 bg-[#0F172A] text-blue-400 text-xs rounded-lg border border-blue-500/20">
                                {{ tech }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Project Footer -->
                    <div class="flex justify-between items-center pt-3 border-t border-white/5">
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            Created by: {{ project.created_by }}
                        </span>
                        <div class="flex space-x-2">
                            <a :href="`/projects/${project.id}/edit`" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#F5D061]/10 flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors">
                                <i class="ri-pencil-line text-[#F5D061] text-sm sm:text-base"></i>
                            </a>
                            <button @click="confirmDelete(project)" class="w-7 h-7 cursor-pointer sm:w-8 sm:h-8 rounded-lg bg-red-500/10 flex items-center justify-center hover:bg-red-500/20 transition-colors">
                                <i class="ri-delete-bin-line text-red-400 text-sm sm:text-base"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <template v-if="showDeleteConfirmation">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#1E293B] border border-white/10 rounded-xl p-6 max-w-md w-full shadow-xl">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Delete Project</h3>
                    <p class="text-gray-400">
                        Are you sure you want to delete "{{ projectToDelete?.title }}"? This action cannot be undone.
                    </p>
                </div>
                
                <div class="flex gap-3 justify-center">
                    <button @click="cancelDelete" class="px-4 py-2 rounded-xl bg-[#0F172A] hover:bg-[#0F172A]/70 text-white border border-white/10 transition-colors">
                        Cancel
                    </button>
                    <button @click="deleteProject" class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white transition-colors">
                        Delete Project
                    </button>
                </div>
            </div>
        </div>
    </template>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        projects: {
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
    emits: ['retry', 'update:projects', 'go-to-page', 'notification', 'refresh', 'apply-filters'],
    data() {
        return {
            statusFilter: 'all',
            selectedProject: null,
            showProjectModal: false,
            localLoading: false,
            showDeleteConfirmation: false,
            showPermanentDeleteConfirmation: false,
            projectToDelete: null,
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
        filteredProjects() {
            let filtered = [...this.projects];
            
            // Filter by status if not "all"
            if (this.statusFilter !== 'all') {
                filtered = filtered.filter(project => project.status === this.statusFilter);
            }
            
            // Filter by search query if not empty
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase().trim();
                filtered = filtered.filter(project => 
                    project.title.toLowerCase().includes(query) || 
                    project.description.toLowerCase().includes(query) || 
                    (project.client && project.client.toLowerCase().includes(query)) ||
                    (project.status && project.status.toLowerCase().includes(query))
                );
            }
            
            return filtered;
        }
    },
    methods: {
        parseTechnologies(technologies) {
            if (!technologies) return [];
            
            try {
                return typeof technologies === 'string' ? JSON.parse(technologies) : technologies;
            } catch (e) {
                console.error('Error parsing technologies:', e);
                return [];
            }
        },
        confirmDelete(project) {
            this.projectToDelete = project;
            this.showDeleteConfirmation = true;
        },
        deleteProject() {
            if (!this.projectToDelete) return;
            
            const projectId = this.projectToDelete.id;
            this.localLoading = true;
            
            axios.delete(`/projects/${projectId}`)
                .then(response => {
                    // Emit notification to parent
                    this.$emit('notification', {
                        type: 'success',
                        message: 'Project deleted successfully'
                    });
                    
                    // Refresh projects list
                    this.$emit('refresh');
                })
                .catch(error => {
                    console.error('Error deleting project:', error);
                    this.$emit('notification', {
                        type: 'error',
                        message: error.response?.data?.message || 'Failed to delete project'
                    });
                })
                .finally(() => {
                    this.localLoading = false;
                    this.showDeleteConfirmation = false;
                    this.projectToDelete = null;
                });
        },
        cancelDelete() {
            this.showDeleteConfirmation = false;
            this.projectToDelete = null;
        }
    }
}

</script>