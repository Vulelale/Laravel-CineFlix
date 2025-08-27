<x-app>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-8">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 flex items-center">
                <i class="fas fa-film mr-2"></i> Dodaj novi film
            </h2>
            
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
            
            <form method="POST" action="{{ route('films.store') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf

                {{-- Naslov --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-heading mr-2 text-purple-400"></i> Naslov filma
                    </label>
                    <input type="text" name="Title" required
                           value="{{ old('Title') }}"
                           class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- Poster --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-image mr-2 text-blue-400"></i> Poster filma
                    </label>
                    <input type="file" name="image" required
                           class="w-full file:bg-blue-600 file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 cursor-pointer">
                </div>

                {{-- Datum izlaska & Žanr --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-calendar-alt mr-2 text-pink-400"></i> Datum izlaska
                        </label>
                        <input type="date" name="ReleaseDate"
                               value="{{ old('ReleaseDate') }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-tags mr-2 text-yellow-400"></i> Žanr
                        </label>
                        <input type="text" name="Genre" maxlength="50"
                               value="{{ old('Genre') }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                {{-- Opis --}}
                <div>
                    <label class="block text-gray-300 mb-2 font-medium">
                        <i class="fas fa-align-left mr-2 text-indigo-400"></i> Opis
                    </label>
                    <textarea name="Description" rows="4" maxlength="2000"
                              class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('Description') }}</textarea>
                </div>

                {{-- Trajanje & Cena --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-clock mr-2 text-green-400"></i> Trajanje (minuta)
                        </label>
                        <input type="number" name="Duration"
                               value="{{ old('Duration') }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2 font-medium">
                            <i class="fas fa-coins mr-2 text-yellow-400"></i> Cena (RSD)
                        </label>
                        <input type="number" name="Price" step="0.01" required
                               value="{{ old('Price') }}"
                               class="w-full bg-gray-800 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                {{-- Pretplata --}}
                <div class="flex items-center">
                    <input type="checkbox" name="IsSubscriptionRequired" id="IsSubscriptionRequired"
                           class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                    <label for="IsSubscriptionRequired" class="ml-2 text-gray-300"> Zahteva pretplatu </label>
                </div>

                {{-- Dugmad --}}
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition hover:cursor-pointer flex items-center">
                        <i class="fas fa-save mr-2"></i> Sačuvaj film
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
