<?php

namespace Tests\Unit\Services\Billing;

use App\Services\Billing\ProrationCalculator;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ProrationCalculatorTest extends TestCase
{
    private ProrationCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new ProrationCalculator();
    }

    public function test_calculate_proration_for_upgrade(): void
    {
        $oldPrice = 100.00;
        $newPrice = 200.00;
        $billingCycleStart = Carbon::parse('2026-04-01');
        $billingCycleEnd = Carbon::parse('2026-04-30');
        $changeDate = Carbon::parse('2026-04-15');

        $result = $this->calculator->calculateUpgrade(
            $oldPrice,
            $newPrice,
            $billingCycleStart,
            $billingCycleEnd,
            $changeDate
        );

        $this->assertIsArray($result);
        $this->assertArrayHasKey('credit', $result);
        $this->assertArrayHasKey('charge', $result);
        $this->assertArrayHasKey('net_amount', $result);
        $this->assertGreaterThan(0, $result['net_amount']);
    }

    public function test_calculate_proration_for_downgrade(): void
    {
        $oldPrice = 200.00;
        $newPrice = 100.00;
        $billingCycleStart = Carbon::parse('2026-04-01');
        $billingCycleEnd = Carbon::parse('2026-04-30');
        $changeDate = Carbon::parse('2026-04-15');

        $result = $this->calculator->calculateDowngrade(
            $oldPrice,
            $newPrice,
            $billingCycleStart,
            $billingCycleEnd,
            $changeDate
        );

        $this->assertIsArray($result);
        $this->assertArrayHasKey('credit', $result);
        $this->assertArrayHasKey('charge', $result);
        $this->assertArrayHasKey('net_amount', $result);
        $this->assertLessThanOrEqual(0, $result['net_amount']);
    }

    public function test_no_negative_values(): void
    {
        $oldPrice = 100.00;
        $newPrice = 200.00;
        $billingCycleStart = Carbon::parse('2026-04-01');
        $billingCycleEnd = Carbon::parse('2026-04-30');
        $changeDate = Carbon::parse('2026-04-29'); // Quase no fim do ciclo

        $result = $this->calculator->calculateUpgrade(
            $oldPrice,
            $newPrice,
            $billingCycleStart,
            $billingCycleEnd,
            $changeDate
        );

        $this->assertGreaterThanOrEqual(0, $result['credit']);
        $this->assertGreaterThanOrEqual(0, $result['charge']);
    }

    public function test_full_month_equals_full_price(): void
    {
        $price = 100.00;
        $billingCycleStart = Carbon::parse('2026-04-01');
        $billingCycleEnd = Carbon::parse('2026-04-30');
        $changeDate = Carbon::parse('2026-04-01'); // Início do ciclo

        $result = $this->calculator->calculateUpgrade(
            0,
            $price,
            $billingCycleStart,
            $billingCycleEnd,
            $changeDate
        );

        $this->assertEquals($price, $result['charge'], '', 0.01);
    }
}
