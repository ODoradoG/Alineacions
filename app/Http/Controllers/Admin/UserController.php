<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        Gate::authorize('admin-only');

        return view('admin.users.index', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function edit(User $user): View
    {
        Gate::authorize('admin-only');

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('admin-only');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Usuari actualitzat.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('admin-only');

        if ($request->user()?->id === $user->id) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Usuari eliminat.');
    }
}
