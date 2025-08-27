<x-app>
    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-8">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 flex items-center">
                <i class="fas fa-edit mr-2"></i> Uredi film: {{ $film->Title }}
            </h1>

            {{-- Error poruke --}}
            @if($errors->any())
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle mt-1"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('films.update', $film->FilmID) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Trenutna slika --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-image mr-2 text-blue-400"></i> Trenutni poster
                    </label>
                    @if($film->image_path)
                        <img src="{{ asset('storage/' . $film->image_path) }}" 
                             alt="{{ $film->Title }}" 
                             class="mt-2 w-48 h-64 object-cover rounded-lg shadow-md ring-2 ring-gray-700">
                    @else
                        <p class="text-gray-500 italic">Nema dostupne slike</p>
                    @endif
                </div>

                {{-- Nova slika --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-upload mr-2 text-green-400"></i> Nova slika
                    </label>
                    <input type="file" name="image"
                           class="w-full file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 cursor-pointer">
                    <p class="mt-1 text-sm text-gray-400">Podržani formati: JPEG, PNG (max 2MB)</p>
                </div>

                {{-- Naslov --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-heading mr-2 text-purple-400"></i> Naslov
                    </label>
                    <input type="text" name="Title" value="{{ old('Title', $film->Title) }}"
                           class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Datum izlaska & Žanr --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-calendar-alt mr-2 text-pink-400"></i> Datum izlaska
                        </label>
                        <input type="date" name="ReleaseDate" value="{{ old('ReleaseDate', $film->ReleaseDate) }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-tags mr-2 text-yellow-400"></i> Žanr
                        </label>
                        <input type="text" name="Genre" value="{{ old('Genre', $film->Genre) }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                {{-- Opis --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-align-left mr-2 text-indigo-400"></i> Opis
                    </label>
                    <textarea name="Description" rows="4"
                              class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('Description', $film->Description) }}</textarea>
                </div>

                {{-- Trajanje & Cena --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-clock mr-2 text-green-400"></i> Trajanje (minuta)
                        </label>
                        <input type="number" name="Duration" value="{{ old('Duration', $film->Duration) }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-coins mr-2 text-yellow-400"></i> Cena (RSD)
                        </label>
                        <input type="number" step="0.01" name="Price" value="{{ old('Price', $film->Price) }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                {{-- Pretplata --}}
                <div class="flex items-center">
                    <input type="checkbox" name="IsSubscriptionRequired" id="subscription"
                           {{ old('IsSubscriptionRequired', $film->IsSubscriptionRequired) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-500 border-gray-600 rounded focus:ring-blue-500 hover:cursor-pointer">
                    <label for="subscription" class="ml-2 text-gray-300"> Zahteva pretplatu </label>
                </div>

                {{-- Dugmad --}}
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition hover:cursor-pointer flex items-center">
                        <i class="fas fa-save mr-2"></i> Sačuvaj izmene
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-3 rounded-lg shadow transition hover:cursor-pointer flex items-center">
                        <i class="fas fa-times mr-2"></i> Odustani
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app>

