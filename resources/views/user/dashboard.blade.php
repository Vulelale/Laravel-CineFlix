<x-app>
    <div class="min-h-screen bg-gradient-to-r from-darkblue-500 to-lightblue-600 p-10" 
         x-data="{
            activeTab: localStorage.getItem('activeTab') || 'profile',
            setTab(tab) {
                this.activeTab = tab;
                localStorage.setItem('activeTab', tab);
            }
         }">

        <div class="max-w-6xl mx-auto space-y-8">

            {{-- Naslov i Tabovi --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                    Moj profil
                </h1>

                <div class="flex rounded-lg bg-gray-800 p-1 shadow-inner">
                    <button 
                        @click="setTab('profile')"
                        :class="activeTab === 'profile' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
                        class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
                        <i class="fas fa-user mr-2"></i> Profil
                    </button>
                    <button 
                        @click="setTab('purchases')"
                        :class="activeTab === 'purchases' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
                        class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
                        <i class="fas fa-shopping-cart mr-2"></i> Kupovine
                    </button>
                    <button 
                        @click="setTab('subscriptions')"
                        :class="activeTab === 'subscriptions' ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200'"
                        class="px-4 py-2 rounded-md font-medium transition hover:cursor-pointer">
                        <i class="fas fa-credit-card mr-2"></i> Pretplate
                    </button>
                </div>
            </div>

            {{-- Profil Tab --}}
            <div x-show="activeTab === 'profile'" 
                 class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user-circle text-blue-400 mr-2"></i> Podaci o profilu
                </h2>

                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->UserID) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Ime</label>
                            <input type="text" name="FirstName" value="{{ old('FirstName', $user->FirstName) }}"
                                   class="w-full bg-gray-800 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Prezime</label>
                            <input type="text" name="LastName" value="{{ old('LastName', $user->LastName) }}"
                                   class="w-full bg-gray-800 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                            <input type="email" name="Email" value="{{ old('Email', $user->Email) }}"
                                   class="w-full bg-gray-800 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Nova lozinka</label>
                            <input type="password" name="password" placeholder="Obavezno ako menjate podatke"
                                   class="w-full bg-gray-800 text-gray-200 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition flex items-center hover:cursor-pointer">
                            <i class="fas fa-save mr-2"></i> Sačuvaj promene
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kupovine Tab --}}
            <div x-show="activeTab === 'purchases'" 
                 class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-shopping-bag text-blue-400 mr-2"></i> Moje kupovine
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Film/Serija</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Iznos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-gray-800">
                            @forelse($purchases as $purchase)
                                <tr class="hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 text-gray-200">
                                        @if($purchase->film)
                                            <i class="fas fa-film text-blue-400 mr-1"></i> {{ $purchase->film->Title }}
                                        @elseif($purchase->series)
                                            <i class="fas fa-tv text-purple-400 mr-1"></i> {{ $purchase->series->title }} (serija)
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
                                                    class="text-red-400 hover:text-red-300 transition hover:cursor-pointer"
                                                    onclick="return confirm('Da li ste sigurni da želite da otkažete ovu kupovinu?')">
                                                <i class="fas fa-times mr-1"></i> Otkaži
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

            {{-- Pretplate Tab --}}
            <div x-show="activeTab === 'subscriptions'" 
                 class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-credit-card text-blue-400 mr-2"></i> Moje pretplate
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Trajanje</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Početak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kraj</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Iznos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Akcije</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-gray-800">
                            @forelse($subscriptions as $subscription)
                                <tr class="hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 text-gray-200">
                                        @php
                                           $meseci = \Carbon\Carbon::parse($subscription->StartDate)->diffInMonths(\Carbon\Carbon::parse($subscription->EndDate));
                                           $tekst = ($meseci == 1) ? 'mesec' : (($meseci == 3) ? 'meseca' : 'meseci');
                                        @endphp
                                        {{$meseci}} {{$tekst}}
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">{{ $subscription->StartDate }}</td>
                                    <td class="px-6 py-4 text-gray-400">{{ $subscription->EndDate }}</td>
                                    <td class="px-6 py-4 text-gray-400">{{ $subscription->Price }} RSD</td>
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
                                                        class="text-red-400 hover:text-red-300 transition hover:cursor-pointer"
                                                        onclick="return confirm('Da li ste sigurni da želite da otkažete ovu pretplatu?')">
                                                    <i class="fas fa-times mr-1"></i> Otkaži
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Trenutno nemate aktivnih pretplata —
                                        <a href="{{ route('subscription.sub') }}" class="text-blue-500 hover:underline hover:cursor-pointer">
                                            Pretplati se
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

