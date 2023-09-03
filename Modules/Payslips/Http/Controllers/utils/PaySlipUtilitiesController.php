<?php

namespace Modules\Payslips\Http\Controllers\utils;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaySlipUtilitiesController extends Controller
{

    /**
     * @param int $id
     * @return Renderable
     */
    public function generatePaySlip($month)
    {
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();
        $totalWorkingDays = $startOfMonth->diffInWeekdays($endOfMonth);

        $basicSalary = 2000000; // it can customized
        $dailyPerformanceAllowance = 15000;
        $latePenaltyRates = [
            15 => 5000,
            30 => 10000,
            60 => 0,
        ];


        $totalPerformanceAllowance = $totalWorkingDays * $dailyPerformanceAllowance;
        $totalLatePenalty = 0;

        $presenceRecords = auth()->user()->presences()
            ->whereBetween('datetime', [$startOfMonth, $endOfMonth])
            ->orderBy('datetime')
            ->get();

        foreach ($presenceRecords as $key => $record) {
            if ($record->type === 'out' && isset($presenceRecords[$key - 1])) {
                $timeDifference = $record->datetime->diffInMinutes($presenceRecords[$key - 1]->datetime);

                foreach ($latePenaltyRates as $threshold => $penalty) {
                    if ($timeDifference >= $threshold) {
                        $totalLatePenalty += $penalty;
                        break;
                    }
                }
            }
        }

        $takeHomePay = $basicSalary + $totalPerformanceAllowance - $totalLatePenalty;

        return [
            'month' => $month,
            'components' => [
                ['name' => 'Gaji Pokok', 'amount' => $basicSalary],
                ['name' => 'Tunjangan Kinerja', 'amount' => $totalPerformanceAllowance],
                ['name' => 'Potongan Keterlambatan', 'amount' => $totalLatePenalty],
            ],
            'take_home_pay' => $takeHomePay,
        ];
    }
}
