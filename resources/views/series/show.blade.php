<x-app>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-auto max-w-7xl mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-auto max-w-7xl mb-4">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif
    <div class="max-w-7xl mx-auto px-4 py-8">
       
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8 mb-8">
            <div class="flex flex-col md:flex-row gap-8">
               
                <div class="md:w-1/3">
                    <img 
                        src="{{ asset('storage/' . $series->image_path) }}" 
                        alt="{{ $series->title }}" 
                        class="w-full h-auto rounded-lg shadow-lg"
                    >
                </div>
                
                
                <div class="md:w-2/3 text-white">
                    <h1 class="text-4xl font-bold mb-4">{{ $series->title }}</h1>
                    <div class="space-y-4">
                        <p><span class="font-semibold">Datum izlaska:</span> {{ $series->release_date }}</p>
                        <p><span class="font-semibold">Žanr:</span> {{ $series->genre }}</p>
                        <p><span class="font-semibold">Cena celokupne serije:</span> {{ $series->price }} RSD</p>
                        <p><span class="font-semibold">Opis:</span> {{ $series->description }}</p>
                        <p><span class="font-semibold">Zahteva pretplatu:</span> 
                            {{ $series->is_subscription_required ? 'Da' : 'Ne' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8" x-data="{ activeSeason: 0 }">
            
            <div class="mb-6 border-b border-gray-600">
                <div class="flex flex-wrap -mb-px">
                    @foreach($series->seasons as $index => $season)
                    <button 
                        @click="activeSeason = {{ $index }}"
                        :class="activeSeason === {{ $index }} 
                            ? 'border-blue-500 text-blue-500' 
                            : 'border-transparent text-gray-400 hover:text-gray-300'"
                        class="inline-block px-6 py-3 border-b-2 font-medium text-lg focus:outline-none transition"
                    >
                        Sezona {{ $season->season_number }}
                    </button>
                    @endforeach
                </div>
            </div>

            
            @foreach($series->seasons as $index => $season)
            <div x-show="activeSeason === {{ $index }}" class="space-y-6">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-2xl text-white font-bold mb-6">
                        {{ $season->title ?: 'Sezona ' . $season->season_number }}
                        <span class="text-gray-400">({{ $season->release_year }})</span>
                    </h3>
                    
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($season->episodes as $episode)
                        <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-500 transition">
                            @if($episode->image_path)
                            <img 
                                src="{{ asset('storage/' . $episode->image_path) }}" 
                                alt="{{ $episode->title }}" 
                                class="w-full h-48 object-cover rounded-lg mb-4"
                            >
                            @endif
                            <div class="space-y-2">
                                <p class="font-semibold text-white text-lg">
                                    Epizoda {{ $episode->episode_number }}: {{ $episode->title }}
                                </p>
                                <div class="text-sm text-gray-300">
                                    <p><i class="far fa-clock mr-2"></i>{{ $episode->duration }} min</p>
                                    <p><i class="far fa-calendar-alt mr-2"></i>{{ $episode->air_date }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            
            <div class="mt-8 flex gap-4">
                <a href="{{ route('tvshows.index') }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
                    Nazad na listu serija
                </a>
                
                
                <form action="{{ route('purchase.series', $series->SeriesID) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition hover:cursor-pointer">
                        Kupi celu seriju za {{ $series->price }} RSD
                    </button>
                </form>
                
            </div>
        </div>
    </div>
</x-app>