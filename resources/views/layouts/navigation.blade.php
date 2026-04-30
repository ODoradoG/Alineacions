<nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a class="font-semibold text-gray-800" href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                Alineacions
            </a>

            <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                <a href="{{ route('lineups.index') }}" class="{{ request()->routeIs('lineups.*') ? 'font-semibold' : '' }}">Alineacions</a>
                <a href="{{ route('players.index') }}" class="{{ request()->routeIs('players.*') ? 'font-semibold' : '' }}">Jugadors</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Dashboard</a>
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'font-semibold' : '' }}">Usuaris</a>
                    @endif
                    <a href="{{ route('profile.edit') }}">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-left">Sortir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Entrar</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrar</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
