<div class="flex items-center gap-2">
    <div class="flex gap-3">
        @foreach ($socialLinks as $socialLink)
            <a href="{{ $socialLink->url }}" target="_blank"
               class="{{ $socialLink->is_active ? 'transition-all duration-300 hover:scale-110' : 'hidden' }}"
               title="{{ $socialLink->platform }}">
                <i class="{{ $socialLink->icon }} text-[#F5D061] text-xl"></i>
            </a>
        @endforeach
    </div>
</div> 