@php
    $selectedPlayerIds = collect(old('player_ids', $selectedPlayerIds ?? []))->map(fn ($id) => (int) $id)->all();
    $positions = ['Porter' => 'Porter', 'Defensa' => 'Defensa', 'Migcampista' => 'Migcampista', 'Davanter' => 'Davanter'];
@endphp

<div>
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $lineup->name ?? '')" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-6">
    <p class="text-sm font-medium text-gray-700">Jugadors (màxim 11)</p>
    <div class="mt-3 space-y-3">
        @forelse ($players as $player)
            <div class="flex items-center gap-3 text-sm">
                <input type="checkbox" id="player_{{ $player->id }}" name="player_ids[]" value="{{ $player->id }}" @checked(in_array($player->id, $selectedPlayerIds))>
                <label for="player_{{ $player->id }}" class="flex-1">{{ $player->name }} @if($player->country) ({{ $player->country }}) @endif</label>
                <select name="positions[{{ $player->id }}]" class="text-sm border border-gray-300 rounded px-2 py-1">
                    @foreach ($positions as $value => $label)
                        <option value="{{ $value }}" @selected(old("positions.{$player->id}", $lineup->players->firstWhere('id', $player->id)?->pivot->position ?? 'Davanter') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        @empty
            <p class="text-sm text-gray-500">No hi ha jugadors encara.</p>
        @endforelse
    </div>
    <x-input-error :messages="$errors->get('player_ids')" class="mt-2" />
</div>

<div class="mt-6 flex gap-3">
    <x-primary-button>{{ $buttonText }}</x-primary-button>
    <a href="{{ route('lineups.index') }}">Tornar</a>
</div>
