<x-app>
    <div class="min-h-screen bg-gradient-to-r from-darkblue-500 to-lightblue-600  p-10"
    x-data="{
            activeTab: localStorage.getItem('adminTab') || 'films',
            setTab(tab) {
                this.activeTab = tab;
                localStorage.setItem('adminTab', tab);
            }
         }">
    
    <div class="max-w-6xl mx-auto space-y-8">
        
        {{-- Naslov + Tabovi + Akcije --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                Admin Dashboard
            </h1>
            
            <div class="flex flex-wrap gap-3 items-center">
                
                {{-- Tabovi --}}
                <div class="flex rounded-lg bg-gray-800 p-1 shadow-inner">
                    <button 
                    @click="setTab('films')"
                    :class="activeTab === 'films' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
                    class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
                    <i class="fas fa-film mr-2"></i> Filmovi
                </button>
                <button 
                @click="setTab('series')"
                :class="activeTab === 'series' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
                class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
                <i class="fas fa-tv mr-2"></i> Serije
            </button>
            <button 
            @click="setTab('users')"
            :class="activeTab === 'users' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
            class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
            <i class="fas fa-users mr-2"></i> Korisnici
        </button>
    </div>
    
    {{-- Akcije --}}
    <a href="{{ route('films.create') }}" 
    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition hover:cursor-pointer flex items-center">
    <i class="fas fa-plus mr-2"></i> Novi Film
</a>
<a href="{{ route('series.create') }}" 
class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition hover:cursor-pointer flex items-center">
<i class="fas fa-plus mr-2"></i> Nova Serija
</a>
</div>
</div>

{{-- Filmovi --}}
<div x-show="activeTab === 'films'" 
class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
<h2 class="text-xl font-semibold text-white flex items-center">
    <i class="fas fa-film text-blue-400 mr-2"></i> Svi filmovi
</h2>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Naslov</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Cena</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Pretplata</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-800">
            @foreach($films as $film)
            <tr class="hover:bg-gray-800 transition">
                <td class="px-6 py-4 text-gray-200">{{ $film->Title }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $film->Price }} RSD</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $film->IsSubscriptionRequired ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                    {{ $film->IsSubscriptionRequired ? 'Da' : 'Ne' }}
                </span>
            </td>
            <td class="px-6 py-4 space-x-3">
                <a href="{{ route('films.edit', $film->FilmID) }}" 
                    class="text-blue-400 hover:text-blue-300 hover:cursor-pointer">
                    <i class="fas fa-edit mr-1"></i> Izmeni
                </a>
                <form action="{{ route('films.destroy', $film->FilmID) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" 
                    class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                    onclick="return confirm('Da li ste sigurni da želite obrisati film?')">
                    <i class="fas fa-trash mr-1"></i> Obriši
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

{{-- Serije --}}
<div x-show="activeTab === 'series'" 
class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
<h2 class="text-xl font-semibold text-white flex items-center">
    <i class="fas fa-tv text-purple-400 mr-2"></i> Sve serije
</h2>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Naslov</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Cena</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Pretplata</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-800">
            @foreach($series as $ser)
            <tr class="hover:bg-gray-800 transition">
                <td class="px-6 py-4 text-gray-200">{{ $ser->title }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $ser->price }} RSD</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $ser->is_subscription_required ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                    {{ $ser->is_subscription_required ? 'Da' : 'Ne' }}
                </span>
            </td>
            <td class="px-6 py-4 space-x-3">
                <a href="{{ route('series.edit', $ser->SeriesID) }}" 
                    class="text-blue-400 hover:text-blue-300 hover:cursor-pointer">
                    <i class="fas fa-edit mr-1"></i> Izmeni
                </a>
                <form action="{{ route('series.destroy', $ser->SeriesID) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" 
                    class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                    onclick="return confirm('Obrisati seriju?')">
                    <i class="fas fa-trash mr-1"></i> Obriši
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
</div>

<div class="mt-4">
    {{ $series->links('pagination.page') }}
</div>

</div>

{{-- Korisnici --}}
<div x-show="activeTab === 'users'" 
class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
<h2 class="text-xl font-semibold text-white flex items-center">
    <i class="fas fa-users text-blue-400 mr-2"></i> Svi korisnici
</h2>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Ime i prezime</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kupovine</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Pretplata</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-800">
            @forelse($users as $user)
            <tr class="hover:bg-gray-800 transition">
                <td class="px-6 py-4 text-gray-400">#{{ $user->UserID }}</td>
                <td class="px-6 py-4 text-gray-200">{{ $user->FirstName }} {{ $user->LastName }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $user->Email }}</td>
                <td class="px-6 py-4">
                    <span class="bg-blue-900 text-blue-200 px-2 py-1 rounded-full text-xs">
                        {{ $user->purchases->count() }} kupovina
                    </span>
                </td>
                <td class="px-6 py-4">
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
