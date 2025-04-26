<template>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Loading Indicator -->
        <div v-if="loading" class="flex items-center justify-center mb-6">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#F5D061]"></div>
            <span class="ml-3 text-white text-lg">Loading project data...</span>
        </div>
        
        <div v-else>
            <h1 class="text-3xl font-bold mb-6 text-white">{{ isEditMode ? 'Edit Project' : 'Create Project' }}</h1>
            
            <div v-if="errorMessage" class="bg-red-500/10 border border-red-500/30 text-red-500 px-4 py-3 rounded-lg mb-6">
                {{ errorMessage }}
            </div>
            
            <form @submit.prevent="submitForm" class="bg-[#1E293B] shadow-lg rounded-lg p-6 space-y-6 border border-white/10">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-white border-b border-white/10 pb-2">Basic Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <FormInput
                            v-model="form.title"
                            label="Project Title*"
                            placeholder="Enter project title"
                            required
                        />

                        <FormInput
                            v-model="form.subtitle"
                            label="Subtitle*"
                            placeholder="Brief project description"
                            required
                        />
                    </div>
                    
                    <FormInput
                        v-model="form.description"
                        label="Description*"
                        type="textarea"
                        placeholder="Detailed project description"
                        required
                    />
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="block text-xs sm:text-sm text-gray-400 mb-2">Project Type*</label>
                            <select 
                                v-model="form.type" 
                                class="w-full py-2.5 px-3 rounded-xl bg-[#0F172A] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/30 transition-colors"
                                required
                            >
                                <option value="Website">Website</option>
                                <option value="Mobile App">Mobile App</option>
                                <option value="Desktop App">Desktop App</option>
                                <option value="Design">Design</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-xs sm:text-sm text-gray-400 mb-2">Status*</label>
                            <select 
                                v-model="form.status" 
                                class="w-full py-2.5 px-3 rounded-xl bg-[#0F172A] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/30 transition-colors"
                                required
                            >
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="on-hold">On Hold</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Technologies & Features -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <h2 class="text-xl font-semibold text-white">Technologies & Features</h2>
                    </div>
                    <div class="border-b border-white/10 mb-4"></div>
                    
                    <div class="form-group mb-5">
                        <label class="block text-xs sm:text-sm text-gray-400 mb-3">Technologies*</label>
                        <div class="flex flex-col gap-3">
                            <div v-for="(tech, index) in form.technologies" :key="'tech-'+index" 
                                class="flex items-center gap-2 p-3 rounded-lg bg-[#0F172A] border border-white/10 transition-all hover:border-[#F5D061]/20">
                                <!-- Code icon -->
                                <div class="flex-shrink-0 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="16 18 22 12 16 6"></polyline>
                                        <polyline points="8 6 2 12 8 18"></polyline>
                                    </svg>
                                </div>
                                
                                <input 
                                    v-model="form.technologies[index]" 
                                    type="text" 
                                    class="flex-1 py-1 px-2 bg-transparent  text-white focus:outline-none transition-colors"
                                    placeholder="Technology name (e.g., React, Laravel, TailwindCSS)"
                                >
                                
                                <button @click="removeTechnology(index)" type="button" 
                                    class="cursor-pointer flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full text-gray-400 hover:text-red-400 hover:bg-red-400/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            
                            <button 
                                @click="addTechnology" 
                                type="button" 
                                class="cursor-pointer flex items-center gap-2 p-3 rounded-lg border border-dashed border-[#F5D061]/30 text-[#F5D061] hover:bg-[#F5D061]/10 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Add Technology</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="block text-xs sm:text-sm text-gray-400 mb-3">Features*</label>
                        <div class="flex flex-col gap-3">
                            <div v-for="(feature, index) in form.features" :key="'feature-'+index" 
                                class="flex items-center gap-2 p-3 rounded-lg bg-[#0F172A] border border-white/10 transition-all hover:border-[#F5D061]/20">
                                <!-- Feature icon -->
                                <div class="flex-shrink-0 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                
                                <input 
                                    v-model="form.features[index]" 
                                    type="text" 
                                    class="flex-1 py-1 px-2 bg-transparent  text-white focus:outline-none transition-colors"
                                    placeholder="Feature description"
                                >
                                
                                <button @click="removeFeature(index)" type="button" 
                                    class="cursor-pointer flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full text-gray-400 hover:text-red-400 hover:bg-red-400/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            
                            <button 
                                @click="addFeature" 
                                type="button" 
                                class="cursor-pointer flex items-center gap-2 p-3 rounded-lg border border-dashed border-[#F5D061]/30 text-[#F5D061] hover:bg-[#F5D061]/10 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Add Feature</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Media -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <h2 class="text-xl font-semibold text-white">Media</h2>
                    </div>
                    <div class="border-b border-white/10 mb-4"></div>
                    
                    <!-- Thumbnail Upload -->
                    <div class="form-group mb-5">
                        <label class="block text-xs sm:text-sm text-gray-400 mb-3">Thumbnail Image*</label>
                        
                        <!-- Show this when no thumbnail is selected -->
                        <div v-if="!thumbnailPreview" 
                            class="w-full border-2 border-dashed border-white/20 rounded-lg cursor-pointer hover:border-[#F5D061]/30 transition-colors"
                            @click="$refs.thumbnailInputUpload.click()"
                        >
                            <input 
                                type="file" 
                                ref="thumbnailInputUpload" 
                                accept="image/*" 
                                class="hidden" 
                                @change="handleThumbnailUpload"
                            >
                            <div class="text-center p-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-300 mb-1">Upload Thumbnail</h3>
                                <p class="text-sm text-gray-400">Drag & drop or click to browse</p>
                                <p class="text-xs text-gray-500 mt-2">PNG, JPG or GIF up to 2MB</p>
                            </div>
                        </div>
                        
                        <!-- Show this when thumbnail is selected -->
                        <div v-else class="space-y-3">
                            <div class="aspect-video bg-[#0F172A] rounded-lg border border-white/10 overflow-hidden">
                                <img :src="thumbnailPreview" class="w-full h-full object-cover" />
                            </div>
                            
                            <div class="flex items-center justify-between bg-[#0F172A] p-3 rounded-lg">
                                <div class="flex items-center gap-2 text-sm text-gray-300 truncate">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#F5D061]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span class="truncate">{{ thumbnailFileName || "Selected file" }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <!-- Hidden input for changing thumbnail -->
                                    <input 
                                        type="file" 
                                        ref="thumbnailInputChange" 
                                        accept="image/*" 
                                        class="hidden" 
                                        @change="handleThumbnailUpload"
                                    >
                                    <button 
                                        @click="$refs.thumbnailInputChange.click()" 
                                        type="button" 
                                        class="text-[#F5D061] cursor-pointer hover:text-[#F5D061]/80 flex items-center gap-1"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        <span class="text-sm">Change</span>
                                    </button>
                                    <button 
                                        @click="removeThumbnail" 
                                        type="button" 
                                        class="text-gray-400 cursor-pointer hover:text-red-400 flex items-center gap-1"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                        <span class="text-sm">Remove</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gallery Upload -->
                    <div class="form-group">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-xs sm:text-sm text-gray-400">Gallery Images*</label>
                            
                            <!-- Always visible Add button when there are images -->
                            <button 
                                @click="$refs.galleryInput.click()" 
                                type="button" 
                                class="text-[#F5D061] hover:text-[#F5D061]/80 flex items-center gap-1 text-sm"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Images
                            </button>
                        </div>
                        
                        <!-- Hidden input for file selection -->
                        <input 
                            type="file" 
                            ref="galleryInput" 
                            accept="image/*" 
                            multiple
                            class="hidden" 
                            @change="handleGalleryUpload"
                        >
                        
                        <!-- Upload Control - only show when no images -->
                        <div v-if="galleryItems.length === 0"
                            class="w-full border-2 border-dashed border-white/20 rounded-lg flex items-center justify-center cursor-pointer hover:border-[#F5D061]/30 transition-colors mb-4"
                            @click="$refs.galleryInput.click()"
                        >
                            <div class="text-center p-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-300 mb-1">Upload Gallery Images</h3>
                                <p class="text-sm text-gray-400">Click to select multiple images</p>
                                <p class="text-xs text-gray-500 mt-2">PNG, JPG or GIF up to 5MB each</p>
                            </div>
                        </div>
                        
                        <!-- Gallery Previews -->
                        <div v-if="galleryItems.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                            <div 
                                v-for="(item, index) in galleryItems" 
                                :key="'gallery-'+index" 
                                class="relative group cursor-move border border-white/10 rounded-lg"
                                :class="{'ring-2 ring-[#F5D061] shadow-lg': draggedItem === index}"
                                draggable="true"
                                @dragstart="startDrag(index)"
                                @dragover.prevent="$event.target.closest('.group').classList.add('bg-[#0F172A]', 'border-[#F5D061]')"
                                @dragleave.prevent="$event.target.closest('.group').classList.remove('bg-[#0F172A]', 'border-[#F5D061]')"
                                @dragenter.prevent="$event.target.closest('.group').classList.add('bg-[#0F172A]', 'border-[#F5D061]')"
                                @drop="onDrop(index, $event)"
                            >
                                <div class="aspect-square rounded-lg overflow-hidden bg-[#0F172A]">
                                    <img v-if="item.preview" :src="item.preview" class="w-full h-full object-cover">
                                    <div v-else class="w-full h-full flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <button 
                                        @click="removeGalleryItem(index)" 
                                        type="button" 
                                        class="h-8 w-8 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-red-500/70 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="absolute bottom-0 left-0 right-0 bg-black/50 px-2 py-1 text-xs text-white truncate flex items-center justify-between">
                                    <span class="truncate">{{ item.file ? item.file.name : (item.id ? `Image #${item.id}` : 'Uploaded image') }}</span>
                                    <span v-if="item.file" class="flex-shrink-0 bg-blue-500 rounded-full px-1.5 text-[10px]">NEW</span>
                                </div>
                            </div>
                        </div>
                        
                        <div v-if="galleryItems.length > 0" class="mt-2 text-xs text-gray-400">
                            <p>Drag images to reorder. Images will be displayed in the order shown above.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <h2 class="text-xl font-semibold text-white">Additional Information</h2>
                        <span class="px-2 py-0.5 text-xs bg-[#0F172A] text-gray-400 rounded-full">Optional</span>
                    </div>
                    <div class="border-b border-white/10 mb-4"></div>
                    
                    <FormInput
                        v-model="form.client_name"
                        label="Client Name"
                        placeholder="Client name (if applicable)"
                    />
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <FormInput
                            v-model="form.project_url"
                            label="Project URL"
                            type="url"
                            placeholder="https://example.com"
                        />
                        
                        <FormInput
                            v-model="form.github_url"
                            label="GitHub URL"
                            type="url"
                            placeholder="https://github.com/username/repo"
                        />
                    </div>

                    <div class="form-group">
                        <label class="block text-xs sm:text-sm text-gray-400 mb-3">Featured Project</label>
                        <div class="flex items-center">
                            <button 
                                @click="form.is_featured = !form.is_featured" 
                                type="button"
                                class="relative inline-flex h-6 w-11 items-center rounded-full cursor-pointer"
                                :class="form.is_featured ? 'bg-[#F5D061]' : 'bg-[#0F172A]'"
                            >
                                <span 
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition duration-200 ease-in-out"
                                    :class="form.is_featured ? 'translate-x-6' : 'translate-x-1'"
                                ></span>
                            </button>
                            <span class="ml-3 text-sm text-gray-300">
                                {{ form.is_featured ? 'Featured on homepage' : 'Not featured' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-5 mt-4 border-t border-white/10">
                    <button 
                        type="button" 
                        @click="goBack"
                        class="px-5 py-2.5 border border-white/10 shadow-sm text-sm font-medium rounded-xl text-gray-300 bg-[#0F172A] hover:bg-[#1E293B] cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F5D061]/30"
                        :disabled="submitting"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-gray-900 bg-[#F5D061] hover:bg-[#F5D061]/90 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F5D061] flex items-center"
                        :disabled="submitting"
                    >
                        <span v-if="submitting" class="animate-spin h-4 w-4 mr-2 border-2 border-gray-900 rounded-full border-t-transparent"></span>
                        {{ isEditMode ? 'Update Project' : 'Save Project' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import FormInput from '../common/FormInput.vue';
import axios from 'axios';

export default {
    name: 'ProjectForm',
    components: {
        FormInput
    },
    props: {
        initialData: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            form: {
                title: '',
                slug: '',
                subtitle: '',
                description: '',
                technologies: [''],
                features: [''],
                status: 'In Progress',
                thumbnail: null,
                type: 'Website',
                client_name: '',
                project_url: '',
                github_url: '',
                is_featured: false
            },
            galleryItems: [],
            categories: [],
            technologies: [],
            submitting: false,
            draggedItem: null,
            errorMessage: '',
            thumbnailPreview: null,
            isEditMode: false,
            projectId: null,
            loading: true,
            thumbnailFileName: '',
            initialData: null
        }
    },
    created() {
        this.checkForExistingProject();
    },
    watch: {
        'form.title': {
            handler: function(newValue) {
                if (!this.isEditMode || !this.form.slug) {
                    // Generate slug from title
                    this.generateSlug();
                }
            }
        }
    },
    methods: {
        checkForExistingProject() {
            // If we already have initialData prop set, we'll use that
            if (this.initialData) {
                // This will be processed in the mounted hook
                this.loading = false;
                return;
            }
            
            // Otherwise, check if the element has project data
            const appElement = document.getElementById('project-form-app');
            
            if (appElement && appElement.dataset.editMode === 'true') {
                this.isEditMode = true;
                try {
                    // Store the parsed project data to initialData prop
                    const projectData = JSON.parse(appElement.dataset.project);
                    this.initialData = appElement.dataset.project;
                    this.projectId = projectData.id;
                    this.populateFormData(projectData);
                } catch (error) {
                    console.error('Error parsing project data:', error);
                    this.errorMessage = 'Failed to load project data correctly.';
                    this.loading = false;
                }
            } else {
                this.loading = false;
            }
        },
        populateFormData(project) {
            // Populate form fields
            this.form.title = project.title || '';
            this.form.slug = project.slug || '';
            this.form.subtitle = project.subtitle || '';
            this.form.description = project.description || '';
            this.form.status = project.status || 'In Progress';
            this.form.type = project.type || 'Website';
            this.form.client_name = project.client_name || '';
            this.form.project_url = project.project_url || '';
            this.form.github_url = project.github_url || '';
            this.form.is_featured = project.is_featured || false;
            
            // Handle technologies and features which are stored as JSON
            try {
                const technologies = typeof project.technologies === 'string' 
                    ? JSON.parse(project.technologies) 
                    : project.technologies;
                this.form.technologies = technologies || [];
            } catch (e) {
                console.warn('Error parsing technologies:', e);
                this.form.technologies = [];
            }
            
            try {
                const features = typeof project.features === 'string' 
                    ? JSON.parse(project.features) 
                    : project.features;
                this.form.features = features || [];
            } catch (e) {
                console.warn('Error parsing features:', e);
                this.form.features = [];
            }
            
            // Handle thumbnail preview
            if (project.thumbnail) {
                // Fix the thumbnail path if needed
                const thumbnailUrl = this.fixImageUrl(project.thumbnail, 'thumbnail');
                this.thumbnailPreview = thumbnailUrl;
                this.form.thumbnail = thumbnailUrl;
                this.thumbnailFileName = this.getFileNameFromUrl(thumbnailUrl);
            }
            
            // Handle gallery previews
            if (project.gallery) {
                try {
                    const galleryRaw = typeof project.gallery === 'string'
                        ? JSON.parse(project.gallery)
                        : project.gallery;
                    
                    if (Array.isArray(galleryRaw)) {
                        // Create gallery items with name and preview for each item
                        this.galleryItems = galleryRaw.map(item => {
                            // Handle both string URLs and objects with url property
                            const itemUrl = typeof item === 'object' ? item.url : item;
                            const fixedUrl = this.fixImageUrl(itemUrl, 'gallery');
                            return {
                                name: this.getFileNameFromUrl(itemUrl),
                                preview: fixedUrl,
                                originalUrl: itemUrl, // Store the original URL for backend reference
                                position: typeof item === 'object' ? (item.position || 0) : 0,
                                id: typeof item === 'object' ? (item.id || null) : null
                            };
                        });
                        
                        // For backward compatibility - but we'll primarily use galleryItems now
                        this.form.gallery = galleryRaw;
                        
                        console.log('Loaded existing gallery items:', this.galleryItems.length);
                    } else {
                        this.galleryItems = [];
                        this.form.gallery = [];
                    }
                } catch (e) {
                    console.error('Error parsing gallery:', e);
                    this.galleryItems = [];
                    this.form.gallery = [];
                }
            }
            
            this.loading = false;
        },
        
        // Helper method to fix image URLs
        fixImageUrl(url, type = 'photos') {
            // If url is null or undefined, return empty string
            if (url === null || url === undefined) {
                return '';
            }

            // Handle case where url might be an object with a url property
            if (typeof url === 'object' && url !== null && url.url) {
                return this.fixImageUrl(url.url, type);
            }

            // Ensure url is a string before using string methods
            if (typeof url !== 'string') {
                console.warn('Invalid URL type:', typeof url, url);
                return '';
            }

            // Handle relative URLs
            if (!url.startsWith('http') && !url.startsWith('blob:') && !url.startsWith('data:')) {
                // Check if it's already a storage URL
                if (url.startsWith('/storage')) {
                    return url;
                }
                
                // Handle specific paths based on type
                if (type === 'gallery') {
                    return url.startsWith('/') ? url : `/storage/gallery/${url}`;
                }
                return url.startsWith('/') ? url : `/storage/${url}`;
            }
            return url;
        },
        getFileNameFromUrl(url) {
            if (!url) return '';
            // Extract filename from URL
            return url.split('/').pop() || 'Existing file';
        },
        addTechnology() {
            this.form.technologies.push('');
        },
        removeTechnology(index) {
            if (this.form.technologies.length > 1) {
                this.form.technologies.splice(index, 1);
            }
        },
        addFeature() {
            this.form.features.push('');
        },
        removeFeature(index) {
            if (this.form.features.length > 1) {
                this.form.features.splice(index, 1);
            }
        },
        handleThumbnailUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            this.thumbnailFileName = file.name;
            this.form.thumbnail = file;
            
            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.thumbnailPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeThumbnail() {
            this.form.thumbnail = null;
            this.thumbnailPreview = '';
            this.thumbnailFileName = '';
            if (this.$refs.thumbnailInputUpload) {
                this.$refs.thumbnailInputUpload.value = '';
            }
            if (this.$refs.thumbnailInputChange) {
                this.$refs.thumbnailInputChange.value = '';
            }
        },
        handleGalleryUpload(event) {
            const files = event.target.files;
            
            if (!files.length) return;
            
            Array.from(files).forEach(file => {
                // Only process image files
                if (!file.type.includes('image/')) {
                    return;
                }
                
                // Create a preview URL
                const reader = new FileReader();
                reader.onload = e => {
                    this.galleryItems.push({
                        id: null, // New items have no ID
                        file: file,
                        preview: e.target.result,
                        originalUrl: null
                    });
                };
                reader.readAsDataURL(file);
            });
            
            // Reset the input to allow selecting the same file again
            event.target.value = '';
        },
        removeGalleryItem(index) {
            this.galleryItems.splice(index, 1);
        },
        startDrag(index) {
            this.draggedItem = index;
        },
        onDrop(index, event) {
            if (this.draggedItem === null) return;
            
            // Get the item we're dragging
            const itemToMove = this.galleryItems[this.draggedItem];
            
            // Remove it from the array
            this.galleryItems.splice(this.draggedItem, 1);
            
            // Add it back at the new position
            this.galleryItems.splice(index, 0, itemToMove);
            
            // Reset the dragged item
            this.draggedItem = null;
            
            // Remove any temporary styles
            if (event && event.target) {
                const group = event.target.closest('.group');
                if (group) {
                    group.classList.remove('bg-[#0F172A]', 'border-[#F5D061]');
                }
            }
            
            // Update positions after reordering
            this.updateGalleryPositions();
        },
        updateGalleryPositions() {
            // Assign position values to maintain order when saving
            this.galleryItems.forEach((item, index) => {
                item.position = index;
            });
        },
        goBack() {
            window.history.back();
        },
        submitForm() {
            this.submitting = true;
            this.errorMessage = '';
            
            // Create FormData for file uploads
            const formData = new FormData();
            
            // Add CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', token);
            
            // Add method override for PUT if in edit mode
            if (this.isEditMode) {
                formData.append('_method', 'PUT');
            }
            
            // Add regular fields (except gallery and thumbnail which we'll handle separately)
            Object.keys(this.form).forEach(key => {
                if (key !== 'thumbnail' && key !== 'gallery') {
                    if (Array.isArray(this.form[key])) {
                        this.form[key].forEach((item, index) => {
                            formData.append(`${key}[${index}]`, item);
                        });
                    } else {
                        formData.append(key, this.form[key]);
                    }
                }
            });
            
            // Add thumbnail file if exists and is a File object
            if (this.form.thumbnail) {
                if (this.form.thumbnail instanceof File) {
                    formData.append('thumbnail', this.form.thumbnail);
                } else if (typeof this.form.thumbnail === 'string') {
                    // Pass the existing thumbnail path as-is
                    formData.append('existing_thumbnail', this.form.thumbnail);
                }
            }
            
            // Process gallery items - maintain order by using positional indexes
            if (this.galleryItems.length > 0) {
                let newFileCount = 0;
                let existingFileCount = 0;
                
                // First append position info for all gallery items to maintain the correct order
                this.galleryItems.forEach((item, index) => {
                    // Adding position information for each gallery item
                    formData.append(`gallery_positions[${index}]`, index);
                    
                    if (item.file instanceof File) {
                        // It's a new file upload
                        formData.append(`gallery_files[${index}]`, item.file);
                        formData.append(`gallery_types[${index}]`, 'new');
                        newFileCount++;
                    } else if (item.originalUrl || item.preview) {
                        // It's an existing file from the server
                        const url = item.originalUrl || item.preview;
                        // Don't add to gallery_files, just send the URL as a different field
                        formData.append(`existing_gallery_files[${index}]`, url);
                        formData.append(`gallery_types[${index}]`, 'existing');
                        
                        // If we have an ID, include it
                        if (item.id) {
                            formData.append(`gallery_ids[${index}]`, item.id);
                        }
                        
                        existingFileCount++;
                    }
                });
                
                // Also store the total count of gallery items for server validation
                formData.append('gallery_count', this.galleryItems.length);
                
                console.log(`Gallery submission: ${newFileCount} new files, ${existingFileCount} existing files, total: ${this.galleryItems.length}`);
            } else {
                // No gallery items - indicate that we want to clear existing gallery
                formData.append('clear_gallery', '1');
            }
            
            // Set the request URL based on create/edit mode
            const url = this.isEditMode 
                ? `/projects/${this.projectId}` 
                : '/projects/create';
            
            // Log form data for debugging
            if (process.env.NODE_ENV !== 'production') {
                console.log('Form data entries:');
                for (let [key, value] of formData.entries()) {
                    // Truncate file contents in logs
                    const displayValue = value instanceof File 
                        ? `[File: ${value.name}, ${value.size} bytes]`
                        : value;
                    console.log(`${key}:`, displayValue);
                }
            }
            
            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                // Display success message
                if (window.showGlobalNotification) {
                    window.showGlobalNotification(
                        this.isEditMode ? 'Project updated successfully!' : 'Project created successfully!', 
                        'success'
                    );
                }
                
                // Redirect to the dashboard
                window.location.href = '/dashboard';
            })
            .catch(error => {
                this.submitting = false;
                console.error('Submission error:', error);
                this.errorMessage = error.response?.data?.message || 'An error occurred while saving the project.';
                
                // Scroll to the error message
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        },
        generateSlug() {
            // Convert title to slug
            if (this.form.title) {
                this.form.slug = this.form.title
                    .toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
            }
        },
        fetchCategories() {
            // Fetch categories from the API
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },
        fetchTechnologies() {
            // Fetch technologies from the API
            axios.get('/api/technologies')
                .then(response => {
                    this.technologies = response.data;
                })
                .catch(error => {
                    console.error('Error fetching technologies:', error);
                });
        }
    }
}
</script>

<style scoped>
/* Custom styles for dark theme */
</style>