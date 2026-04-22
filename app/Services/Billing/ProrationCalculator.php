<?php

namespace App\Services\Billing;

use Carbon\CarbonInterface;

class ProrationCalculator
{
    public function calculate(
        float $planAmount,
        CarbonInterface $cycleStart,
        CarbonInterface $cycleEnd,
        CarbonInterface $signupDate
    ): float {
        $totalDays = max(1, $cycleStart->diffInDays($cycleEnd));
        $remainingDays = max(0, $signupDate->diffInDays($cycleEnd, false));

        return round(($planAmount / $totalDays) * $remainingDays, 2);
    }
}
