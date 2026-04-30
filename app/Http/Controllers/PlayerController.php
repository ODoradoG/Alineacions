<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        return view('players.index', [
            'players' => Player::withCount('lineups')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('admin-only');

        return view('players.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('admin-only');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);

        $player = Player::create($validated);

        return redirect()->route('players.show', $player)->with('status', 'Jugador creat.');
    }

    public function show(Player $player): View
    {
        $player->loadCount('lineups');

        return view('players.show', [
            'player' => $player,
        ]);
    }

    public function edit(Player $player): View
    {
        Gate::authorize('admin-only');

        return view('players.edit', [
            'player' => $player,
        ]);
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        Gate::authorize('admin-only');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);

        $player->update($validated);

        return redirect()->route('players.show', $player)->with('status', 'Jugador actualitzat.');
    }

    public function destroy(Player $player): RedirectResponse
    {
        Gate::authorize('admin-only');

        $player->delete();

        return redirect()->route('players.index')->with('status', 'Jugador eliminat.');
    }
}
