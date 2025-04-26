<x-app :socialLinks="$socialLinks" :myInfo="$myInfo">
    <section class="py-40 bg-[#0F172A] relative overflow-hidden min-h-screen">
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
                <h1 class="text-3xl md:text-5xl font-russo mb-3 md:mb-4 text-white">Our Projects</h1>
                <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base">
                    Explore our portfolio of innovative digital solutions, meticulously crafted to deliver exceptional user experiences and business value.
                </p>
            </div>

            <!-- Filters Section -->
            {{-- <div class="bg-[#1A2332]/85 backdrop-blur-md mb-8 md:mb-12 p-6 rounded-xl border border-white/10 shadow-lg">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-8">
                    <!-- Search Input -->
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-search-line text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            placeholder="Search projects..." 
                            class="w-full py-2.5 pl-10 pr-4 bg-[#1A2332]/70 border border-white/5 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F5D061]/50 focus:border-transparent text-white"
                        >
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-2 md:gap-3">
                        <button class="py-2 px-4 md:px-5 rounded-lg text-sm md:text-base transition-all duration-300 text-white bg-[#F5D061]/20 border border-[#F5D061]/30">
                            All
                        </button>
                        <button class="py-2 px-4 md:px-5 rounded-lg text-sm md:text-base transition-all duration-300 text-gray-300 bg-[#1A2332]/50 border border-white/5 hover:bg-[#1A2332]/70 hover:text-white">
                            Web Apps
                        </button>
                        <button class="py-2 px-4 md:px-5 rounded-lg text-sm md:text-base transition-all duration-300 text-gray-300 bg-[#1A2332]/50 border border-white/5 hover:bg-[#1A2332]/70 hover:text-white">
                            E-commerce
                        </button>
                        <button class="py-2 px-4 md:px-5 rounded-lg text-sm md:text-base transition-all duration-300 text-gray-300 bg-[#1A2332]/50 border border-white/5 hover:bg-[#1A2332]/70 hover:text-white">
                            UI/UX Design
                        </button>
                    </div>
                </div>
            </div> --}}

            @php
                $featuredProject = collect($projects)->firstWhere('is_featured', true);
                $regularProjects = collect($projects)->where('is_featured', false)->take(6);
            @endphp

            <!-- Featured Project -->
            @if($featuredProject)
                <div class="mb-10 md:mb-16">
                    <div class="bg-[#1A2332]/85 backdrop-blur-md rounded-xl overflow-hidden border border-white/10 hover:border-[#F5D061]/30 transition-all duration-500 group shadow-lg">
                        <div class="grid md:grid-cols-2 gap-0">
                            <!-- Image Section -->
                            <div class="relative overflow-hidden h-64 md:h-auto md:aspect-auto">
                                <img src="{{ $featuredProject['thumbnail'] }}" alt="{{ $featuredProject['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A]/80 via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#F5D061] text-black text-xs font-bold px-3 py-1 rounded-full">Featured</span>
                                </div>
                            </div>  
                            
                            <!-- Content Section -->
                            <div class="p-6 md:p-8 flex flex-col">
                                <!-- Project Type Badge -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-grow">
                                        <span class="px-3 py-1 text-xs rounded-lg bg-[#0F172A] text-gray-400 inline-block">
                                            {{ $featuredProject['type'] }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($featuredProject['technologies'] as $tech)
                                            <span class="px-3 py-1 bg-[#1A2332] text-[#F5D061] text-xs rounded-lg border border-[#F5D061]/20">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{ route('projects.show', $featuredProject['id']) }}" class="text-2xl md:text-3xl font-russo mb-3 text-white group-hover:text-[#F5D061] transition-colors">{{ $featuredProject['title'] }}</a>
                                <p class="text-gray-400 mb-6 md:mb-auto flex-grow">{{ $featuredProject['description'] }}</p>
                                
                                <!-- Additional Info -->
                                <div class="text-sm text-gray-500 mb-4">
                                    @if($featuredProject['client_name'])
                                        <div class="flex items-center mb-1">
                                            <i class="ri-user-3-line mr-2 text-[#F5D061]"></i>
                                            <span>Client: {{ $featuredProject['client_name'] }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center">
                                        <i class="ri-calendar-line mr-2 text-[#F5D061]"></i>
                                        <span>{{ $featuredProject['completed_at'] ? 'Completed: ' . date('F Y', strtotime($featuredProject['completed_at'])) : 'In Progress' }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-4 pt-3 border-t border-white/5">
                                    @if($featuredProject['project_url'])
                                        <a href="{{ $featuredProject['project_url'] }}" target="_blank" class="inline-flex items-center text-blue-400 text-sm hover:text-blue-300">
                                            <i class="ri-external-link-line mr-1"></i>
                                            Live Demo
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-500">{{ $featuredProject['created_at'] ? date('M Y', strtotime($featuredProject['created_at'])) : '' }}</span>
                                    @endif
                                    <a href="/projects/{{ $featuredProject['id'] }}" class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                        View Project
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Project Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($regularProjects as $project)
                    <div class="bg-[#1A2332]/85 backdrop-blur-md rounded-xl overflow-hidden border border-white/10 hover:border-[#F5D061]/30 transition-all duration-500 group hover:shadow-[0_0_30px_rgba(245,208,97,0.15)] transform hover:-translate-y-1">
                        <!-- Image Container -->
                        <div class="relative h-48 overflow-hidden">
                            @if($project['thumbnail'])
                                <img src="{{ $project['thumbnail'] }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#1A2332]">
                                    <i class="ri-image-line text-5xl text-gray-500"></i>
                                </div>
                            @endif
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A]/90 via-[#0F172A]/40 to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-500"></div>
                            
                            <!-- Featured badge if applicable -->
                            @if($project['is_featured'])
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-xs rounded-full bg-[#F5D061]/20 text-[#F5D061] border border-[#F5D061]/30">
                                        Featured
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Project Type Badge -->
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-grow">
                                    <span class="px-3 py-1 text-xs rounded-lg bg-[#0F172A] text-gray-400 inline-block">
                                        {{ $project['type'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Tech stack badges -->
                            <div class="flex flex-wrap gap-2 mb-3 -mt-2 relative z-10">
                                @foreach($project['technologies'] as $tech)
                                    <span class="bg-[#1A2332] text-[#F5D061] text-xs px-3 py-1 rounded-lg border border-[#F5D061]/20">{{ $tech }}</span>
                                @endforeach
                            </div>

                            <a href="{{ route('projects.show', $project['id']) }}" class="text-xl font-russo mb-2 text-white group-hover:text-[#F5D061] transition-colors">{{ $project['title'] }}</a>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $project['description'] }}</p>

                            <!-- Additional Info -->
                            <div class="text-sm text-gray-500 mb-4">
                                @if($project['client_name'])
                                    <div class="flex items-center mb-1">
                                        <i class="ri-user-3-line mr-2 text-[#F5D061]"></i>
                                        <span>Client: {{ $project['client_name'] }}</span>
                                    </div>
                                @endif
                                @if($project['completed_at'])
                                    <div class="flex items-center">
                                        <i class="ri-calendar-line mr-2 text-[#F5D061]"></i>
                                        <span>Completed: {{ date('F Y', strtotime($project['completed_at'])) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-between items-center pt-3 border-t border-white/5">
                                @if($project['project_url'])
                                    <a href="{{ $project['project_url'] }}" target="_blank" class="inline-flex items-center text-blue-400 text-sm hover:text-blue-300">
                                        <i class="ri-external-link-line mr-1"></i>
                                        Live Demo
                                    </a>
                                @else
                                    <span class="text-xs text-gray-500">{{ $project['created_at'] ? date('M Y', strtotime($project['created_at'])) : '' }}</span>
                                @endif
                                <a href="/projects/{{ $project['id'] }}" class="inline-flex items-center gap-1 text-[#F5D061] text-sm font-medium transition-all duration-300 hover:gap-2">
                                    Details
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
    </style>
</x-app>
