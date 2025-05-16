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
    
    <div class="min-h-screen bg-gradient-to-r from-darkblue-500 to-lightblue-600 p-8" x-data="{
        activeTab: localStorage.getItem('activeTab') || 'films',
        setTab(tab) {
            this.activeTab = tab;
            localStorage.setItem('activeTab', tab);
        }
    }"
    >
    <div class="max-w-7xl mx-auto space-y-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                Admin Dashboard
            </h1>
            
            <div class="flex gap-4">
                {{-- Tabovi --}}
                <div class="flex rounded-lg bg-gray-800 p-1">
                    <button 
                    @click="setTab('films')"
                    :class="activeTab === 'films' ? 'bg-gray-700 text-white' : 'text-gray-400'"
                    class="px-4 py-2 rounded-md focus:outline-none transition-colors"
                    >
                    Filmovi
                </button>
                <button 
                @click="setTab('users')"
                :class="activeTab === 'users' ? 'bg-gray-700 text-white' : 'text-gray-400'"
                class="px-4 py-2 rounded-md focus:outline-none transition-colors"
                >
                Korisnici
            </button>
            <button 
            @click="setTab('series')"
            :class="activeTab === 'series' ? 'bg-gray-700 text-white' : 'text-gray-400'"
            class="px-4 py-2 rounded-md focus:outline-none transition-colors"
            >
            Serije
        </button>
    </div>
    
    <a href="{{ route('films.create') }}" 
    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:opacity-80 transition-colors">
    + Novi Film
</a>
<a href="{{ route('series.create') }}" 
   class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:opacity-80 transition-colors">
    + Nova Serija
</a>
</div>
</div>

{{-- Serije --}}
<div x-show="activeTab === 'series'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-200">Sve serije</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Naslov</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cena</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pretplata</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Akcije</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($series as $ser)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-6 py-4 text-gray-200">{{ $ser->title }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $ser->price }} RSD</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $ser->is_subscription_required ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                        {{ $ser->is_subscription_required ? 'Da' : 'Ne' }}
                    </span>
                </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('series.edit', $ser->SeriesID) }}" 
                           class="text-blue-400 hover:text-blue-300">Izmeni</a>
                        <form action="{{ route('series.destroy', $ser->SeriesID) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                                onclick="return confirm('Обрисати серију?')">Obriši</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{--  Filmovi --}}
<div x-show="activeTab === 'films'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-200">Svi filmovi</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Naslov</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cena</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pretplata</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($films as $film)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-200">{{ $film->Title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $film->Price }} RSD</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $film->IsSubscriptionRequired ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                        {{ $film->IsSubscriptionRequired ? 'Da' : 'Ne' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <a href="{{ route('films.edit', $film->FilmID) }}" 
                        class="text-blue-400 hover:text-blue-300">Izmeni</a>
                        <form action="{{ route('films.destroy', $film->FilmID) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                            class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                            onclick="return confirm('Da li ste sigurni?')">
                            Obriši
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $films->links('pagination.page') }}
</div>
</div>

{{-- korisnici --}}
<div x-show="activeTab === 'users'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-200">Svi korisnici</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Ime i prezime</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Kupovine</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pretplata</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">#{{ $user->UserID }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-200">
                        {{ $user->FirstName }} {{ $user->LastName }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $user->Email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-blue-900 text-blue-200 px-2 py-1 rounded-full text-xs">
                            {{ $user->purchases->count() }} kupovina
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                        @if($user->subscriptions->where('Status', 'Active')->where('EndDate', '>', now())->isNotEmpty())
                        <span class="bg-green-900 text-green-200 px-2 py-1 rounded-full text-xs">
                            Aktivna
                        </span>
                        @else
                        <span class="bg-red-900 text-red-200 px-2 py-1 rounded-full text-xs">
                            Nema
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Nema registrovanih korisnika
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links('pagination.page') }}
    </div>
</div>
</div>
</div>

</x-app>