<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $player->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded border border-gray-200 bg-white p-4">
                @can('admin-only')
                    <div class="mb-3">
                        <a href="{{ route('players.edit', $player) }}">Editar</a>
                    </div>
                @endcan

                <p>País: {{ $player->country ?? 'Sense país' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
