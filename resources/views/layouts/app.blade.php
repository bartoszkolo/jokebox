    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <title>@yield('title', config('Jokebox', 'Jokebox')) - Najlepsze dowcipy w sieci!</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!--JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>



        <!-- Custom Styles -->
        <style>
            .branding {
                font-family: 'Figtree', sans-serif;
                font-weight: 600;
            }
            .joke-card {
                background-color: #ffffff;
                border-radius: 0.5rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            }
            .joke-text {
                color: #374151;
            }
            .vote-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 9999px;
                color: #ffffff;
                font-size: 0.875rem; /* 14px */
                line-height: 1.25rem; /* 20px */
            }
            .vote-button.upvote {
                background-color: #10b981; /* green-500 */
            }
            .vote-button.downvote {
                background-color: #ef4444; /* red-500 */
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen">


            <header class="bg-teal-700 shadow-md border-b border-gray-700 dark:bg-gray-900 dark:border-gray-800">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row justify-between items-center">
                    
                    <!-- Logo and Hamburger Menu -->
                    <div class="flex justify-between w-full lg:w-auto">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Jokebox Logo" class="h-20">
                        </a>
                        <button id="menuToggle" class="text-white lg:hidden">
                            <i class="fas fa-bars"></i> <!-- Hamburger Icon -->
                        </button>
                    </div>
        
                    <!-- Navigation Links -->
                    <nav id="navMenu" class="hidden flex-col lg:flex lg:flex-row lg:items-center space-y-4 lg:space-y-0 lg:space-x-4">
                        <a href="{{ route('jokes.favorites') }}" class="requires-auth px-3 py-2 rounded-md text-md font-medium text-white hover:bg-teal-500 transition duration-200 ease-in-out">Moje żarty</a>
                        <a href="#" id="toggleSearch" class="px-3 py-2 rounded-md font-medium text-md text-white hover:text-teal-300 transition duration-200 ease-in-out">Szukaj</a>
                        <a href="{{ route('jokes.random') }}" class="px-3 py-2 rounded-md text-md font-medium text-white hover:bg-teal-500 transition duration-200 ease-in-out">Losowy</a>
                        <a href="{{ route('jokes.create') }}" class="requires-auth px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-extrabold rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105 inline-flex items-center ml-4">
                            <i class="requires-auth fas fa-plus mr-2"></i> DODAJ DOWCIP
                        </a>
                        <button id="darkModeToggle" x-data="{ darkMode: false }" @click="darkMode = !darkMode; $dispatch('dark-mode-change', { darkMode: darkMode })" class="text-white hover:text-teal-300 transition duration-200 ease-in-out ml-4">
                            <template x-if="!darkMode">
                                <i class="fas fa-moon"></i> <!-- Moon icon for light mode -->
                            </template>
                            <template x-if="darkMode">
                                <i class="fas fa-sun"></i> <!-- Sun icon for dark mode -->
                            </template>
                        </button>
                    </nav>

        
                    <!-- Right Side User and Dropdown Menu -->
                    @auth
                    <div class="hidden lg:flex items-center">
                        <!-- Settings Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center text-md font-medium text-white hover:text-teal-300 focus:outline-none focus:text-teal-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-teal-100 dark:hover:bg-teal-600" role="menuitem">Profil</a>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-teal-100 dark:hover:bg-teal-600" role="menuitem">
                                    Wyloguj się
                                </a>
                            </div>
                        </div>
        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    @endauth
                </div>
            </header> 
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menuToggle');
            const navMenu = document.getElementById('navMenu');

            menuToggle.addEventListener('click', function () {
                navMenu.classList.toggle('hidden');
            });
        });



        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('darkModeToggle');
            const html = document.documentElement;
    
            // Check if a dark mode preference is stored
            if (localStorage.getItem('darkMode') === 'true') {
                html.classList.add('dark');
            } else if (localStorage.getItem('darkMode') === 'false') {
                html.classList.remove('dark');
            }
    
            btn.addEventListener('click', function () {
                html.classList.toggle('dark');
    
                // Save the user's preference in local storage
                if (html.classList.contains('dark')) {
                    localStorage.setItem('darkMode', 'true');
                } else {
                    localStorage.setItem('darkMode', 'false');
                }
            });
        });
    </script>
    

<!-- Search Bar (initially hidden) -->
<div id="searchBar" class="hidden bg-teal-700 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('jokes.search') }}" method="GET" class="flex justify-center">
            <input type="text" name="search" placeholder="Wpisz szukaną frazę..." class="form-control w-1/2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-gray-500 dark:bg-gray-800 dark:text-white">
            <button type="submit" class="ml-4 px-4 py-2 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-gray-500">Szukaj</button>
        </form>
    </div>
</div>

<!-- Login Modal -->
<div id="loginModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-1/3">
            <!-- Modal Header -->
            <div class="border-b px-4 py-2 flex justify-between items-center">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-white">Login</h3>
                <button class="text-black dark:text-white close-modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="p-4">
                <!-- Social Login -->
                <div class="flex justify-center space-x-4 mb-6">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-flex items-center">
                        <i class="fab fa-facebook-f mr-2"></i> Facebook
                    </button>
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-flex items-center">
                        <i class="fab fa-google mr-2"></i> Google
                    </button>
                </div>
                <!-- Login form -->
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <!-- Email input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="email">Email</label>
                        <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Password input -->
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="password">Password</label>
                        <input type="password" id="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Submit button -->
                    <div class="flex items-center justify-between">
                        <button class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<main>
    <div class="flex">
        <!-- Main Content -->
        <div class="flex-1">
            @yield('content')
        </div>
        

        
    </div>
</main>

        </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-6">
                <a href="{{ url('/polityka-prywatnosci') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">Polityka prywatności</a> |
                <a href="{{ url('/regulamin') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">Regulamin</a> |
                <a href="{{ url('/kontakt') }}" class="text-gray-600 dark:text-gray-400 text-sm hover:underline">Kontakt</a>
            </div>
            <div class="flex justify-center items-center flex-col sm:flex-row gap-8 mb-4">
                <span class="text-gray-600 dark:text-gray-400 text-sm mb-2 sm:mb-0">Pobierz nasze aplikacje:</span>
                <a href="https://apps.apple.com/app/idYOUR_APP_ID" target="_blank" class="block">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on the App Store" class="h-12">
                </a>
                <a href="https://play.google.com/store/apps/details?id=YOUR_PACKAGE_NAME" target="_blank" class="block">
                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" class="h-12" style="height: 54px; min-height: 54px;">
                </a>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} Jokebox. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('toggleSearch').addEventListener('click', function (event) {
                event.preventDefault();
                var searchBar = document.getElementById('searchBar');
                searchBar.classList.toggle('hidden');
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isAuthenticated = @json(Auth::check());
        const authRequiredLinks = document.querySelectorAll('.requires-auth');

        authRequiredLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                if (!isAuthenticated) {
                    event.preventDefault();
                    // Show the login modal
                    document.getElementById('loginModal').classList.remove('hidden');
                }
            });
        });
    });
</script>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    // Optionally add the CSRF token to formData if it's not already a form field
    // formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch('/login', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            // Let the browser set the Content-Type
        },
        body: formData
    })
    .then(response => {
        if (response.ok) {
            // Handle successful login
            document.getElementById('loginModal').classList.add('hidden');
            window.location.reload();
            // Update UI or reload page as needed
        } else {
            // Handle errors
            throw new Error('Login failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Display an error message to the user
    });
});

</script>


<style>
    #searchBar.hidden {
        display: none;
    }
</style>



    
    </body>
    </html>
