<x-app>
    @section('title', 'CineFlix-Filmovi')

    <div class="flex flex-wrap justify-center gap-4 px-4 py-10">
        @foreach ($films->chunk(4) as $row)
            <div class="flex flex-wrap justify-center gap-4 w-full mb-8">
                @foreach ($row as $film)
                    <a href="{{ route('movies.show', $film->FilmID) }}" class="w-[19%] hover:scale-105 transition-transform">
                        <div class="h-[400px] overflow-hidden rounded-lg shadow-lg">
                            <img 
                                src="{{ asset('storage/' . $film->image_path) }}" 
                                alt="{{ $film->Title }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <h3 class="text-center mt-2 font-bold text-white">{{ $film->Title }}</h3>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app>