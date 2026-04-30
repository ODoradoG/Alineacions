<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Jugadors</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @can('admin-only')
                <div class="mb-4">
                    <a href="{{ route('players.create') }}">Nou jugador</a>
                </div>
            @endcan

            <div class="space-y-3">
                @foreach ($players as $player)
                    <div class="rounded border border-gray-200 bg-white p-3">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <a class="font-medium" href="{{ route('players.show', $player) }}">{{ $player->name }}</a>
                                <p class="text-sm text-gray-600">{{ $player->country ?? 'Sense país' }}</p>
                            </div>
                            @can('admin-only')
                                <div class="flex gap-3 text-sm">
                                    <a href="{{ route('players.edit', $player) }}">Editar</a>
                                    <form method="POST" action="{{ route('players.destroy', $player) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Eliminar</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
