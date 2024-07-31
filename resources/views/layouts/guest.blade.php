<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('admin/assets/css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    {{-- <link href="{{ asset('admin/assets/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet"> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900">

    <!-- Navigation -->
    {{-- @if (Route::has('login'))
        <nav class="flex justify-end p-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif --}}

    <main>
        <div class="container-fluid px-4">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sb-admin.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stateToCities = {
                'Dubai': ['Business Bay', 'Karama', 'Deira', 'Qusais', 'Jumeirah', 'Bur Dubai'],
                'Sharjah': ['Al Gulaya', 'Al Majaz', 'Al Qasimia', 'Al Nahda', 'Al Taawun', 'Al Mufeed'],
                'Abu Dhabi': ['Al Reem Island', 'Al Aman', 'Al Mushrif', 'Al Bateen', 'Al Dhafra', 'Al Yasat'],
                'Ajman': ['Al Nuaimia', 'Al Mowaihat', 'Al Jurf', 'Al Rashidiya', 'Al Hamidiya', 'Al Zahra'],
                'Ras Al Khaimah': ['Al Nakheel', 'Al Mairid', 'Al Jazirah', 'Al Hamra', 'Al Qurm', 'Al Riffa'],
                'Umm Al Quwain': ['Umm Al Quwain City', 'Al Salama', 'Al Madinah', 'Al Humaidiya', 'Al Nakhil',
                    'Al Murjan'
                ],
                'Fujairah': ['Fujairah City', 'Al Hail', 'Al Gulaya', 'Al Murbah', 'Al Bidyah', 'Al Sharq'],
            };


            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');

            stateSelect.addEventListener('change', function() {
                const selectedState = stateSelect.value;
                const cities = stateToCities[selectedState] || [];
                // console.log(cities);
                citySelect.innerHTML = '<option value="">Select a city</option>';

                cities.forEach(function(city) {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            });
        });
    </script>

</body>

</html>
