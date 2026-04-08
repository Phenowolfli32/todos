<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Todo App') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Figtree', sans-serif; }</style>
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        {{-- Brand mark --}}
        <a href="/" class="flex items-center gap-2 mb-6 group">
            <span class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg group-hover:bg-indigo-700 transition">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <span class="text-xl font-bold text-slate-800 tracking-tight">TodoApp</span>
        </a>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl shadow-slate-200/60 rounded-2xl ring-1 ring-slate-200">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs text-slate-400">&copy; {{ date('Y') }} TodoApp. All rights reserved.</p>
    </div>

</body>
</html>
