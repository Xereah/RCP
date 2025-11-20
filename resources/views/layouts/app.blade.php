<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Material Icons -->
        <link href="{{ asset('css/font.css') }}" rel="stylesheet">    
        <script src="{{ asset('js/tailwindcom.js') }}"></script>    
        @livewireStyles    
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <div class="h-screen flex">
            <livewire:layout.sidebar />

            <div class="flex-1 flex flex-col min-h-screen w-full">
                <livewire:layout.navigation />

                <!-- Page Heading -->
                @isset($header)
                <header class="bg-white/80 shadow-sm border-b border-slate-200">
                    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-slate-50">
                    <div class="p-4 sm:p-6 lg:p-8">
                        @yield('content')
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        <!-- Livewire Scripts -->
        @livewireScripts      
        <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    </body>
</html>


