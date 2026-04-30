<?php

namespace App\Http\Controllers;

use App\Models\Lineup;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LineupController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lineup::with(['user', 'players'])->latest();

        if (! $request->user()) {
            $query->limit(5);
        }

        return view('lineups.index', [
            'lineups' => $query->get(),
            'featuredLineups' => Lineup::with(['user', 'players'])->latest()->limit(5)->get(),
        ]);
    }

    public function create(): View
    {
        return view('lineups.create', [
            'lineup' => new Lineup(),
            'players' => Player::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'player_ids' => ['nullable', 'array', 'max:11'],
            'player_ids.*' => ['integer', 'distinct', 'exists:players,id'],
            'positions' => ['nullable', 'array'],
            'positions.*' => ['string', 'in:Porter,Defensa,Migcampista,Davanter'],
        ]);

        $lineup = Lineup::create([
            'name' => $validated['name'],
            'user_id' => $request->user()->id,
        ]);

        $this->syncPlayers($lineup, $validated['player_ids'] ?? [], $validated['positions'] ?? []);

        return redirect()->route('lineups.show', $lineup)->with('status', 'Alineació creada.');
    }

    public function show(Lineup $lineup): View
    {
        $lineup->load(['user', 'players']);

        return view('lineups.show', [
            'lineup' => $lineup,
        ]);
    }

    public function edit(Lineup $lineup): View
    {
        Gate::authorize('manage-lineup', $lineup);

        return view('lineups.edit', [
            'lineup' => $lineup->load('players'),
            'players' => Player::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Lineup $lineup): RedirectResponse
    {
        Gate::authorize('manage-lineup', $lineup);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'player_ids' => ['nullable', 'array', 'max:11'],
            'player_ids.*' => ['integer', 'distinct', 'exists:players,id'],
            'positions' => ['nullable', 'array'],
            'positions.*' => ['string', 'in:Porter,Defensa,Migcampista,Davanter'],
        ]);

        $lineup->update([
            'name' => $validated['name'],
        ]);

        $this->syncPlayers($lineup, $validated['player_ids'] ?? [], $validated['positions'] ?? []);

        return redirect()->route('lineups.show', $lineup)->with('status', 'Alineació actualitzada.');
    }

    public function destroy(Lineup $lineup): RedirectResponse
    {
        Gate::authorize('manage-lineup', $lineup);

        $lineup->delete();

        return redirect()->route('dashboard')->with('status', 'Alineació eliminada.');
    }

    private function syncPlayers(Lineup $lineup, array $playerIds, array $positions = []): void
    {
        if (count($playerIds) > 11) {
            throw ValidationException::withMessages([
                'player_ids' => 'Només es poden afegir 11 jugadors com a màxim.',
            ]);
        }

        $lineup->players()->sync(
            collect($playerIds)->mapWithKeys(fn ($playerId) => [
                $playerId => ['position' => $positions[$playerId] ?? 'Davanter']
            ])->all()
        );
    }
}
