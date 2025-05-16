<x-app>
    <div
        style="animation: slideInFromLeft 1s ease-out;"
        class="mx-auto max-w-2xl w-full bg-gray-800 rounded-xl shadow-2xl overflow-hidden p-8 space-y-8"
    >
        <h2
            style="animation: appear 2s ease-out;"
            class="text-center text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500"
        >
            Dodaj novi film
        </h2>
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif  
        
        <form method="POST" action="{{ route('films.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            
            <div class="relative">
                <input
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    required
                    id="Title"
                    name="Title"
                    type="text"
                    placeholder=" "
                    value="{{ old('Title') }}"
                />
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="Title"
                >Naslov filma</label>
            </div>

           
            <div class="relative pt-4 ">
                <label class="text-gray-300 text-sm">Poster filma</label>
                <input
                    class="mt-1 block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600"
                    type="file"
                    name="image"
                    id="image"
                    required
                />
            </div>

            
            <div class="relative">
                <input
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    id="ReleaseDate"
                    name="ReleaseDate"
                    type="date"
                    placeholder=" "
                    value="{{ old('ReleaseDate') }}"
                />
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="ReleaseDate"
                >Datum izlaska</label>
            </div>

            <div class="relative">
                <input
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    id="Genre"
                    name="Genre"
                    type="text"
                    placeholder=" "
                    maxlength="50"
                    value="{{ old('Genre') }}"
                />
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="ReleaseDate"
                >Žanr</label>
            </div>

            <div class="relative">
                <textarea
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    id="Description"
                    name="Description"
                    type="text"
                    placeholder=" "
                    maxlength="2000"
                    value="{{ old('Description') }}"
                ></textarea>
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="ReleaseDate"
                >Opis</label>
            </div>

           
            <div class="relative">
                <input
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    id="Duration"
                    name="Duration"
                    type="number"
                    placeholder=" "
                    value="{{ old('Duration') }}"
                />
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="Duration"
                >Trajanje (minuta)</label>
            </div>

           
            <div class="relative">
                <input
                    class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
                    id="Price"
                    name="Price"
                    type="number"
                    step="0.01"
                    placeholder=" "
                    required
                    value="{{ old('Price') }}"
                />
                <label
                    class="absolute left-0 -top-3.5 text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-300 peer-focus:text-sm"
                    for="Price"
                >Cena (RSD)</label>
            </div>

           
            <div class="flex items-center mt-6">
                <input
                    id="IsSubscriptionRequired"
                    name="IsSubscriptionRequired"
                    type="checkbox"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                />
                <label for="IsSubscriptionRequired" class="ml-2 block text-sm text-gray-300">
                    Zahteva pretplatu
                </label>
            </div>

            <div class="space-y-4">
                <button
                    class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-700 rounded-md shadow-lg text-white font-semibold transition duration-200 hover:cursor-pointer"
                    type="submit"
                >
                    Sačuvaj film
                </button>
                <a href="{{ route('admin.dashboard') }}" class="block w-full py-2 px-4 bg-rose-500 hover:bg-rose-700 rounded-md shadow-lg text-white font-semibold text-center transition duration-200">
                    Odustani
                </a>
            </div>
        </form>
    </div>

    <style>
        @keyframes slideInFromLeft {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes appear {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>   
</x-app>