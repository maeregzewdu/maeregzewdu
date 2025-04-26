<template>
    <section class="py-16 md:py-24 bg-[#0F172A] relative overflow-hidden min-h-screen">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <!-- Futuristic grid lines -->
            <div class="absolute inset-0 grid-lines"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <!-- Hero Section -->
            <div class="text-center mb-10 md:mb-16 project-header">
                <h1 class="text-3xl md:text-5xl font-russo mb-3 md:mb-4 section-title text-white">Our Projects</h1>
                <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base section-subtitle">
                    Explore our portfolio of innovative digital solutions, meticulously crafted to deliver exceptional user experiences and business value.
                </p>
            </div>

            <!-- Filters Section -->
            <div class="glass-card mb-8 md:mb-12 p-6 rounded-xl border border-white/10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-8">
                    <!-- Search Input -->
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            v-model="searchQuery" 
                            placeholder="Search projects..." 
                            class="w-full py-2.5 pl-10 pr-4 bg-[#1A2332]/70 border border-white/5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F5D061]/50 focus:border-transparent text-white"
                        >
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-2 md:gap-3">
                        <button 
                            v-for="category in categories" 
                            :key="category.id"
                            @click="setActiveCategory(category.id)"
                            class="filter-btn py-2 px-4 md:px-5 rounded-lg text-sm md:text-base transition-all duration-300"
                            :class="[
                                activeCategory === category.id 
                                    ? 'text-white bg-[#F5D061]/20 border border-[#F5D061]/30' 
                                    : 'text-gray-300 bg-[#1A2332]/50 border border-white/5 hover:bg-[#1A2332]/70 hover:text-white'
                            ]"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div v-for="i in 3" :key="i" class="glass-card rounded-xl p-4 sm:p-5">
                    <!-- Image Skeleton -->
                    <div class="w-full h-48 bg-gray-700/50 rounded-lg animate-pulse mb-4"></div>
                    
                    <!-- Title Skeleton -->
                    <div class="w-2/3 h-6 bg-gray-700/50 rounded animate-pulse mb-3"></div>
                    
                    <!-- Content Skeleton -->
                    <div class="w-full h-4 bg-gray-700/50 rounded animate-pulse mb-2"></div>
                    <div class="w-5/6 h-4 bg-gray-700/50 rounded animate-pulse"></div>
                </div>
            </div>

            <!-- No Results State -->
            <div v-else-if="filteredProjects.length === 0" class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-6 text-gray-400">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        <line x1="12" y1="11" x2="12" y2="17"></line>
                        <line x1="9" y1="14" x2="15" y2="14"></line>
                    </svg>
                </div>
                <h3 class="text-xl font-russo mb-2 text-gray-300">No Projects Found</h3>
                <p class="text-gray-400 max-w-md mx-auto mb-6">We couldn't find any projects matching your search criteria. Try adjusting your filters or search terms.</p>
                <button @click="resetFilters" class="px-4 py-2 bg-[#F5D061]/20 border border-[#F5D061]/30 rounded-lg text-white hover:bg-[#F5D061]/30 transition-colors">
                    Reset Filters
                </button>
            </div>

            <div v-else>
                <!-- Featured Project (show only if we're not searching/filtering) -->
                <div v-if="!searchQuery && activeCategory === 'all' && featuredProject" class="mb-10 md:mb-16">
                    <div class="glass-card rounded-xl overflow-hidden border border-white/10 hover:border-[#F5D061]/30 transition-all duration-500 group featured-project">
                        <div class="grid md:grid-cols-2 gap-0">
                            <!-- Image Section -->
                            <div class="relative overflow-hidden h-64 md:h-auto md:aspect-auto">
                                <img :src="featuredProject.thumbnail" :alt="featuredProject.title" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A]/80 via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#F5D061] text-black text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6 md:p-8 flex flex-col">
                                <div class="mb-2">
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span 
                                            v-for="(tech, index) in parseTechnologies(featuredProject.technologies)" 
                                            :key="index"
                                            class="px-3 py-1 bg-[#1A2332] text-[#F5D061] text-xs rounded-lg border border-[#F5D061]/20"
                                        >
                                            {{ tech }}
                                        </span>
                                    </div>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-russo mb-3 text-white group-hover:text-[#F5D061] transition-colors">{{ featuredProject.title }}</h2>
                                <p class="text-gray-400 mb-6 md:mb-auto flex-grow">{{ featuredProject.description }}</p>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="text-sm text-gray-500">
                                        <span class="inline-flex items-center">
                                            <i class="ri-calendar-line mr-1.5 text-[#F5D061]"></i>
                                            Completed: {{ formatDate(featuredProject.completed_at) }}
                                        </span>
                                    </div>
                                    <a :href="`/projects/${featuredProject.id}`" class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                        View Project
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 project-grid">
                    <div 
                        v-for="project in paginatedProjects" 
                        :key="project.id" 
                        class="glass-card rounded-xl overflow-hidden border border-white/10 hover:border-[#F5D061]/30 transition-all duration-500 group hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1 project-card"
                    >
                        <!-- Image Container -->
                        <div class="relative h-48 overflow-hidden">
                            <img v-if="project.thumbnail" :src="project.thumbnail" :alt="project.title" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                            <div v-else class="w-full h-full flex items-center justify-center bg-[#1A2332]">
                                <i class="ri-image-line text-5xl text-gray-500"></i>
                            </div>
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                            <!-- Status badge -->
                            <div class="absolute top-3 right-3">
                                <span 
                                    class="px-3 py-1 text-xs rounded-full" 
                                    :class="getStatusClasses(project.status)"
                                >
                                    {{ project.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Tech stack badges -->
                            <div class="flex flex-wrap gap-2 mb-3 -mt-8 relative z-10">
                                <span 
                                    v-for="(tech, index) in parseTechnologies(project.technologies)" 
                                    :key="index"
                                    class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-lg border border-[#F5D061]/20"
                                >
                                    {{ tech }}
                                </span>
                            </div>

                            <h3 class="text-xl font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">{{ project.title }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ project.description }}</p>

                            <!-- Footer -->
                            <div class="flex justify-between items-center pt-3 border-t border-white/5">
                                <span class="text-xs text-gray-500">{{ project.type }}</span>
                                <a :href="`/projects/${project.id}`" class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                    Details
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="totalPages > 1" class="mt-12 flex justify-center">
                    <div class="flex space-x-1">
                        <button 
                            @click="prevPage" 
                            :disabled="currentPage === 1"
                            class="px-4 py-2 rounded-lg transition-colors"
                            :class="currentPage === 1 
                                ? 'bg-[#1A2332]/40 text-gray-500 cursor-not-allowed' 
                                : 'bg-[#1A2332]/70 border border-white/5 text-gray-400 hover:bg-[#1A2332] hover:text-white'"
                        >
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        
                        <button 
                            v-for="page in displayedPages" 
                            :key="page"
                            @click="goToPage(page)"
                            class="px-4 py-2 rounded-lg transition-colors"
                            :class="currentPage === page 
                                ? 'bg-[#F5D061]/20 border border-[#F5D061]/30 text-white' 
                                : 'bg-[#1A2332]/70 border border-white/5 text-gray-400 hover:bg-[#1A2332] hover:text-white'"
                        >
                            {{ page }}
                        </button>
                        
                        <button 
                            @click="nextPage" 
                            :disabled="currentPage === totalPages"
                            class="px-4 py-2 rounded-lg transition-colors"
                            :class="currentPage === totalPages 
                                ? 'bg-[#1A2332]/40 text-gray-500 cursor-not-allowed' 
                                : 'bg-[#1A2332]/70 border border-white/5 text-gray-400 hover:bg-[#1A2332] hover:text-white'"
                        >
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'ProjectsPageComponent',
    props: {
        initialProjects: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            isLoading: false,
            projects: [],
            searchQuery: '',
            activeCategory: 'all',
            currentPage: 1,
            projectsPerPage: 6,
            categories: [
                { id: 'all', name: 'All' },
                { id: 'web-app', name: 'Web Apps' },
                { id: 'ecommerce', name: 'E-commerce' },
                { id: 'ui-ux', name: 'UI/UX Design' }
            ]
        }
    },
    computed: {
        featuredProject() {
            return this.projects.find(project => project.is_featured);
        },
        filteredProjects() {
            let filtered = [...this.projects];
            
            // Filter out the featured project when viewing all projects
            if (!this.searchQuery && this.activeCategory === 'all') {
                filtered = filtered.filter(project => !project.is_featured);
            }
            
            // Filter by category
            if (this.activeCategory !== 'all') {
                filtered = filtered.filter(project => project.category === this.activeCategory);
            }
            
            // Filter by search query
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(project => 
                    project.title.toLowerCase().includes(query) || 
                    project.description.toLowerCase().includes(query) ||
                    (project.technologies && this.parseTechnologies(project.technologies).some(tech => 
                        tech.toLowerCase().includes(query)
                    ))
                );
            }
            
            return filtered;
        },
        paginatedProjects() {
            const startIndex = (this.currentPage - 1) * this.projectsPerPage;
            const endIndex = startIndex + this.projectsPerPage;
            return this.filteredProjects.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.filteredProjects.length / this.projectsPerPage);
        },
        displayedPages() {
            const range = 2; // Number of pages to show before and after current page
            let start = Math.max(1, this.currentPage - range);
            let end = Math.min(this.totalPages, this.currentPage + range);
            
            // Adjust the range to always show 5 pages if possible
            if (end - start < 4 && this.totalPages > 4) {
                if (start === 1) {
                    end = Math.min(start + 4, this.totalPages);
                } else if (end === this.totalPages) {
                    start = Math.max(end - 4, 1);
                }
            }
            
            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
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
        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },
        getStatusClasses(status) {
            switch (status) {
                case 'Completed':
                    return 'bg-green-500/20 text-green-400 border border-green-500/30';
                case 'In Progress':
                    return 'bg-blue-500/20 text-blue-400 border border-blue-500/30';
                case 'Planning':
                case 'On Hold':
                    return 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30';
                case 'Cancelled':
                    return 'bg-red-500/20 text-red-400 border border-red-500/30';
                default:
                    return 'bg-gray-500/20 text-gray-400 border border-gray-500/30';
            }
        },
        setActiveCategory(categoryId) {
            this.activeCategory = categoryId;
            this.currentPage = 1; // Reset to first page when changing category
        },
        resetFilters() {
            this.searchQuery = '';
            this.activeCategory = 'all';
            this.currentPage = 1;
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        goToPage(page) {
            this.currentPage = page;
        },
        async fetchProjects() {
            this.isLoading = true;
            
            try {
                // If we have initial projects from props, use those
                if (this.initialProjects && this.initialProjects.length > 0) {
                    this.projects = this.initialProjects;
                    return;
                };
                
                // Otherwise fetch from API
                const response = await fetch('/api/projects');
                const data = await response.json();
                this.projects = data.projects || [];
                console.log('Fetched projects:', this.projects);
            } catch (error) {
                console.error('Error fetching projects:', error);
            } finally {
                this.isLoading = false;
            }
        }
    },
    mounted() {
        this.fetchProjects();
        
        // Add scroll animation observer
        this.$nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add visible class to elements
                        const title = entry.target.querySelector('.section-title');
                        const subtitle = entry.target.querySelector('.section-subtitle');
                        const featured = entry.target.querySelector('.featured-project');
                        const cards = entry.target.querySelectorAll('.project-card');
                        
                        if (title) title.classList.add('visible');
                        if (subtitle) setTimeout(() => subtitle.classList.add('visible'), 200);
                        if (featured) setTimeout(() => featured.classList.add('visible'), 300);
                        
                        cards.forEach((card, index) => {
                            setTimeout(() => card.classList.add('visible'), 400 + (index * 100));
                        });
                        
                        // Unobserve after animation
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            // Observe the project header section
            const projectSection = document.querySelector('.project-header');
            if (projectSection) {
                observer.observe(projectSection.parentElement);
            }
        });
    }
}
</script>

<style scoped>
/* Futuristic grid lines background */
.grid-lines {
    background-image: 
        linear-gradient(rgba(245, 208, 97, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(245, 208, 97, 0.1) 1px, transparent 1px);
    background-size: 30px 30px;
    opacity: 0.5;
    animation: gridMove 20s linear infinite;
}

@keyframes gridMove {
    0% {
        background-position: 0 0;
    }
    100% {
        background-position: 30px 30px;
    }
}

.glass-card {
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Animation classes */
.section-title, .section-subtitle, .project-card, .featured-project {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.section-title.visible, .section-subtitle.visible, .project-card.visible, .featured-project.visible {
    opacity: 1;
    transform: translateY(0);
}

.section-subtitle {
    transition-delay: 0.2s;
}

.featured-project {
    transition-delay: 0.3s;
}

.project-card:nth-child(1) {
    transition-delay: 0.4s;
}

.project-card:nth-child(2) {
    transition-delay: 0.5s;
}

.project-card:nth-child(3) {
    transition-delay: 0.6s;
}

.project-card:nth-child(4) {
    transition-delay: 0.7s;
}

.project-card:nth-child(5) {
    transition-delay: 0.8s;
}

.project-card:nth-child(6) {
    transition-delay: 0.9s;
}
</style> 