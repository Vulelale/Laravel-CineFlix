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
    <div class="flex flex-col min-h-screenbg-gradient-to-r from-blue-500 to-lightblue-600">
        
        <div class="flex-grow pt-20 pb-12 px-4 sm:px-6 lg:px-8"> 
            <div class="max-w-md mx-auto">
                <div class="bg-gray-800 rounded-2xl shadow-xl p-8 sm:p-12 relative z-10">
                    <form method="POST" action="{{ route('subscription.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="text-center space-y-6">
                            <h1 class="text-3xl font-bold text-blue-400 mb-6">
                                Aktivirajte pretplatu
                            </h1>

                            
                            <div class="mb-8">
                                <label class="block text-gray-300 text-lg mb-4">Odaberite period:</label>
                                <select name="duration_months" 
                                        class="w-full bg-gray-800 text-white rounded-lg px-5 py-3 
                                               border border-gray-600 focus:ring-2 focus:ring-blue-500 
                                               outline-none text-center transition-all"
                                        required>
                                    <option value="">-- Odaberite --</option>
                                    <option value="1">1 mesec (499 RSD)</option>
                                    <option value="3">3 meseca  (1,497 RSD)</option>
                                    <option value="6">6 meseci  (2,994 RSD)</option>
                                    <option value="12">12 meseci  (5,988 RSD)</option>
                                </select>
                            </div>

                           
                            <div class="flex items-center justify-center mb-8">
                                <input type="checkbox" name="terms" id="terms" 
                                       class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                       required>
                                <label for="terms" class="ml-2 text-gray-300 text-sm">
                                    Prihvatam uslove korišćenja
                                </label>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold 
                                           py-3 px-6 rounded-lg transition-all duration-300 shadow-lg 
                                           transform hover:scale-101 hover:cursor-pointer">
                                Potvrdi pretplatu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="mt-auto"></div>
    </div>
</x-app>