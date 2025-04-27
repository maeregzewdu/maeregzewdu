<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use App\Models\SocialLink;
use App\Models\MyInfo;

class ProjectController extends Controller
{
    public function create()
    {
        return view('project.form');
    }

    public function index(Request $request)
    {
        // For API requests, use pagination and properly format the response
        if($request->wantsJson()) {
            $perPage = $request->input('per_page', 6);
            $page = $request->input('page', 1);
            $query = Project::with('createdBy')->orderBy('created_at', 'desc');
            
            // Apply search if search parameter is provided
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('subtitle', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhere('client_name', 'like', "%{$searchTerm}%")
                      ->orWhere('type', 'like', "%{$searchTerm}%");
                });
            }
            
            // Get paginated results
            $paginatedProjects = $query->paginate($perPage, ['*'], 'page', $page);
            
            // Transform the data
            $projects = $paginatedProjects->map(function($project) {
                // Format technologies and features correctly
                $technologies = is_string($project->technologies) ? json_decode($project->technologies) : $project->technologies;
                $features = is_string($project->features) ? json_decode($project->features) : $project->features;
                $gallery = is_string($project->gallery) ? json_decode($project->gallery) : $project->gallery;
                
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'subtitle' => $project->subtitle,
                    'description' => $project->description,
                    'technologies' => $technologies,
                    'features' => $features,
                    'status' => $project->status,
                    'thumbnail' => $project->thumbnail,
                    'gallery' => $gallery,
                    'type' => $project->type,
                    'category' => $this->mapTypeToCategory($project->type),
                    'client_name' => $project->client_name,
                    'project_url' => $project->project_url,
                    'github_url' => $project->github_url,
                    'is_featured' => (bool)$project->is_featured,
                    'created_by' => $project->createdBy->name,
                    'completed_at' => $project->status === 'Completed' ? $project->updated_at->format('Y-m-d') : null,
                    'created_at' => $project->created_at->format('Y-m-d')
                ];
            });
            
            return response()->json([
                'projects' => $projects,
                'pagination' => [
                    'current_page' => $paginatedProjects->currentPage(),
                    'last_page' => $paginatedProjects->lastPage(),
                    'per_page' => $paginatedProjects->perPage(),
                    'total' => $paginatedProjects->total()
                ]
            ]);
        }

        // For web requests, get all projects and format them the same way as API
        $projects = Project::with('createdBy')->orderBy('created_at', 'desc')->get()->map(function($project) {
            // Format technologies and features correctly
            $technologies = is_string($project->technologies) ? json_decode($project->technologies) : $project->technologies;
            $features = is_string($project->features) ? json_decode($project->features) : $project->features;
            $gallery = is_string($project->gallery) ? json_decode($project->gallery) : $project->gallery;
                
            return [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'subtitle' => $project->subtitle,
                'description' => $project->description,
                'technologies' => $technologies,
                'features' => $features,
                'status' => $project->status,
                'thumbnail' => $project->thumbnail,
                'gallery' => $gallery,
                'type' => $project->type,
                'category' => $this->mapTypeToCategory($project->type),
                'client_name' => $project->client_name,
                'project_url' => $project->project_url,
                'github_url' => $project->github_url,
                'is_featured' => (bool)$project->is_featured,
                'created_by' => $project->createdBy->name,
                'completed_at' => $project->status === 'Completed' ? $project->updated_at->format('Y-m-d') : null,
                'created_at' => $project->created_at->format('Y-m-d')
            ];
        });
        $socialLinks = SocialLink::all();
        $myInfo = MyInfo::first();
        return view('project.index', compact('projects', 'socialLinks', 'myInfo'));
    }

    public function show(Request $request, Project $project)
    {
        if($request->wantsJson()){
            return response()->json($project);
        }
        $socialLinks = SocialLink::all();
        $myInfo = MyInfo::first();
        return view('project.show', compact('project', 'socialLinks', 'myInfo'));
    }

    public function store(Request $request)
    {
        // Dump the full request data for debugging
        $this->dumpRequestData($request, 'STORE');
        
        // Debug the incoming request data
        Log::info('Store request data:', [
            'has_gallery_files' => $request->hasFile('gallery_files'),
            'gallery_files_count' => $request->hasFile('gallery_files') ? (is_array($request->file('gallery_files')) ? count($request->file('gallery_files')) : 1) : 0,
            'gallery_types_count' => $request->has('gallery_types') ? count($request->input('gallery_types', [])) : 0,
            'gallery_positions_count' => $request->has('gallery_positions') ? count($request->input('gallery_positions', [])) : 0,
            'gallery_count' => $request->input('gallery_count'),
            'files' => $request->allFiles() ? array_keys($request->allFiles()) : [],
        ]);

        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'technologies' => 'required|array',
            'features' => 'required|array',
            'status' => 'required',
            'thumbnail' => 'nullable|image',
            'existing_thumbnail' => 'nullable|string',
            'type' => 'required|in:Website,Mobile App,Desktop App,Design',
            'client_name' => 'nullable|string',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'gallery_files' => 'nullable',
            'gallery_files.*' => 'nullable|image',
            'gallery_types' => 'nullable|array',
            'gallery_positions' => 'nullable|array',
            'gallery_count' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('images/thumbnails', 'public_uploads');
            $validated['thumbnail'] = asset($path);
        } elseif ($request->filled('existing_thumbnail')) {
            $validated['thumbnail'] = $request->input('existing_thumbnail');
        }

        // Process gallery images
        $gallery = [];
        
        // Check if we have any gallery information
        if ($this->hasGalleryFilesInRequest($request) || $request->has('gallery_types')) {
            // Get gallery metadata
            $positions = $request->input('gallery_positions', []);
            $types = $request->input('gallery_types', []);
            $count = $request->input('gallery_count', 0);
            
            // Check for direct array of uploaded files
            $uploadedFiles = [];
            if ($request->hasFile('gallery_files')) {
                if (is_array($request->file('gallery_files'))) {
                    $uploadedFiles = $request->file('gallery_files');
                } else {
                    // Single file
                    $uploadedFiles = [$request->file('gallery_files')];
                }
            }
            
            Log::info('Gallery processing (store):', [
                'positions' => $positions,
                'types' => $types,
                'uploadedFiles_count' => count($uploadedFiles),
                'gallery_count' => $count
            ]);
            
            // Create gallery items based on provided indices
            $galleryItems = [];
            
            // Process based on the gallery count
            for ($i = 0; $i < $count; $i++) {
                $position = isset($positions[$i]) ? (int) $positions[$i] : $i;
                $type = isset($types[$i]) ? $types[$i] : 'new';
                
                $galleryItems[] = [
                    'position' => $position,
                    'type' => $type,
                    'index' => $i
                ];
            }
            
            // Sort by position
            usort($galleryItems, function($a, $b) {
                return $a['position'] <=> $b['position'];
            });
            
            // Process each item
            foreach ($galleryItems as $item) {
                $index = $item['index'];
                $type = $item['type'];
                
                if ($type === 'new') {
                    // Try to get the file from the uploaded files array
                    $file = isset($uploadedFiles[$index]) ? $uploadedFiles[$index] : null;
                    
                    // If not found, try alternate methods
                    if (!$file) {
                        $file = $this->getFileFromRequest($request, $index);
                    }
                    
                    if ($file) {
                        $path = $file->storeAs(
                            'images/gallery', // Save into public/images/gallery
                            $file->hashName(), // Keep unique file names
                            'public_uploads'   // NEW disk we define (maps to public/)
                        );
                    
                        $gallery[] = [
                            'url' => asset($path),
                            'position' => $item['position'],
                        ];
                    } else {
                        Log::warning("No file found for gallery index {$index} in store method despite type being 'new'");
                    }
                }
                // We don't process existing files in store method as they shouldn't exist yet
            }
        }
        
        // Store the gallery as JSON in the database
        $validated['gallery'] = json_encode($gallery);

        // Handle featured status
        $validated['is_featured'] = $request->is_featured === true ? 1 : 0;

        // Encode array fields as JSON
        $validated['technologies'] = json_encode($validated['technologies']);
        $validated['features'] = json_encode($validated['features']);

        // Remove fields that shouldn't be saved directly to the model
        unset($validated['gallery_files']);
        unset($validated['gallery_types']);
        unset($validated['gallery_positions']);
        unset($validated['gallery_count']);
        unset($validated['existing_thumbnail']);

        Log::info('Validated data before create:', $validated);

        Project::create($validated);

        if($request->wantsJson()){
            return response()->json(['message' => 'Project created successfully.']);
        }
        return redirect()->back()->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('project.form', compact('project'));
    }

    private function hasGalleryFilesInRequest(Request $request)
    {
        // Check if gallery_files is in the files array
        if ($request->hasFile('gallery_files')) {
            return true;
        }
        
        // Check for files with keys like gallery_files.0, gallery_files[0]
        foreach ($request->allFiles() as $key => $value) {
            if ($key === 'gallery_files' || strpos($key, 'gallery_files[') === 0 || strpos($key, 'gallery_files.') === 0) {
                return true;
            }
        }
        
        // Check for non-file gallery_files that might be existing file URLs
        return $request->has('gallery_files') && !empty($request->input('gallery_files'));
    }
    
    private function getFileFromRequest(Request $request, $index)
    {
        // First, try as a direct upload from array
        if ($request->hasFile('gallery_files') && is_array($request->file('gallery_files'))) {
            $files = $request->file('gallery_files');
            if (isset($files[$index])) {
                return $files[$index];
            }
        }
        
        // Try different possible formats for file inputs
        $formats = [
            "gallery_files.{$index}",
            "gallery_files[{$index}]"
        ];
        
        foreach ($formats as $format) {
            if ($request->hasFile($format)) {
                return $request->file($format);
            }
        }
        
        return null;
    }

    private function dumpRequestData(Request $request, $prefix = '')
    {
        // Get the raw request data
        $content = $request->getContent();
        $rawData = '';
        
        // If it's multipart/form-data, this may not be JSON
        if ($content && strlen($content) < 5000) { // Limit to avoid huge logs
            $rawData = $content;
        } else {
            $rawData = 'Content too large or empty';
        }
        
        // Log all raw input
        Log::info($prefix . ' Raw Request Data:', [
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method(),
            'raw_content' => $rawData,
            'all_inputs' => $request->all(),
            'file_keys' => array_keys($request->allFiles())
        ]);
    }

    public function update(Request $request, Project $project)
    {
        // Dump the full request data for debugging
        $this->dumpRequestData($request, 'UPDATE');
        
        // Debug the incoming request data
        Log::info('Request data:', [
            'has_gallery_files' => $request->hasFile('gallery_files'),
            'gallery_files_count' => $request->hasFile('gallery_files') ? (is_array($request->file('gallery_files')) ? count($request->file('gallery_files')) : 1) : 0,
            'gallery_types_count' => $request->has('gallery_types') ? count($request->input('gallery_types', [])) : 0,
            'gallery_positions_count' => $request->has('gallery_positions') ? count($request->input('gallery_positions', [])) : 0,
            'clear_gallery' => $request->input('clear_gallery'),
            'gallery_count' => $request->input('gallery_count'),
            'existing_gallery_count' => $request->has('existing_gallery_files') ? count($request->input('existing_gallery_files', [])) : 0,
            'files' => $request->allFiles() ? array_keys($request->allFiles()) : [],
            'is_featured' => $request->is_featured,
        ]);

        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'technologies' => 'required|array',
            'features' => 'required|array',
            'status' => 'required',
            'thumbnail' => 'nullable|image',
            'existing_thumbnail' => 'nullable|string',
            'type' => 'required|in:Website,Mobile App,Desktop App,Design',
            'client_name' => 'nullable|string',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'gallery_files' => 'nullable',
            'gallery_files.*' => 'nullable|image',
            'existing_gallery_files' => 'nullable|array',
            'existing_gallery_files.*' => 'nullable|string',
            'gallery_types' => 'nullable|array',
            'gallery_positions' => 'nullable|array',
            'gallery_ids' => 'nullable|array',
            'gallery_count' => 'nullable|integer',
            'clear_gallery' => 'nullable|boolean',
        ]);

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($project->thumbnail) {
                $oldPath = public_path($project->thumbnail);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Save the new thumbnail
            $path = $request->file('thumbnail')->store('images/thumbnails', 'public_uploads');
            $validated['thumbnail'] = $path; // already relative to /public
        } elseif ($request->filled('existing_thumbnail')) {
            $validated['thumbnail'] = $request->input('existing_thumbnail');
        }

        // Handle gallery
        $currentGallery = json_decode($project->gallery, true) ?: [];
        $existingGalleryMap = [];
        
        // Create a map of existing gallery items for faster lookups
        foreach ($currentGallery as $item) {
            if (is_array($item) && isset($item['url'])) {
                $url = $item['url'];
                $existingGalleryMap[$url] = $item;
            } else if (is_string($item)) {
                $existingGalleryMap[$item] = ['url' => $item];
            }
        }
        
        // Check if we need to clear the gallery
        if ($request->input('clear_gallery')) {
            // Delete all existing gallery files
            foreach ($currentGallery as $item) {
                $url = is_array($item) ? ($item['url'] ?? '') : $item;
                if (!empty($url)) {
                    $oldPath = public_path($url);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
            $validated['gallery'] = json_encode([]);
        } else {
            $gallery = [];
            
            // Check if we have any gallery information
            if ($this->hasGalleryFilesInRequest($request) || $request->has('gallery_types')) {
                // Get gallery metadata
                $positions = $request->input('gallery_positions', []);
                $types = $request->input('gallery_types', []);
                $ids = $request->input('gallery_ids', []);
                $count = $request->input('gallery_count', 0);
                
                // Check for direct array of uploaded files
                $uploadedFiles = [];
                if ($request->hasFile('gallery_files')) {
                    if (is_array($request->file('gallery_files'))) {
                        $uploadedFiles = $request->file('gallery_files');
                    } else {
                        // Single file
                        $uploadedFiles = [$request->file('gallery_files')];
                    }
                }
                
                Log::info('Gallery processing:', [
                    'positions' => $positions,
                    'types' => $types,
                    'uploadedFiles_count' => count($uploadedFiles),
                    'ids' => $ids,
                    'gallery_count' => $count
                ]);
                
                // Create gallery items based on provided indices
                $galleryItems = [];
                
                // Process based on the gallery count
                for ($i = 0; $i < $count; $i++) {
                    $position = isset($positions[$i]) ? (int) $positions[$i] : $i;
                    $type = isset($types[$i]) ? $types[$i] : 'new';
                    $id = isset($ids[$i]) ? $ids[$i] : null;
                    
                    $galleryItems[] = [
                        'position' => $position,
                        'type' => $type,
                        'index' => $i,
                        'id' => $id
                    ];
                }
                
                // Sort by position
                usort($galleryItems, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
                
                // Track used existing images to know which ones to delete
                $usedExistingImages = [];
                
                // Process each item
                foreach ($galleryItems as $item) {
                    $index = $item['index'];
                    $type = $item['type'];
                    
                    if ($type === 'new') {
                        // Try to get the file from the uploaded files array
                        $file = isset($uploadedFiles[$index]) ? $uploadedFiles[$index] : null;
                    
                        // If not found, try alternate methods
                        if (!$file) {
                            $file = $this->getFileFromRequest($request, $index);
                        }
                    
                        if ($file) {
                            // Store the file using your custom disk and folder
                            $path = $file->store('gallery', 'public_uploads');
                    
                            // Save the relative path to the database
                            $gallery[] = [
                                'id' => $item['id'],
                                'url' => $path,  
                                'position' => $item['position'],
                            ];
                    
                            Log::info("Processed new file: index {$index}");
                        } else {
                            Log::warning("No file found for gallery index {$index} despite type being 'new'");
                        }
                    } else if ($type === 'existing') {
                        $url = null;
                        
                        // Try to get from request input if available
                        if ($request->has("gallery_files.{$index}")) {
                            $url = $request->input("gallery_files.{$index}");
                        } else if ($request->has("existing_gallery_files.{$index}")) {
                            $url = $request->input("existing_gallery_files.{$index}");
                        } else if ($request->has('gallery_files') && is_array($request->input('gallery_files'))) {
                            $galleryFiles = $request->input('gallery_files');
                            if (isset($galleryFiles[$index])) {
                                $url = $galleryFiles[$index];
                            }
                        } else if ($request->has('existing_gallery_files') && is_array($request->input('existing_gallery_files'))) {
                            $galleryFiles = $request->input('existing_gallery_files');
                            if (isset($galleryFiles[$index])) {
                                $url = $galleryFiles[$index];
                            }
                        }
                        
                        if (!$url && $index < count($currentGallery)) {
                            // Try to use the existing gallery item
                            $existingItem = $currentGallery[$index];
                            $url = is_array($existingItem) ? ($existingItem['url'] ?? null) : $existingItem;
                        }
                        
                        if ($url) {
                            $usedExistingImages[] = $url;
                            
                            Log::info("Processing existing file: {$url}");
                            
                            // Use existing metadata but update the position
                            if (isset($existingGalleryMap[$url])) {
                                $existingItem = $existingGalleryMap[$url];
                                if (is_array($existingItem)) {
                                    $existingItem['position'] = $item['position'];
                                    if ($item['id']) {
                                        $existingItem['id'] = $item['id'];
                                    }
                                    $gallery[] = $existingItem;
                                } else {
                                    $gallery[] = [
                                        'id' => $item['id'],
                                        'url' => $url,
                                        'position' => $item['position'],
                                    ];
                                }
                            } else {
                                $gallery[] = [
                                    'id' => $item['id'],
                                    'url' => $url,
                                    'position' => $item['position'],
                                ];
                            }
                        } else {
                            Log::warning("No URL found for existing gallery item at index {$index}");
                        }
                    }
                }
                
                // Delete any removed existing images
                foreach ($existingGalleryMap as $url => $item) {
                    if (!in_array($url, $usedExistingImages)) {
                        $oldPath = public_path($url);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
                
                $validated['gallery'] = json_encode($gallery);
            } else {
                // If no gallery items found but we don't want to clear, keep existing gallery
                $validated['gallery'] = $project->gallery;
            }
        }
        // Handle featured status
        $validated['is_featured'] = $request->is_featured ? 1 : 0;

        // Encode array fields as JSON
        $validated['technologies'] = json_encode($validated['technologies']);
        $validated['features'] = json_encode($validated['features']);

        // Remove fields that shouldn't be saved directly to the model
        unset($validated['gallery_files']);
        unset($validated['existing_gallery_files']);
        unset($validated['gallery_types']);
        unset($validated['gallery_positions']);
        unset($validated['gallery_ids']);
        unset($validated['gallery_count']);
        unset($validated['clear_gallery']);
        unset($validated['existing_thumbnail']);

        Log::info('Validated data before update:', $validated);

        $project->update($validated);

        if($request->wantsJson()){
            return response()->json(['message' => 'Project updated successfully.']);
        }
        return redirect()->back()->with('success', 'Project updated successfully.');
    }

    public function destroy(Request $request, Project $project)
    {
        $project->delete();

        if($request->wantsJson()){
            return response()->json(['message' => 'Project deleted successfully.']);
        }
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }

    public function forceDelete(Request $request, Project $project)
    {
        $project->forceDelete();
        if($request->wantsJson()){
            return response()->json(['message' => 'Project permanently deleted successfully.']);
        }
        return redirect()->back()->with('success', 'Project permanently deleted successfully.');
    }

    public function restore(Request $request, Project $project)
    {
        $project->restore();
        if($request->wantsJson()){
            return response()->json(['message' => 'Project restored successfully.']);
        }
        return redirect()->back()->with('success', 'Project restored successfully.');
    }

    public function trashedProjects(Request $request)
    {
        $projects = Project::onlyTrashed()->get();
        if($request->wantsJson()){
            return response()->json($projects);
        }
        return view('project.trashed', compact('projects'));
    }

    // Helper method to map project type to a broader category for filtering
    private function mapTypeToCategory($type)
    {
        switch ($type) {
            case 'Website':
                return 'web-app';
            case 'Mobile App':
            case 'Desktop App':
                return 'app';
            case 'Design':
                return 'ui-ux';
            default:
                return 'web-app';
        }
    }
}