<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar usuari</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <input id="is_admin" name="is_admin" type="checkbox" value="1" @checked(old('is_admin', $user->is_admin))>
                        <label for="is_admin" class="text-sm text-gray-700">És administrador</label>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button>Guardar canvis</x-primary-button>
                        <a class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700" href="{{ route('admin.users.index') }}">Tornar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
