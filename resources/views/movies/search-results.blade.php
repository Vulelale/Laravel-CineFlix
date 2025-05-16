<x-app>
    @section('title', 'Rezultati pretrage')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl text-center font-bold text-white mb-6">Rezultati pretrage za "{{ $query }}"</h1>
        

        <h3 class="text-2xl font-bold text-white mt-5 mb-6">Filmovi:</h3>
        @if($films->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($films as $film)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:transform hover:scale-105 transition-all">
                        <a href="{{ route('movies.show', $film->FilmID) }}">
                            <img src="{{ asset('storage/' . $film->image_path) }}" 
                                 alt="{{ $film->Title }}" 
                                 class="w-full h-64 object-cover">
                            <div class="p-4">
                                <h3 class="text-white font-bold text-lg">{{ $film->Title }}</h3>
                                <p class="text-gray-400 text-sm mt-2">
                                    {{ $film->ReleaseDate}} • 
                                    {{ floor($film->Duration / 60) }}h {{ $film->Duration % 60 }}min
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-400 text-xl">Nema rezultata za vašu pretragu.</p>
            </div>
        @endif

        {{ $films->links('pagination.page') }}

        <h3 class="text-2xl font-bold text-white mt-5 mb-6">Serije:</h3>
        
        @if($series->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($series as $serie)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:transform hover:scale-105 transition-all">
                    <a href="{{ route('series.show', $serie->SeriesID) }}">
                        <img src="{{ asset('storage/' . $serie->image_path) }}" 
                             alt="{{ $serie->Title }}" 
                             class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-white font-bold text-lg">{{ $serie->title }}</h3>
                            <p class="text-gray-400 text-sm">{{ $serie->release_date}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-400 text-xl">Nema rezultata za vašu pretragu.</p>
        </div>
    @endif
    </div>
</x-app>