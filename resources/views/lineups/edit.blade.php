<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar alineació</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('lineups.update', $lineup) }}">
                    @csrf
                    @method('PUT')
                    @include('lineups._form', ['buttonText' => 'Guardar canvis', 'players' => $players, 'selectedPlayerIds' => $lineup->players->pluck('id')->all()])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
