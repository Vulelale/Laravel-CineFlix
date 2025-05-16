<x-app>
    <div class="min-h-screen bg-gradient-to-r from-darkblue-500 to-lightblue-600 p-8" x-data="{
        activeTab: localStorage.getItem('activeTab') || 'profile',
        setTab(tab) {
            this.activeTab = tab;
            localStorage.setItem('activeTab', tab);
        }
    }">
    <div class="max-w-7xl mx-auto space-y-8">
       
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                Moj Profil
            </h1>
            
            {{-- Tabovi --}}
            <div class="flex rounded-lg bg-gray-800 p-1">
                <button 
                @click="setTab('profile')"
                :class="activeTab === 'profile' ? 'bg-gray-700 text-white' : 'text-gray-400'"
                class="px-4 py-2 rounded-md focus:outline-none transition-colors"
                >
                Profil
            </button>
            <button 
            @click="setTab('purchases')"
            :class="activeTab === 'purchases' ? 'bg-gray-700 text-white' : 'text-gray-400'"
            class="px-4 py-2 rounded-md focus:outline-none transition-colors"
            >
            Kupovine
        </button>
        <button 
        @click="setTab('subscriptions')"
        :class="activeTab === 'subscriptions' ? 'bg-gray-700 text-white' : 'text-gray-400'"
        class="px-4 py-2 rounded-md focus:outline-none transition-colors"
        >
        Pretplate
    </button>
</div>
</div>

{{-- Profil tab --}}
<div x-show="activeTab === 'profile'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-200">Мoj profil</h2>
    
    
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
    
    @if(session('error'))
    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-auto max-w-7xl mb-4">
        {{ session('error') }}
    </div>
    @endif
    
    <form method="POST" action="{{ route('users.update', $user->UserID) }}">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
           
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Ime</label>
                <input type="text" name="FirstName" 
                value="{{ old('FirstName', $user->FirstName) }}"
                class="w-full bg-gray-700 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Prezime</label>
                <input type="text" name="LastName" 
                value="{{ old('LastName', $user->LastName) }}"
                class="w-full bg-gray-700 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                <input type="email" name="Email" 
                value="{{ old('Email', $user->Email) }}"
                class="w-full bg-gray-700 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Nova lozinka</label>
                <input type="password" name="password" 
                placeholder="Obavezan unos šifre ako se menjaju drugi podaci"
                class="w-full bg-gray-700 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
        
        
        <div class="mt-6">
            <button type="submit" 
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 hover:cursor-pointer">
            Sačuvaj promene
        </button>
    </div>
</form>
</div>

{{-- Kupovine tab --}}
<div x-show="activeTab === 'purchases'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-200">Moje kupovine</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Film</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Datum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Iznos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($purchases as $purchase)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-6 py-4 text-gray-200">
                        @if($purchase->film)
                            {{ $purchase->film->Title }}
                        @elseif($purchase->series)
                            {{ $purchase->series->title }}
                            (SERIJA)    
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $purchase->PurchaseDate->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $purchase->Amount }} RSD</td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-200">
                            Završeno
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('purchases.cancel', $purchase) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                            class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                            onclick="return confirm('Da li ste sigurni da želite da otkažete ovu kupovinu?')">
                            Otkaži
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    Nema kupovina
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $purchases->links('pagination.page') }}
    </div>
</div>


</div>
<div x-show="activeTab === 'subscriptions'" class="bg-gray-800 rounded-lg shadow-xl p-6">
    <h2 class="text-xl font-semibold mb-6 text-gray-200">Moje pretplate</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Trajanje</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Početak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kraj</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Iznos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($subscriptions as $subscription)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-6 py-4 text-gray-200">
                        @php
                           $meseci = \Carbon\Carbon::parse($subscription->StartDate)->diffInMonths(\Carbon\Carbon::parse($subscription->EndDate));
                           $tekst = ($meseci == 1) ? 'mesec' : (($meseci == 3) ? 'meseca' : 'meseci');
                        @endphp
                        {{$meseci}} {{$tekst}}
                    </td>
                    
                    <td class="px-6 py-4 text-gray-400">
                        {{ $subscription->StartDate}}
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        {{ $subscription->EndDate}}
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        {{ $subscription->Price }} RSD
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $subscription->Status === 'Active' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                        {{ $subscription->Status === 'Active' ? 'Aktivna' : 'Istekla' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($subscription->Status === 'Active')
                    <form action="{{ route('subscription.cancel', $subscription) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                        class="text-red-400 hover:text-red-300 hover:cursor-pointer"
                        onclick="return confirm('Da li ste sigurni da želite da otkažete ovu pretplatu?')">
                        Otkaži
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                Trenutno nemate aktivnih pretplata
                <a href="{{ route('subscription.sub') }}" class="text-blue-500 hover:underline">
                    - Pretplati se 
                </a>
            </td>
            
           
        </tr>   
        @endforelse
    </tbody>
</table>
</div>
</div>
</div>
</div>
</x-app>