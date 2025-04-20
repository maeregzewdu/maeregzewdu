<div class="glass-nav p-8 rounded-xl border border-white/10">
    <h3 class="text-2xl font-russo mb-6">Connect With Me</h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($socialLinks as $socialLink)
            <a href="{{ $socialLink->url }}" target="_blank"
               class="{{ $socialLink->is_active ? 'p-4 rounded-lg border border-white/10 hover:border-[#F5D061]/30 transition-all duration-300 flex items-center gap-3 group' : 'hidden' }}">
                <div class="w-10 h-10 rounded-lg bg-[#F5D061]/10 flex items-center justify-center group-hover:bg-[#F5D061]/20 transition-colors">
                    <i class="{{ $socialLink->icon }} text-[#F5D061] text-xl"></i>
                </div>
                <div>
                    <p class="text-white font-medium">{{ $socialLink->platform }}</p>
                    <p class="text-xs text-gray-400">{{ explode('/', $socialLink->url)[count(explode('/', $socialLink->url)) - 1] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div> 