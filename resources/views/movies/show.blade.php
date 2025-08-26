<x-app>
    <div class="max-w-7xl mx-auto px-4 py-8 text-white">
        
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

        {{-- Kartica filma --}}
        <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 mb-10">
            <div class="flex flex-col md:flex-row gap-8">

                {{-- Slika --}}
                <div class="md:w-1/3">
                    <img 
                        src="{{ asset('storage/' . $film->image_path) }}" 
                        alt="{{ $film->Title }}" 
                        class="w-full h-auto rounded-xl shadow-lg"
                    >
                </div>

                {{-- Detalji --}}
                <div class="md:w-2/3 space-y-4">
                    <h1 class="text-4xl font-extrabold text-blue-400">{{ $film->Title }}</h1>

                    <p><i class="fas fa-calendar-alt text-blue-400 mr-2"></i><span class="font-semibold">Datum izlaska:</span> {{ $film->ReleaseDate }}</p>
                    <p><i class="fas fa-clock text-blue-400 mr-2"></i><span class="font-semibold">Trajanje:</span> {{ floor($film->Duration / 60) }}h {{ $film->Duration % 60 }} min</p>
                    <p><i class="fas fa-coins text-yellow-400 mr-2"></i><span class="font-semibold">Cena:</span> {{ $film->Price }} RSD</p>
                    <p><i class="fas fa-film text-blue-400 mr-2"></i><span class="font-semibold">Žanr:</span> {{ $film->Genre }}</p>
                    <p><i class="fas fa-align-left text-blue-400 mr-2"></i><span class="font-semibold">Opis:</span> {{ $film->Description }}</p>
                    <p><i class="fas fa-ticket-alt text-blue-400 mr-2"></i><span class="font-semibold">Zahteva pretplatu:</span> {{ $film->IsSubscriptionRequired ? 'Da' : 'Ne' }}</p>

                    {{-- Ocena --}}
                    <p>
                        <i class="fas fa-star text-yellow-400 mr-2"></i>
                        <span class="font-semibold">Prosečna ocena:</span> 
                        {{ number_format($film->averageRating(), 1) }}/5 
                        ({{ $film->ratingsCount() }} korisnika)
                    </p>

                    {{-- Forma za ocenjivanje --}}
                    @if(Auth::check())
                        <form action="{{ route('movies.rate', $film->FilmID) }}" method="POST" class="mt-4 flex items-center gap-3">
                            @csrf
                            <label for="rating" class="text-gray-300 font-medium"><i class="fas fa-pen mr-2"></i>Ocenite:</label>
                            <select name="rating" id="rating" class="text-white px-2 py-1 rounded">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ★</option>
                                @endfor
                            </select>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg text-black font-semibold transition flex items-center hover:cursor-pointer">
                                <i class="fas fa-star mr-2"></i> Oceni
                            </button>
                        </form>
                    @endif

                    {{-- Dugmad --}}
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('movies.index') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition flex items-center">
                           <i class="fas fa-arrow-left mr-2"></i> Nazad na listu filmova
                        </a>

                        <form action="{{ route('purchase.store', $film->FilmID) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition flex items-center hover:cursor-pointer">
                                <i class="fas fa-shopping-cart mr-2"></i> Kupi za {{ $film->Price }} RSD
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app>
