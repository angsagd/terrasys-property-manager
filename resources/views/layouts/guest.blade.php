<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Terrasys') }} - Property Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased h-full flex flex-col">
        <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50 relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute inset-y-0 w-full h-full pointer-events-none" aria-hidden="true">
                <div class="absolute -top-1/2 -right-1/4 w-full h-full bg-gradient-to-b from-brand-100/50 to-transparent rounded-full blur-3xl transform rotate-12 opacity-70"></div>
                <div class="absolute -bottom-1/2 -left-1/4 w-full h-full bg-gradient-to-t from-blue-100/50 to-transparent rounded-full blur-3xl transform -rotate-12 opacity-70"></div>
            </div>

            <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
                <div class="flex justify-center">
                    <svg class="h-12 w-auto text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M4 3a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm1 3h5v2H5V6zm7 0h7v2h-7V6zm-7 4h5v2H5v-2zm7 0h7v2h-7v-2zm-7 4h5v2H5v-2zm7 0h7v2h-7v-2z" /></svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Terrasys</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Enterprise Property Management System</p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-[480px] relative z-10">
                <div class="bg-white px-6 py-10 shadow-xl shadow-brand-900/5 ring-1 ring-gray-200/50 sm:rounded-2xl sm:px-12">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
