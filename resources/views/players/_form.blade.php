<div>
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $player->name ?? '')" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-6">
    <x-input-label for="country" :value="__('País')" />
    <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $player->country ?? '')" />
    <x-input-error :messages="$errors->get('country')" class="mt-2" />
</div>

<div class="mt-6 flex gap-3">
    <x-primary-button>{{ $buttonText }}</x-primary-button>
    <a href="{{ route('players.index') }}">Tornar</a>
</div>
