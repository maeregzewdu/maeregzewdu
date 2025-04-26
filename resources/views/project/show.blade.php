<x-app :myInfo="$myInfo" :socialLinks="$socialLinks">
    <section class="py-40 bg-[#0F172A] relative overflow-hidden min-h-screen">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#F5D061]/5 rounded-full blur-3xl"></div>
            <!-- Futuristic grid lines -->
            <div class="absolute inset-0 grid-lines"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="/projects" class="inline-flex items-center gap-2 text-gray-400 hover:text-[#F5D061] transition-all duration-300">
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Projects</span>
                </a>
            </div>

            <!-- Project Header -->
            <div class="bg-[#1A2332]/85 backdrop-blur-md rounded-xl overflow-hidden border border-white/10 mb-8 md:mb-12">
                <div class="md:flex">
                    <!-- Project Thumbnail -->
                    <div class="md:w-1/2 relative">
                        <div class="aspect-video md:h-full relative overflow-hidden">
                            @if($project['thumbnail'])
                                <img src="{{ $project['thumbnail'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#1A2332]">
                                    <i class="ri-image-line text-6xl text-gray-500"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0F172A]/50"></div>
                        </div>
                        
                        <!-- Project Status Badge (if applicable) -->
                        @if($project['status'])
                            <div class="absolute top-4 right-4 z-10">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    {{ $project['status'] == 'Completed' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 
                                      ($project['status'] == 'In Progress' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 
                                      'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30') }}">
                                    {{ $project['status'] }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Project Info -->
                    <div class="md:w-1/2 p-6 md:p-8">
                        <!-- Project Type Badge -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-grow">
                                <span class="px-3 py-1 text-xs rounded-lg bg-[#0F172A] text-gray-400 inline-block">
                                    {{ $project['type'] }}
                                </span>
                            </div>
                        </div>

                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-russo mb-4 text-white">{{ $project['title'] }}</h1>
                        
                        <!-- Technology Stack -->
                        <div class="mb-6">
                            <h3 class="text-sm text-gray-400 mb-2">Technologies Used</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $technologies = is_string($project['technologies']) ? json_decode($project['technologies'], true) : $project['technologies'];
                                @endphp
                                @if(is_array($technologies))
                                    @foreach($technologies as $tech)
                                        <span class="px-3 py-1 bg-[#1A2332] text-[#F5D061] text-xs rounded-lg border border-[#F5D061]/20">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                @else
                                    <p class="text-gray-400">No technologies listed.</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Project Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @if($project['client_name'])
                                <div>
                                    <h3 class="text-sm text-gray-400 mb-1">Client</h3>
                                    <p class="text-white">{{ $project['client_name'] }}</p>
                                </div>
                            @endif
                            
                            @if($project['completed_at'])
                                <div>
                                    <h3 class="text-sm text-gray-400 mb-1">Completed</h3>
                                    <p class="text-white">{{ date('F Y', strtotime($project['completed_at'])) }}</p>
                                </div>
                            @endif
                            
                            @if($project['duration'])
                                <div>
                                    <h3 class="text-sm text-gray-400 mb-1">Duration</h3>
                                    <p class="text-white">{{ $project['duration'] }}</p>
                                </div>
                            @endif
                            
                            @if($project['industry'])
                                <div>
                                    <h3 class="text-sm text-gray-400 mb-1">Industry</h3>
                                    <p class="text-white">{{ $project['industry'] }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Live Demo Button -->
                        @if($project['project_url'])
                            <div class="mt-6">
                                <a href="{{ $project['project_url'] }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-[#F5D061] text-black px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-[#F5D061]/90 transition-all duration-300 hover:scale-105">
                                    <i class="ri-external-link-line"></i>
                                    View Live Demo
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Project Details Section -->
            <div class="bg-[#1A2332]/85 backdrop-blur-md rounded-xl border border-white/10 p-6 md:p-8 mb-16 md:mb-20">
                <h2 class="text-xl md:text-2xl font-russo mb-4 text-white">Project Overview</h2>
                <div class="prose prose-invert max-w-none">
                    <p class="text-gray-300">{{ $project['description'] }}</p>
                </div>
                
                @if($project['features'])
                    <h2 class="text-xl md:text-xl font-russo mb-4 mt-8 text-white">Features</h2>
                    @php
                        $features = is_string($project['features']) ? json_decode($project['features'], true) : $project['features'];
                    @endphp
                    <div class="space-y-4">
                        @foreach ($features as $feature)
                            <div class="flex items-start gap-2">
                                <div class="text-amber-400 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-base leading-relaxed">
                                    {{ $feature }}
                                </p>
                            </div>                    
                        @endforeach
                    <div>
                @endif
                
                @if($project['solution'])
                    <h2 class="text-xl md:text-xl font-russo mb-4 mt-8 text-white">The Solution</h2>
                    <div class="prose prose-invert max-w-none">
                        <p class="text-gray-300">{{ $project['solution'] }}</p>
                    </div>
                @endif
                
                @if($project['results'])
                    <h2 class="text-xl md:text-xl font-russo mb-4 mt-8 text-white">Results</h2>
                    <div class="prose prose-invert max-w-none">
                        <p class="text-gray-300">{{ $project['results'] }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Project Gallery -->
            @if(isset($project['gallery']) && $project['gallery'] > 0)
                <div class="pt-6 md:pt-8 mb-8 md:mb-12">
                    <h2 class="text-xl md:text-2xl font-russo mb-6 text-white">Project Gallery</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $images = is_string($project['gallery']) ? json_decode($project['gallery'], true) : $project['gallery'];

                            // Sort the images by 'position'
                            usort($images, function ($a, $b) {
                                return $a['position'] <=> $b['position'];
                            });
                        @endphp
                        @foreach($images as $image)
                            <div class="aspect-video rounded-lg overflow-hidden bg-[#0F172A] border border-white/5 group relative">
                                <img src="{{ $image['url'] }}" alt="Project Image" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                        @endforeach                    
                    </div>
                </div>
            @endif
            
            <!-- Related Projects -->
            @if(isset($relatedProjects) && count($relatedProjects) > 0)
                <div class="mt-12">
                    <h2 class="text-xl md:text-2xl font-russo mb-6 text-white">Related Projects</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedProjects as $relatedProject)
                            <div class="bg-[#1A2332]/85 backdrop-blur-md rounded-xl overflow-hidden border border-white/10 hover:border-[#F5D061]/30 transition-all duration-500 group hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1">
                                <!-- Image Container -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $relatedProject['thumbnail'] }}" alt="{{ $relatedProject['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                                </div>
                                <!-- Content -->
                                <div class="p-5">
                                    <h3 class="text-lg font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">{{ $relatedProject['title'] }}</h3>
                                    <div class="flex justify-between items-center pt-3 border-t border-white/5">
                                        <span class="text-xs text-gray-500">{{ $relatedProject['type'] }}</span>
                                        <a href="/projects/{{ $relatedProject['id'] }}" class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                            View
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
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

        /* Add Russo One font if needed */
        .font-russo {
            font-family: 'Russo One', sans-serif;
        }
        
        /* Style for the prose content */
        .prose {
            color: #94a3b8;
            line-height: 1.7;
        }
        
        .prose p {
            margin-bottom: 1rem;
        }
    </style>
</x-app>