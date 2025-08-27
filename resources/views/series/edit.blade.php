<x-app>
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-500 mb-8">
                <i class="fas fa-edit mr-2"></i> Uredi seriju: {{ $series->title }}
            </h1>
            
            {{-- Error poruke --}}
            @if($errors->any())
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg mb-6 flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle mt-1"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('series.update', $series->SeriesID) }}" enctype="multipart/form-data" id="series-form">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    {{-- Naslov --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-heading mr-2 text-purple-400"></i> Naslov
                        </label>
                        <input type="text" name="title" required 
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                               value="{{ old('title', $series->title) }}">
                    </div>
                    
                    {{-- Poster --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-image mr-2 text-blue-400"></i> Poster
                        </label>
                        <input type="file" name="image" 
                               class="w-full file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 cursor-pointer">
                        @if($series->image_path)
                            <div class="mt-2">
                                <span class="text-gray-400">Trenutna slika:</span>
                                <img src="{{ asset('storage/' . $series->image_path) }}" 
                                     class="w-32 h-32 object-cover mt-2 rounded-lg shadow-md ring-2 ring-gray-700">
                            </div>
                        @endif
                    </div>
                    
                    {{-- Žanr & Cena --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-300 mb-2 font-medium">
                                <i class="fas fa-film mr-2 text-yellow-400"></i> Žanr
                            </label>
                            <input type="text" name="genre" 
                                   class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                                   value="{{ old('genre', $series->genre) }}">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2 font-medium">
                                <i class="fas fa-coins mr-2 text-green-400"></i> Cena (RSD)
                            </label>
                            <input type="number" name="price" step="0.01" required 
                                   class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                                   value="{{ old('price', $series->price) }}">
                        </div>
                    </div>
                    
                    {{-- Datum izlaska --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-calendar-alt mr-2 text-pink-400"></i> Datum izlaska
                        </label>
                        <input type="date" name="release_date" required 
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                               value="{{ old('release_date', $series->release_date) }}">
                    </div>
                    
                    {{-- Opis --}}
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-align-left mr-2 text-indigo-400"></i> Opis
                        </label>
                        <textarea name="description" rows="4" 
                                  class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('description', $series->description) }}</textarea>
                    </div>
                    
                    {{-- Pretplata --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="is_subscription_required" id="subscription" 
                               class="h-4 w-4 text-blue-500 rounded focus:ring-blue-500"
                               {{ $series->is_subscription_required ? 'checked' : '' }}>
                        <label for="subscription" class="ml-2 text-gray-300"> Zahteva pretplatu </label>
                    </div>
                </div>
                
                {{-- Sezone --}}
                <div class="mt-10" 
                     x-data="{
                        seasons: @js($series->seasons->map(function($season) {
                            return [
                                'id' => $season->SeasonID,
                                'season_number' => $season->season_number,
                                'title' => $season->title,
                                'release_year' => $season->release_year,
                                'episodes' => $season->episodes->map(function($episode) {
                                    return [
                                        'id' => $episode->EpisodeID,
                                        'episode_number' => $episode->episode_number,
                                        'title' => $episode->title,
                                        'duration' => $episode->duration,
                                        'air_date' => $episode->air_date,
                                        'image_path' => $episode->image_path
                                    ];
                                })->toArray()
                            ];
                        }))
                     }">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-200 flex items-center">
                            <i class="fas fa-layer-group mr-2 text-purple-400"></i> Sezone
                        </h3>
                        <button type="button" @click="seasons.push({ episodes: [] })" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition hover:cursor-pointer">
                            + Dodaj sezonu
                        </button>
                    </div>
                    
                    <template x-for="(season, index) in seasons" :key="index">
                        <div class="bg-gray-800 p-5 rounded-xl mb-6 shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-gray-200 font-semibold">Sezona <span x-text="index + 1"></span></h4>
                                <button type="button" @click="seasons.splice(index, 1)" 
                                        class="text-red-400 hover:text-red-300 hover:cursor-pointer">
                                    <i class="fas fa-trash mr-1"></i> Ukloni
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <input type="hidden" x-bind:name="`seasons[${index}][id]`" x-model="season.id">
                                
                                <input type="number" x-bind:name="`seasons[${index}][season_number]`" 
                                       placeholder="Broj sezone" required 
                                       class="w-full bg-gray-700 text-white rounded-lg p-2"
                                       x-model="season.season_number">
                                
                                <input type="text" x-bind:name="`seasons[${index}][title]`" 
                                       placeholder="Naslov sezone" 
                                       class="w-full bg-gray-700 text-white rounded-lg p-2"
                                       x-model="season.title">
                                
                                <input type="text" x-bind:name="`seasons[${index}][release_year]`" 
                                       placeholder="Godina izlaska (YYYY)" 
                                       class="w-full bg-gray-700 text-white rounded-lg p-2"
                                       x-model="season.release_year">
                                
                                {{-- Epizode --}}
                                <div class="mt-6 ml-4 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <h5 class="text-gray-300 font-medium">Epizode</h5>
                                        <button type="button" 
                                                @click="season.episodes.push({})" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded hover:cursor-pointer">
                                            + Epizoda
                                        </button>
                                    </div>
                                    
                                    <template x-for="(episode, epIndex) in season.episodes" :key="epIndex">
                                        <div class="bg-gray-700 p-4 rounded-lg space-y-2">
                                            <div class="flex justify-between mb-2">
                                                <span class="text-gray-300 font-medium">Epizoda <span x-text="epIndex + 1"></span></span>
                                                <button type="button" @click="season.episodes.splice(epIndex, 1)" 
                                                        class="text-red-400 hover:text-red-300 hover:cursor-pointer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <input type="hidden" x-bind:name="`seasons[${index}][episodes][${epIndex}][id]`" x-model="episode.id">
                                            
                                            <input type="number" 
                                                   x-bind:name="`seasons[${index}][episodes][${epIndex}][episode_number]`" 
                                                   placeholder="Broj epizode" required 
                                                   class="w-full bg-gray-600 text-white rounded-lg p-2"
                                                   x-model="episode.episode_number">
                                            
                                            <input type="text" 
                                                   x-bind:name="`seasons[${index}][episodes][${epIndex}][title]`" 
                                                   placeholder="Naslov epizode" 
                                                   class="w-full bg-gray-600 text-white rounded-lg p-2"
                                                   x-model="episode.title">
                                            
                                            <input type="number" 
                                                   x-bind:name="`seasons[${index}][episodes][${epIndex}][duration]`" 
                                                   placeholder="Trajanje (minuta)" 
                                                   class="w-full bg-gray-600 text-white rounded-lg p-2"
                                                   x-model="episode.duration">
                                            
                                            <input type="date" 
                                                   x-bind:name="`seasons[${index}][episodes][${epIndex}][air_date]`" 
                                                   class="w-full bg-gray-600 text-white rounded-lg p-2"
                                                   x-model="episode.air_date">
                                           
                                            <input type="file" 
                                                   x-bind:name="`seasons[${index}][episodes][${epIndex}][image]`" 
                                                   class="w-full bg-gray-600 text-white rounded-lg p-2 cursor-pointer">
                                            
                                            {{-- Preview trenutne slike --}}
                                            <template x-if="episode.image_path">
                                                <div class="mt-2">
                                                    <span class="text-gray-400">Trenutna slika:</span>
                                                    <img :src="`/storage/${episode.image_path}`" 
                                                         class="w-32 h-32 object-cover mt-2 rounded-lg shadow-md ring-2 ring-gray-700">
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                {{-- Dugmad --}}
                <div class="mt-8 flex gap-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition hover:cursor-pointer flex items-center">
                        <i class="fas fa-save mr-2"></i> Sačuvaj izmene
                    </button>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow transition hover:cursor-pointer flex items-center">
                        <i class="fas fa-times mr-2"></i> Otkaži
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app>
