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
                    src="{{ asset('storage/' . $film->image_path) }}" 
                    alt="{{ $film->Title }}" 
                    class="w-full h-auto rounded-xl shadow-lg"
                >
            </div>

            {{-- Detalji --}}
            <div class="md:col-span-2 flex flex-col space-y-6">

                {{-- Naslov --}}
                <h1 class="text-4xl font-extrabold text-blue-400">{{ $film->Title }}</h1>

                {{-- Osnovni podaci --}}
                <div class="grid grid-cols-2 gap-y-3 gap-x-6 text-gray-300">
                    <p><i class="fas fa-calendar-alt text-blue-400 mr-2"></i><span class="font-semibold">Datum izlaska:</span> {{ $film->ReleaseDate }}</p>
                    <p><i class="fas fa-clock text-blue-400 mr-2"></i><span class="font-semibold">Trajanje:</span> {{ floor($film->Duration / 60) }}h {{ $film->Duration % 60 }} min</p>
                    <p><i class="fas fa-coins text-yellow-400 mr-2"></i><span class="font-semibold">Cena:</span> {{ $film->Price }} RSD</p>
                    <p><i class="fas fa-film text-blue-400 mr-2"></i><span class="font-semibold">Žanr:</span> {{ $film->Genre }}</p>
                    <p class="col-span-2"><i class="fas fa-ticket-alt text-blue-400 mr-2"></i><span class="font-semibold">Pretplata:</span> {{ $film->IsSubscriptionRequired ? 'Da' : 'Ne' }}</p>
                </div>

                {{-- Opis --}}
                <div>
                    <h2 class="text-xl font-semibold mb-2 text-white"><i class="fas fa-align-left text-blue-400 mr-2"></i>Opis</h2>
                    <p class="text-gray-300 leading-relaxed">{{ $film->Description }}</p>
                </div>

                {{-- Ocene --}}
                <div>
                    <h2 class="text-xl font-semibold mb-3 text-white"><i class="fas fa-star text-yellow-400 mr-2"></i>Ocene</h2>
                    <p class="mb-3 text-gray-300">
                        Prosečna ocena: <span class="font-bold text-yellow-400">{{ number_format($film->averageRating(), 1) }}/5</span> 
                        ({{ $film->ratingsCount() }} korisnika)
                    </p>

                    @if(Auth::check())
                        <form action="{{ route('movies.rate', $film->FilmID) }}" method="POST" class="flex items-center gap-3">
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

                {{-- Akcije --}}
                <div class="flex gap-4 pt-4 border-t border-gray-700">
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
</x-app>

