<x-app>
    <div class="max-w-6xl mx-auto px-4 py-10 text-white">

        {{-- Flash poruke --}}
        @if(session('success'))
            <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Glavna kartica --}}
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 grid md:grid-cols-3 gap-10">

            {{-- Poster --}}
            <div class="md:col-span-1">
                <img 
                    src="{{ asset('storage/' . $series->image_path) }}" 
                    alt="{{ $series->title }}" 
                    class="w-full h-auto rounded-xl shadow-lg"
                >
            </div>

            {{-- Detalji --}}
            <div class="md:col-span-2 flex flex-col space-y-6">

                {{-- Naslov --}}
                <h1 class="text-4xl font-extrabold text-blue-400">{{ $series->title }}</h1>

                {{-- Osnovni podaci --}}
                <div class="grid grid-cols-2 gap-y-3 gap-x-6 text-gray-300">
                    <p><i class="fas fa-calendar-alt text-blue-400 mr-2"></i><span class="font-semibold">Datum izlaska:</span> {{ $series->release_date }}</p>
                    <p><i class="fas fa-film text-blue-400 mr-2"></i><span class="font-semibold">Žanr:</span> {{ $series->genre }}</p>
                    <p><i class="fas fa-coins text-yellow-400 mr-2"></i><span class="font-semibold">Cena:</span> {{ $series->price }} RSD</p>
                    <p><i class="fas fa-ticket-alt text-blue-400 mr-2"></i><span class="font-semibold">Pretplata:</span> {{ $series->is_subscription_required ? 'Da' : 'Ne' }}</p>
                </div>

                {{-- Opis --}}
                <div>
                    <h2 class="text-xl font-semibold mb-2 text-white"><i class="fas fa-align-left text-blue-400 mr-2"></i>Opis</h2>
                    <p class="text-gray-300 leading-relaxed">{{ $series->description }}</p>
                </div>

                {{-- Ocene --}}
                <div>
                    <h2 class="text-xl font-semibold mb-3 text-white"><i class="fas fa-star text-yellow-400 mr-2"></i>Ocene</h2>
                    <p class="mb-3 text-gray-300">
                        Prosečna ocena: <span class="font-bold text-yellow-400">{{ number_format($series->averageRating(), 1) }}/5</span> 
                        ({{ $series->ratingsCount() }} korisnika)
                    </p>

                    @if(Auth::check())
                        <form action="{{ route('series.rate', $series->SeriesID) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <label for="rating" class="text-gray-300 font-medium"><i class="fas fa-pen mr-2"></i>Ocenite:</label>
                            <select name="rating" id="rating" class="text-white px-2 py-1 rounded hover:cursor-pointer">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ★</option>
                                @endfor
                            </select>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg text-black font-semibold transition flex items-center hover:cursor-pointer">
                                <i class="fas fa-star mr-2"></i> Oceni
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sezone --}}
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 mt-10" x-data="{ activeSeason: 0 }">
            
            {{-- Tabovi sezona --}}
            <div class="mb-6 border-b border-gray-700">
                <div class="flex flex-wrap">
                    @foreach($series->seasons as $index => $season)
                        <button 
                            @click="activeSeason = {{ $index }}"
                            :class="activeSeason === {{ $index }} 
                                ? 'border-b-2 border-blue-500 text-blue-400' 
                                : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 text-lg font-medium transition">
                            <i class="fas fa-layer-group mr-2"></i> Sezona {{ $season->season_number }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Epizode --}}
            @foreach($series->seasons as $index => $season)
                <div x-show="activeSeason === {{ $index }}" class="space-y-6">
                    <h3 class="text-2xl font-bold text-blue-400">
                        {{ $season->title ?: 'Sezona ' . $season->season_number }}
                        <span class="text-gray-400">({{ $season->release_year }})</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($season->episodes as $episode)
                            <div class="bg-gray-800/70 rounded-xl p-4 shadow hover:bg-gray-700/80 transition">
                                @if($episode->image_path)
                                    <img 
                                        src="{{ asset('storage/' . $episode->image_path) }}" 
                                        alt="{{ $episode->title }}" 
                                        class="w-full h-48 object-cover rounded-lg mb-4"
                                    >
                                @endif
                                <p class="font-semibold text-lg text-white">
                                    <i class="fas fa-play-circle text-blue-400 mr-2"></i> Epizoda {{ $episode->episode_number }}: {{ $episode->title }}
                                </p>
                                <div class="text-sm text-gray-400 mt-1">
                                    <p><i class="far fa-clock mr-1"></i>{{ $episode->duration }} min</p>
                                    <p><i class="far fa-calendar-alt mr-1"></i>{{ $episode->air_date }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Dugmad dole --}}
        <div class="mt-10 flex gap-4">
            <a href="{{ route('tvshows.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition flex items-center">
               <i class="fas fa-arrow-left mr-2"></i> Nazad na listu serija
            </a>

            <form action="{{ route('purchase.series', $series->SeriesID) }}" method="POST">
                @csrf
                <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition flex items-center hover:cursor-pointer">
                    <i class="fas fa-shopping-cart mr-2"></i> Kupi celu seriju za {{ $series->price }} RSD
                </button>
            </form>
        </div>
    </div>
</x-app>

