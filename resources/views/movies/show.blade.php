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
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="md:w-1/3">
                    <img 
                    src="{{ asset('storage/' . $film->image_path) }}" 
                    alt="{{ $film->Title }}" 
                    class="w-full h-auto rounded-lg shadow-lg"
                    >
                </div>
                <div class="md:w-2/3 text-white">
                    <h1 class="text-4xl font-bold mb-4">{{ $film->Title }}</h1>
                    <div class="space-y-4">
                        <p><span class="font-semibold">Datum izlaska:</span> {{ $film->ReleaseDate }}</p>
                        <p><span class="font-semibold">Trajanje:</span> {{ floor($film->Duration / 60) }}h {{ $film->Duration % 60 }} minuta</p>
                        <p><span class="font-semibold">Cena:</span> {{ $film->Price }} RSD</p>
                        <p><span class="font-semibold">Žanr:</span> {{ $film->Genre }}</p>
                        <p><span class="font-semibold">Opis:</span> {{ $film->Description }}</p>
                        <p><span class="font-semibold">Zahteva pretplatu:</span> 
                            {{ $film->IsSubscriptionRequired ? 'Da' : 'Ne' }}
                        </p>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('movies.index') }}" 
                        class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                        Nazad na listu filmova
                    </a>
                    
                    <form action="{{ route('purchase.store', $film->FilmID) }}" method="POST">
                        @csrf
                        <button type="submit" 
                        class="bg-green-500 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition hover:cursor-pointer">
                        Kupi za {{ $film->Price }} RSD
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</x-app>    