<div class="glass-nav p-8 rounded-xl border border-white/10 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-[#F5D061]/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/5 rounded-full blur-xl translate-y-1/2 -translate-x-1/2"></div>
    
    <h3 class="text-2xl font-russo mb-2 relative">Follow Me</h3>
    <p class="text-gray-400 text-sm mb-6 relative">Connect with me on social media</p>
    
    <div class="grid grid-cols-4 sm:grid-cols-8 gap-4 relative">
        @foreach ($socialLinks as $socialLink)
            <a href="{{ $socialLink->url }}" target="_blank"
               class="{{ $socialLink->is_active ? 'group w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-[#F5D061]/10' : 'hidden' }}"
            >
                <i class="{{ $socialLink->icon }} text-[#F5D061] text-2xl group-hover:text-[#F5D061] transition-colors"></i>
                <span class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-[#1A2332] text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                    {{ $socialLink->platform }}
                </span>
            </a>
        @endforeach
    </div>
    
    <div class="mt-8 pt-6 border-t border-white/10 relative">
        <p class="text-sm text-gray-400">Let's connect and share ideas!</p>
    </div>
</div> 