<x-app>
    {{-- Success poruka --}}
    @if(session('success'))
        <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg flex items-center gap-2 max-w-2xl mx-auto mt-6">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error poruke --}}
    @if($errors->any())
        <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg flex items-start gap-3 max-w-2xl mx-auto mt-6">
            <i class="fas fa-exclamation-triangle mt-1"></i>
            <div>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="flex flex-col min-h-screen bg-gradient-to-r from-darkblue-500 to-lightblue-600">
        <div class="flex-grow flex items-center justify-center px-4 py-12">
            <div class="max-w-md w-full">
                <div class="bg-gray-900/80 backdrop-blur-md rounded-2xl shadow-2xl p-8 sm:p-12 relative z-10">
                    
                    <form method="POST" action="{{ route('subscription.store') }}" class="space-y-8">
                        @csrf
                        
                        {{-- Naslov --}}
                        <div class="text-center">
                            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                <i class="fas fa-credit-card mr-3"></i> Aktivirajte pretplatu
                            </h1>
                            <p class="text-gray-400 mt-2 text-sm">Odaberite plan koji vam najviše odgovara</p>
                        </div>

                        {{-- Odabir trajanja --}}
                        <div>
                            <label class="block text-gray-300 text-lg mb-3">
                                <i class="fas fa-clock text-blue-400 mr-2"></i> Period trajanja:
                            </label>
                            <select name="duration_months" required
                                    class="w-full bg-gray-800 text-white rounded-lg px-5 py-3 border border-gray-700 focus:ring-2 focus:ring-blue-500 outline-none text-center transition-all">
                                <option value="">-- Odaberite --</option>
                                <option value="1">1 mesec — 499 RSD</option>
                                <option value="3">3 meseca — 1.497 RSD</option>
                                <option value="6">6 meseci — 2.994 RSD</option>
                                <option value="12">12 meseci — 5.988 RSD</option>
                            </select>
                        </div>

                        {{-- Terms --}}
                        <div class="flex items-center justify-center">
                            <input type="checkbox" name="terms" id="terms" required
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 hover:cursor-pointer">
                            <label for="terms" class="ml-2 text-gray-300 text-sm">
                                Prihvatam <a href="#" class="text-blue-400 hover:underline">uslove korišćenja</a>
                            </label>
                        </div>

                        {{-- Submit dugme --}}
                        <div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition transform hover:scale-105 hover:cursor-pointer flex items-center justify-center gap-2 shadow-lg">
                                <i class="fas fa-check"></i> Potvrdi pretplatu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
