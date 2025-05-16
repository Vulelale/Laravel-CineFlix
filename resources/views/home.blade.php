<x-app>
    @section('title', 'CineFlix-Početna')

    {{-- Slider --}}
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
                                <a href="{{ route('movies.show', $film->FilmID) }}" 
                                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                   Kupi sada
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


{{-- Najnoviji filmovi iz baze --}}
    <h2 class="text-white font-bold text-4xl text-center mt-10 mx-auto w-full">
        Preporučeno za Vas
    </h2>
    
<div class="flex flex-wrap justify-center gap-4 px-4 py-10">
    @foreach($recommendedFilms as $film)
        <a href="{{ route('movies.show', $film->FilmID) }}" 
           class="block w-[250px] h-[400px] overflow-hidden rounded-lg transition-transform hover:scale-105">
            <img 
                src="{{ asset('storage/' . $film->image_path) }}" 
                alt="{{ $film->Title }}"
                class="w-full h-full object-cover">
            <h3 class="text-center mt-2 text-white">{{ $film->Title }}</h3>
        </a>
    @endforeach
</div>


{{-- Serije --}}
<h2 class="text-white font-bold text-4xl text-center mt-5 mx-auto w-full">
    Najnovije Serije
</h2>

<div class="flex flex-wrap justify-center gap-4 px-4 py-10">
    @foreach($recommendedSeries as $series)
        <a href="{{ route('series.show', $series->SeriesID) }}" 
           class="block w-[250px] h-[400px] overflow-hidden rounded-lg transition-transform hover:scale-105">
            <img 
                src="{{ asset('storage/' . $series->image_path) }}" 
                alt="{{ $series->title }}"
                class="w-full h-full object-cover">
            <h3 class="text-center mt-2 text-white">{{ $series->title }}</h3>
        </a>
    @endforeach
</div>





 
</x-app>

