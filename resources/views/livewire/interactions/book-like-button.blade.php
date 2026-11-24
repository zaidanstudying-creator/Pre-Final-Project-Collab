<button type="button"
    wire:click="toggleLike"
    wire:loading.attr="disabled"
    class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-sm font-bold transition-all duration-200 border shadow-sm group {{ $isLiked ? 'bg-orange-50 border-[#FF500A] text-[#FF500A]' : 'bg-white border-gray-300 text-gray-700 hover:border-[#FF500A] hover:text-[#FF500A] hover:bg-orange-50/50' }}"
    title="{{ $isLiked ? 'Batalkan suka' : 'Sukai cerita ini' }}">
    
    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110 {{ $isLiked ? 'fill-[#FF500A] stroke-[#FF500A]' : 'fill-none stroke-current' }}"
        viewBox="0 0 24 24"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
    </svg>

    <span>{{ $isLiked ? 'Disukai' : 'Suka' }}</span>
    <span class="px-2 py-0.5 text-xs font-extrabold rounded-full {{ $isLiked ? 'bg-[#FF500A] text-white' : 'bg-gray-100 text-gray-600 group-hover:bg-orange-100 group-hover:text-[#FF500A]' }}">
        {{ $likesCount }}
    </span>
</button>
