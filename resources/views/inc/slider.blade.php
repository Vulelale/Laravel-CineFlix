
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<div class="relative w-full max-w-screen-xl mx-auto px-8">
    <div class="swiper-container overflow-hidden">
        <div class="swiper-wrapper">
            @foreach($sliderFilms as $film)
                <div class="swiper-slide">
                    <div class="relative h-[500px] rounded-lg">
                        <img src="{{ asset('storage/' . $film->image_path) }}" 
                             class="w-full h-full object-cover object-right rounded-lg" 
                             alt="{{ $film->Title }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
                        <div class="absolute left-16 top-1/2 -translate-y-1/2 w-[90%] max-w-2xl">
                            <div class="flex flex-col items-start space-y-4 text-left">
                                <h2 class="text-white text-3xl md:text-4xl font-bold">{{ $film->Title }}</h2>
                                @if($film->Description)
                                    <p class="text-white text-lg md:text-xl max-w-[600px]">{{ $film->Description }}</p>
                                @endif
                                <a href="{{ route('movies.show', $film->FilmID) }}" 
                                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                   Gledaj sada
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

       
        <div class="absolute inset-y-0 left-0 flex items-center z-20 ml-8">
            <button class="swiper-button-prev !text-white hover:!text-blue-600 transition-colors">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center z-20 mr-8">
            <button class="swiper-button-next !text-white hover:!text-blue-600 transition-colors">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <div class="swiper-pagination !bottom-4"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: (index, className) => {
                return `<span class="${className} !bg-white !opacity-100 !w-2.5 !h-2.5"></span>`;
            }
        },
    });

   
    swiper.el.addEventListener('mouseenter', () => swiper.autoplay.stop());
    swiper.el.addEventListener('mouseleave', () => swiper.autoplay.start());
});
</script>









