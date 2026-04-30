<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $lineup->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded border border-gray-200 bg-white p-4">
                @auth
                    @if (auth()->user()->is_admin || auth()->id() === $lineup->user_id)
                        <div class="mb-3">
                            <a href="{{ route('lineups.edit', $lineup) }}">Editar</a>
                        </div>
                    @endif
                @endauth

                @if (session('status'))
                    <div class="mb-4 rounded border border-gray-200 px-4 py-3 text-sm">{{ session('status') }}</div>
                @endif

                <p class="text-sm text-gray-600">Creada per {{ $lineup->user->name }}</p>
                <p class="mt-2">Jugadors:</p>

                <ul class="mt-4 space-y-2">
                    @forelse ($lineup->players as $player)
                        <li class="rounded border border-gray-200 px-3 py-2 text-sm">
                            <div class="font-medium">{{ $player->name }} @if($player->country) ({{ $player->country }}) @endif</div>
                            <div class="text-xs text-gray-600">{{ $player->pivot->position }}</div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Ancora no hi ha jugadors.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
