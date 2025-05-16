<x-app>
    <div class="max-w-4xl mx-auto py-12 px-4 bg-gray-800 rounded-lg shadow-xl">
        <h1 class="text-2xl font-bold text-gray-200 mb-6">Izmeni film: {{ $film->Title }}</h1>
        
        <form method="POST" action="{{ route('films.update', $film->FilmID) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400">Trenutna slika</label>
                    @if($film->image_path)
                        <img src="{{ asset('storage/' . $film->image_path) }}" 
                             alt="{{ $film->Title }}" 
                             class="mt-2 w-64 h-64 object-cover rounded-lg shadow-md">
                    @else
                        <p class="mt-2 text-gray-500">Nema dostupne slike</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Nova slika</label>
                    <input type="file" name="image" 
                           class="mt-1 block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-700 file:text-white hover:file:bg-blue-600">
                    <p class="mt-1 text-sm text-gray-400">Podržani formati: JPEG, PNG (max 2MB)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Naslov</label>
                    <input type="text" name="Title" value="{{ old('Title', $film->Title) }}"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">
                    @error('Title')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Datum izlaska</label>
                    <input type="date" name="ReleaseDate" 
                           value="{{ old('ReleaseDate', $film->ReleaseDate) }}"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">
                    @error('ReleaseDate')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Žanr</label>
                    <input type="text" name="Genre" 
                           value="{{ old('Genre', $film->Genre) }}"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">
                    @error('Genre')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Opis</label>
                    <textarea type="text" name="Description" 
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">{{ old('Description', $film->Description) }}</textarea>
                    @error('Description')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400">Trajanje Filma</label>
                    <input name="Duration" type="number"
                           value="{{ old('Duration', $film->Duration) }}"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">
                    @error('Duration')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400">Cena (RSD)</label>
                    <input type="number" step="0.01" name="Price" value="{{ old('Price', $film->Price) }}"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500">
                    @error('Price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="IsSubscriptionRequired" id="subscription" 
                           {{ old('IsSubscriptionRequired', $film->IsSubscriptionRequired) ? 'checked' : '' }}
                           class="h-4 w-4 text-purple-500 focus:ring-purple-500 border-gray-600 rounded">
                    <label for="subscription" class="ml-2 block text-sm text-gray-300">
                        Zahteva pretplatu
                    </label>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors hover:cursor-pointer">
                        Sačuvaj izmene
                    </button>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        Odustani
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app>
