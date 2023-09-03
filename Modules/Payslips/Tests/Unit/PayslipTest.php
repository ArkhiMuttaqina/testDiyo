<?php

namespace Modules\Payslips\Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class PayslipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function test_get_payslip_summary()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $this->simulatePresencesForJanuary($user);
        $response = $this->actingAs($user)->post('/api/payslips/summary?month=1');
        dd($response);
        $response->assertStatus(200);

        $responseData = $response->json();
    }

    protected function simulatePresencesForJanuary($user)
    {
        // $startDate = Carbon::parse('2023-01-01')->startOfMonth();
        // $endDate = Carbon::parse('2023-01-31')->endOfMonth();

        // $currentDate = clone $startDate;

        // while ($currentDate <= $endDate) {
        //     $user->presences()->create([
        //         'type' => 'in',
        //         'datetime' => $currentDate->copy()->setHour(8),
        //     ]);
        //     $user->presences()->create([
        //         'type' => 'out',
        //         'datetime' => $currentDate->copy()->setHour(16),
        //     ]);

        //     $currentDate->addDay();
        // }
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $this->actingAs($user);
        $january = now()->setMonth(1);
        $startOfMonth = $january->firstOfMonth();
        $endOfMonth = $january->lastOfMonth();

        while ($startOfMonth <= $endOfMonth) {
            if ($startOfMonth->isWeekday()) {
                // Simulate 'in' presence at 8:00 AM
                $currentDate = Carbon::create(2023, 01, $startOfMonth->day, 8, 0, 0);
                Carbon::setTestNow($currentDate);
                $this->postJson('/api/presences/checklog', ['type' => 'in'])
                ->assertStatus(200);
                $currentDate->setHour(15)->setMinute(0)->setSecond(0);
                Carbon::setTestNow($currentDate);
                $this->postJson('/api/presences/checklog', ['type' => 'out'])
                ->assertStatus(200);
            }
            $startOfMonth->addDay();
        }

        Carbon::setTestNow();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
