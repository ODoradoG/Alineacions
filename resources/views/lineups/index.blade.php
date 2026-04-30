<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Alineacions</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @auth
                <div class="mb-4">
                    <a href="{{ route('lineups.create') }}">Nova alineació</a>
                </div>
            @endauth

            <div class="space-y-3">
                @forelse ($lineups as $lineup)
                    <a href="{{ route('lineups.show', $lineup) }}" class="block rounded border border-gray-200 bg-white p-3">
                        <div class="font-medium">{{ $lineup->name }}</div>
                        <div class="text-sm text-gray-600">{{ $lineup->user->name }}</div>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">No hi ha alineacions encara.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
