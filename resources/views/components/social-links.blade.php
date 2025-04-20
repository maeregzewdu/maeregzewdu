<div class="glass-nav p-8 rounded-xl border border-white/10">
    <h3 class="text-2xl font-russo mb-6">Follow Me</h3>
    <div class="flex gap-4 flex-wrap">
        @foreach ($socialLinks as $socialLink)
            <a href="{{ $socialLink->url }}" target="_blank"
               class="{{ $socialLink->is_active ? 'w-12 h-12 bg-[#F5D061]/10 rounded-lg flex items-center justify-center hover:bg-[#F5D061]/20 transition-colors' : 'hidden' }}"
               title="{{ $socialLink->platform }}">
                <i class="{{ $socialLink->icon }} text-[#F5D061] text-2xl"></i>
            </a>
        @endforeach
    </div>
</div> 