<x-app>
    @section('title', 'CineFlix-Serije')
    
    <div class="flex flex-wrap justify-center gap-4 px-4 py-10">
        @foreach ($series->chunk(4) as $row) 
            <div class="flex flex-wrap justify-center gap-4 w-full mb-8">
                @foreach ($row as $singleSeries) 
                    <a href="{{ route('series.show', $singleSeries->SeriesID) }}" class="w-[19%] hover:scale-105 transition-transform">
                        <div class="h-[400px] overflow-hidden rounded-lg shadow-lg">
                            <img 
                                src="{{ asset('storage/' . $singleSeries->image_path) }}" 
                                alt="{{ $singleSeries->title }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <h3 class="text-center mt-2 font-bold text-white">{{ $singleSeries->title }}</h3>
                        <p class="text-center text-gray-400">{{ $singleSeries->seasons_count }} sezona</p>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app>