    <div class="max-w-full mx-auto pt-2 " >
        <nav class="border-gray-200 px-2 mb-10 w-full">
            <div class="container mx-auto flex flex-wrap items-center justify-between w-full">
                <div class="flex items-center">
                    <a href="/" class="flex mr-6">
                        <svg class="h-10 mr-3" width="51" height="70" viewBox="0 0 51 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0)">
                                <path d="M1 53H27.9022C40.6587 53 51 42.7025 51 30H24.0978C11.3412 30 1 40.2975 1 53Z" fill="#76A9FA"></path>
                                <path d="M-0.876544 32.1644L-0.876544 66.411C11.9849 66.411 22.4111 55.9847 22.4111 43.1233L22.4111 8.87674C10.1196 8.98051 0.518714 19.5571 -0.876544 32.1644Z" fill="#A4CAFE"></path>
                                <path d="M50 5H23.0978C10.3413 5 0 15.2975 0 28H26.9022C39.6588 28 50 17.7025 50 5Z" fill="#1C64F2"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <rect width="51" height="70" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                        <span class="self-center text-blue-500 font-bold whitespace-nowrap">CineFlix</span>
                    </a>
                    <ul class="flex space-x-6 text-white text-lg font-medium">
                        <li><a href="/" class="hover:text-blue-700">Početna</a></li>
                        <li><a href="/movies" class="hover:text-blue-700">Filmovi</a></li>
                        <li><a href="/tvshows" class="hover:text-blue-700">TV Serije</a></li>
                    </ul>
                </div>
                
                
                <div class="relative w-1/3 mx-auto">
                    <form action="{{ route('movies.search') }}" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                        name="search" 
                        id="search" 
                        value="{{ request('search') }}"
                        class="w-full pl-9 pr-3 py-1 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg 
                        focus:ring-blue-500 focus:border-blue-500 focus:bg-white 
                        transition-all duration-200 placeholder-gray-500" 
                        placeholder="Pretraži filmove...">
                    </form>
                </div>
                
                
               
                @guest
                <div class="flex space-x-4">
                    <a href="/login" class="bg-gradient-to-r from-blue-500 to-lightblue-600 text-white px-4 py-2 rounded-full hover:opacity-80 transition-all duration-300 shadow-lg">Uloguj se</a>
                    <a href="/register" class="bg-gradient-to-r from-blue-500 to-lightblue-600 text-white px-4  py-2 rounded-full hover:opacity-80 transition-all duration-300 shadow-lg">Registruj se</a>
                </div>
                @endguest
                
                @auth
                <div class="flex space-x-4">
                    

                    @if (Auth::user()->Role ==='Administrator')
                    <span class="flex items-center text-blue-200">Administrator</span>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-500 to-lightblue-600 text-white px-4 py-2 rounded-full hover:opacity-80 transition-all duration-300 shadow-lg">Dashboard</a>
                    @else
                    <span class="flex items-center text-blue-200">Zdravo,{{Auth::user()->FirstName}}</span>
                    <a href="{{ route('user.dashboard') }}" class="bg-gradient-to-r from-blue-500 to-lightblue-600 text-white px-4 py-2 rounded-full hover:opacity-80 transition-all duration-300 shadow-lg">Tvoj Profil</a>
                    @endif

                    <form method="POST" action="/logout">
                        @csrf
                        
                        <button type="submit"  onclick="localStorage.clear()" class="bg-gradient-to-r from-blue-500 to-lightblue-600 text-white px-4 py-2 rounded-full hover:opacity-80 hover:cursor-pointer transition-all duration-300 shadow-lg">Izloguj se</button>
                    </form>
                    
                    
                    
                </div>
                @endauth
            </div>
        </nav>
    </div>
    
    
    