<x-app>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-gray-800 rounded-xl shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-500 mb-6">
                Uredi Seriju: {{ $series->title }}
            </h1>
            
            @if($errors->any())
            <div class="bg-red-900 text-red-200 p-4 rounded-lg mb-6">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            <form method="POST" action="{{ route('series.update', $series->SeriesID) }}" enctype="multipart/form-data" id="series-form">
                @csrf
                @method('PUT')
                
               
                <div class="space-y-6">
                   
                    <div>
                        <label class="block text-gray-300 mb-2">Naslov</label>
                        <input type="text" name="title" required 
                        class="w-full bg-gray-700 text-white rounded-lg p-3"
                        value="{{ old('title', $series->title) }}">
                    </div>
                    
                    
                    <div>
                        <label class="block text-gray-300 mb-2">Poster</label>
                        <input type="file" name="image" 
                        class="w-full file:bg-blue-500 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2">
                        @if($series->image_path)
                        <div class="mt-2">
                            <span class="text-gray-400">Trenutna slika:</span>
                            <img src="{{ asset('storage/' . $series->image_path) }}" 
                            class="w-32 h-32 object-cover mt-2 rounded-lg">
                        </div>
                        @endif
                    </div>
                    
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-300 mb-2">Žanr</label>
                            <input type="text" name="genre" 
                            class="w-full bg-gray-700 text-white rounded-lg p-3"
                            value="{{ old('genre', $series->genre) }}">
                        </div>
                        <div>
                            <label class="block text-gray-300 mb-2">Cena (RSD)</label>
                            <input type="number" name="price" step="0.01" required 
                            class="w-full bg-gray-700 text-white rounded-lg p-3"
                            value="{{ old('price', $series->price) }}">
                        </div>
                    </div>
                    
                   
                    <div>
                        <label class="block text-gray-300 mb-2">Datum izlaska</label>
                        <input type="date" name="release_date" required 
                        class="w-full bg-gray-700 text-white rounded-lg p-3"
                        value="{{ old('release_date', $series->release_date) }}">
                    </div>
                    
                   
                    <div>
                        <label class="block text-gray-300 mb-2">Opis</label>
                        <textarea name="description" rows="4" 
                        class="w-full bg-gray-700 text-white rounded-lg p-3">{{ old('description', $series->description) }}</textarea>
                    </div>
                    
                  
                    <div class="flex items-center">
                        <input type="checkbox" name="is_subscription_required" id="subscription" 
                        class="h-4 w-4 text-blue-500 rounded"
                        {{ $series->is_subscription_required ? 'checked' : '' }}>
                        <label for="subscription" class="ml-2 text-gray-300">
                            Zahtev za pretplatu
                        </label>
                    </div>
                </div>
                
                
                <div class="mt-8" x-data="{
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
                    <h3 class="text-xl text-gray-300">Sezone</h3>
                    <button type="button" @click="seasons.push({ episodes: [] })" 
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:cursor-pointer">
                    + Dodaj sezonu
                </button>
            </div>
            
           
            <template x-for="(season, index) in seasons" :key="index">
                <div class="bg-gray-700 p-4 rounded-lg mb-4">
                    <div class="flex justify-between mb-4">
                        <h4 class="text-gray-300">Sezona <span x-text="index + 1"></span></h4>
                        <button type="button" @click="seasons.splice(index, 1)" 
                        class="text-red-400 hover:text-red-300 hover:cursor-pointer">
                        Ukloni
                    </button>
                </div>
                
                <div class="space-y-4">
                    <input type="hidden" x-bind:name="`seasons[${index}][id]`" x-model="season.id">
                    
                    <input type="number" x-bind:name="`seasons[${index}][season_number]`" 
                    placeholder="Broj sezone" required 
                    class="w-full bg-gray-600 text-white rounded-lg p-2"
                    x-model="season.season_number">
                    
                    <input type="text" x-bind:name="`seasons[${index}][title]`" 
                    placeholder="Naslov sezone" 
                    class="w-full bg-gray-600 text-white rounded-lg p-2"
                    x-model="season.title">
                    
                    <input type="text" x-bind:name="`seasons[${index}][release_year]`" 
                    placeholder="Godina izlaska(YYYY)" 
                    class="w-full bg-gray-600 text-white rounded-lg p-2"
                    x-model="season.release_year">
                    
                    
                    <div class="ml-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <h5 class="text-gray-400">Epizoda</h5>
                            <button type="button" 
                            @click="season.episodes.push({})" 
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:cursor-pointer">
                            + Epizoda
                        </button>
                    </div>
                    
                    <template x-for="(episode, epIndex) in season.episodes" :key="epIndex">
                        <div class="bg-gray-600 p-3 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Epizoda <span x-text="epIndex + 1"></span></span>
                                <button type="button" 
                                @click="season.episodes.splice(epIndex, 1)" 
                                class="text-red-400 hover:text-red-300 hover:cursor-pointer">
                                Ukloni
                            </button>
                        </div>
                        <input type="hidden" x-bind:name="`seasons[${index}][episodes][${epIndex}][id]`" x-model="episode.id">
                        
                        <input type="number" 
                        x-bind:name="`seasons[${index}][episodes][${epIndex}][episode_number]`" 
                        placeholder="Broj epizode" required 
                        class="w-full bg-gray-500 text-white rounded-lg p-2 mb-2"
                        x-model="episode.episode_number">
                        
                        <input type="text" 
                        x-bind:name="`seasons[${index}][episodes][${epIndex}][title]`" 
                        placeholder="Naslov epizode" 
                        class="w-full bg-gray-500 text-white rounded-lg p-2 mb-2"
                        x-model="episode.title">
                        
                        <input type="number" 
                        x-bind:name="`seasons[${index}][episodes][${epIndex}][duration]`" 
                        placeholder="Trajanje (minuta)" 
                        class="w-full bg-gray-500 text-white rounded-lg p-2 mb-2"
                        x-model="episode.duration">
                        
                        <input type="date" 
                        x-bind:name="`seasons[${index}][episodes][${epIndex}][air_date]`" 
                        class="w-full bg-gray-500 text-white rounded-lg p-2"
                        x-model="episode.air_date">
                       
                        <input type="file" 
                        x-bind:name="`seasons[${index}][episodes][${epIndex}][image]`" 
                        class="w-full bg-gray-500 text-white rounded-lg p-2 mb-2 mt-2">
                        
                        
                       
                        <template x-if="episode.image_path">
                            <div class="mt-2">
                                <span class="text-gray-400">Trenutna slika:</span>
                                <img :src="`/storage/${episode.image_path}`" 
                                class="w-32 h-32 object-cover mt-2 rounded-lg">
                            </div>
                        </template>
                        
                        
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
</div>


<div class="mt-8 flex gap-4">
    <button type="submit" 
    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition hover:cursor-pointer">
    Sačuvaj izmene
</button>
<a href="{{ route('admin.dashboard') }}" 
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
Otkaži
</a>
</div>
</form>
</div>
</div>


</x-app>