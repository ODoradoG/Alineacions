<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded border border-gray-200 bg-white px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded border border-gray-200 bg-white p-4">
                    <h3 class="font-semibold">Les teves alineacions</h3>
                    <div class="mt-3 space-y-3">
                        @forelse ($lineups as $lineup)
                            <div class="rounded border border-gray-200 p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <a class="font-medium" href="{{ route('lineups.show', $lineup) }}">{{ $lineup->name }}</a>
                                        <p class="text-sm text-gray-600">{{ $lineup->players->count() }} jugadors</p>
                                    </div>
                                    <div class="flex gap-3 text-sm">
                                        <a href="{{ route('lineups.edit', $lineup) }}">Editar</a>
                                        <form method="POST" action="{{ route('lineups.destroy', $lineup) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Encara no has creat cap alineació.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded border border-gray-200 bg-white p-4">
                    <h3 class="font-semibold">Accessos</h3>
                    <div class="mt-3 space-y-2 text-sm">
                        <a class="block" href="{{ route('lineups.index') }}">Veure alineacions</a>
                        <a class="block" href="{{ route('players.index') }}">Veure jugadors</a>
                        @if ($isAdmin)
                            <a class="block" href="{{ route('admin.users.index') }}">Gestionar usuaris</a>
                            <a class="block" href="{{ route('players.create') }}">Crear jugador</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
