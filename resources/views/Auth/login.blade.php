<x-app>
    @section('title', 'CineFlix-Log In')
    
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

    <div
    style="animation: slideInFromLeft 1s ease-out;"
    class="mx-auto max-w-md w-full bg-gradient-to-r from-blue-800 to-lightblue-600 rounded-xl shadow-2xl overflow-hidden p-8 space-y-8"
    >
    <h2
    style="animation: appear 2s ease-out;"
    class="text-center text-4xl font-extrabold text-white"
    >
    Dobrodošli
</h2>
<p style="animation: appear 3s ease-out;" class="text-center text-gray-200">
   Uloguj se na svoj nalog
</p>
<form method="POST" action="/login" class="space-y-6">
    @csrf
    
    <div class="relative">
        <input
        placeholder="john@example.com"
        class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
        required=""
        id="Email"
        name="Email"
        type="email"
        value="{{ old('Email') }}"
        />
        <label
        class="absolute left-0 -top-3.5 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-500 peer-focus:text-sm"
        for="Email"
        >Email adresa</label
        >
    </div>
    <div class="relative">
        <input
        placeholder="Password"
        class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
        required=""
        id="password"
        name="password"
        type="password"
        />
        <label
        class="absolute left-0 -top-3.5 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-500 peer-focus:text-sm"
        for="password"
        >Šifra</label
        >
    </div>
    
    <button
    class="w-full py-2 px-4 bg-blue-500 hover:bg-purple-700 rounded-md shadow-lg text-white font-semibold transition duration-200 hover:cursor-pointer"
    type="submit"
    >
   Uloguj se
</button>
</form>
<div class="text-center text-gray-300">
    Nemaš nalog?
    <a class="text-purple-300 hover:underline" href="/register">Registruj se</a>
  </div>
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