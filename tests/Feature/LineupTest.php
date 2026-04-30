<?php

namespace Tests\Feature;

use App\Models\Lineup;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LineupTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_lineup_with_up_to_11_players(): void
    {
        $user = User::factory()->create();
        $players = Player::factory()->count(11)->create();

        $response = $this->actingAs($user)->post(route('lineups.store'), [
            'name' => 'Equip bàsic',
            'player_ids' => $players->pluck('id')->all(),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('lineups', [
            'name' => 'Equip bàsic',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount('lineup_player', 11);
    }

    public function test_user_can_not_add_more_than_11_players_to_a_lineup(): void
    {
        $user = User::factory()->create();
        $players = Player::factory()->count(12)->create();

        $response = $this->actingAs($user)->from(route('lineups.create'))->post(route('lineups.store'), [
            'name' => 'Equip massa gran',
            'player_ids' => $players->pluck('id')->all(),
        ]);

        $response->assertSessionHasErrors('player_ids');
        $this->assertDatabaseMissing('lineups', [
            'name' => 'Equip massa gran',
        ]);
    }
}
