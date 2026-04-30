<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
    @include('layouts.navigation')

    <main class="mx-auto max-w-5xl px-6 py-10">
        <h1 class="text-2xl font-bold">Alineacions</h1>

        <section class="mt-8">
            <h2 class="text-lg font-semibold">Últimes alineacions</h2>
            <div class="mt-4 space-y-3">
                @forelse ($lineups as $lineup)
                    <a href="{{ route('lineups.show', $lineup) }}" class="block rounded border border-gray-200 p-3">
                        <div class="font-medium">{{ $lineup->name }}</div>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">Encara no hi ha alineacions.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>
