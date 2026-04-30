<?php

namespace Database\Seeders;

use App\Models\Lineup;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@alineacions.local'],
            [
                'name' => 'Usuari',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $players = collect([
            ['name' => 'Leo Messi', 'country' => 'Argentina'],
            ['name' => 'Xavi Hernandez', 'country' => 'Espanya'],
            ['name' => 'Andres Iniesta', 'country' => 'Espanya'],
            ['name' => 'Cristiano Ronaldo', 'country' => 'Portugal'],
            ['name' => 'Ronaldinho', 'country' => 'Brasil'],
        ])->map(fn (array $data) => Player::updateOrCreate(['name' => $data['name']], $data));

        $lineup = Lineup::updateOrCreate(
            ['name' => 'Millor alineació de la història'],
            ['user_id' => $user->id]
        );

        $lineup->players()->sync(
            $players->take(5)->mapWithKeys(fn ($player) => [$player->id => ['position' => 'Jugador']])->all()
        );

        Lineup::updateOrCreate(
            ['name' => 'Equip del 2010'],
            ['user_id' => $admin->id]
        );
    }
}
