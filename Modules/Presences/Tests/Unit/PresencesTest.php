<?php

namespace Modules\Presences\Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class PresencesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */


    public function it_can_add_full_MonthOfJanuary()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);
        $january = now()->setMonth(1);

        $startOfMonth = $january->firstOfMonth();
        $endOfMonth = $january->lastOfMonth();

        while ($startOfMonth <= $endOfMonth) {
            if ($startOfMonth->isWeekday()) {
                $this->postJson('/api/presences/checklog', ['type' => 'in'])
                    ->assertStatus(200);
                sleep(10);
                $this->postJson('/api/presences/checklog', ['type' => 'out'])
                    ->assertStatus(200);
            }
            $startOfMonth->addDay();
        }
    }

    public function it_can_check_in()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->json('POST', 'api/presences/checklog', ['type' => 'in']);
        $response->assertStatus(200);
        sleep(10);
        $response = $this->actingAs($user)->json('POST', 'api/presences/checklog', ['type' => 'out']);
        $response->assertStatus(200);
    }


    public function it_cant_check_without_in()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->json('POST', 'api/presences/checklog', ['type' => 'out']);
        $response->assertStatus(200);
    }

    public function testLatePresencesWith30MinutesLate()
    {

        $user = User::factory()->create();
        $carbonMock = Mockery::mock(Carbon::class);
        $carbonMock->shouldReceive('now')->andReturn(Carbon::create(2023, 1, 1, 8, 30, 0));
        $this->app->instance(Carbon::class, $carbonMock);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);

        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/presences', ['type' => 'in'])
                ->assertStatus(200);

            $this->postJson('/presences', ['type' => 'out'])
                ->assertStatus(200);
            $carbonMock->addDay();
        }
    }
    public function testLatePresencesWith15MinutesLate()
    {

        $user = User::factory()->create();
        $carbonMock = Mockery::mock(Carbon::class);
        $carbonMock->shouldReceive('now')->andReturn(Carbon::create(2023, 1, 1, 8, 15, 0));
        $this->app->instance(Carbon::class, $carbonMock);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);

        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/presences', ['type' => 'in'])
                ->assertStatus(200);

            $this->postJson('/presences', ['type' => 'out'])
                ->assertStatus(200);
            $carbonMock->addDay();
        }
    }    public function testLatePresencesWith1HourLate()
    {

        $user = User::factory()->create();
        $carbonMock = Mockery::mock(Carbon::class);
        $carbonMock->shouldReceive('now')->andReturn(Carbon::create(2023, 1, 1, 9, 00, 0));
        $this->app->instance(Carbon::class, $carbonMock);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->actingAs($user);

        for ($i = 0; $i < 3; $i++) {
            $this->postJson('/presences', ['type' => 'in'])
                ->assertStatus(200);

            $this->postJson('/presences', ['type' => 'out'])
                ->assertStatus(200);
            $carbonMock->addDay();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
