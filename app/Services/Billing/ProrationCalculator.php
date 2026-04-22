<?php

namespace App\Services\Billing;

use Carbon\CarbonInterface;

class ProrationCalculator
{
    /**
     * Calcula o valor pro-rata de um plano
     *
     * @param float $planAmount Valor total do plano
     * @param CarbonInterface $cycleStart Data de início do ciclo
     * @param CarbonInterface $cycleEnd Data de término do ciclo
     * @param CarbonInterface $signupDate Data de inscrição/mudança
     * @return float Valor pro-rata calculado
     */
    public function calculate(
        float $planAmount,
        CarbonInterface $cycleStart,
        CarbonInterface $cycleEnd,
        CarbonInterface $signupDate
    ): float {
        // Validar que signupDate está dentro do ciclo
        if ($signupDate->isBefore($cycleStart)) {
            $signupDate = $cycleStart->copy();
        }

        if ($signupDate->isAfter($cycleEnd)) {
            return 0;
        }

        // Calcular dias totais do ciclo
        $totalDays = max(1, $cycleStart->diffInDays($cycleEnd, false));

        // Calcular dias restantes a partir da data de inscrição
        $remainingDays = max(0, $signupDate->diffInDays($cycleEnd, false));

        // Garantir que não retorna valor negativo
        $proRataAmount = ($planAmount / $totalDays) * $remainingDays;

        return max(0, round($proRataAmount, 2));
    }

    /**
     * Calcula o crédito pro-rata para downgrade
     *
     * @param float $currentPlanAmount Valor do plano atual
     * @param float $newPlanAmount Valor do novo plano
     * @param CarbonInterface $cycleStart Data de início do ciclo
     * @param CarbonInterface $cycleEnd Data de término do ciclo
     * @param CarbonInterface $changeDate Data da mudança
     * @return float Crédito a ser aplicado (positivo) ou débito (negativo)
     */
    public function calculateDowngradeCredit(
        float $currentPlanAmount,
        float $newPlanAmount,
        CarbonInterface $cycleStart,
        CarbonInterface $cycleEnd,
        CarbonInterface $changeDate
    ): float {
        // Valor já pago pro-rata do plano atual
        $paidAmount = $this->calculate($currentPlanAmount, $cycleStart, $cycleEnd, $cycleStart);

        // Valor que deveria ter pago com o novo plano
        $shouldPayAmount = $this->calculate($newPlanAmount, $cycleStart, $cycleEnd, $changeDate);

        // Crédito = o que pagou - o que deveria pagar
        $credit = $paidAmount - $shouldPayAmount;

        return round($credit, 2);
    }

    /**
     * Calcula o débito pro-rata para upgrade
     *
     * @param float $currentPlanAmount Valor do plano atual
     * @param float $newPlanAmount Valor do novo plano
     * @param CarbonInterface $cycleStart Data de início do ciclo
     * @param CarbonInterface $cycleEnd Data de término do ciclo
     * @param CarbonInterface $changeDate Data da mudança
     * @return float Débito a ser cobrado (positivo)
     */
    public function calculateUpgradeCharge(
        float $currentPlanAmount,
        float $newPlanAmount,
        CarbonInterface $cycleStart,
        CarbonInterface $cycleEnd,
        CarbonInterface $changeDate
    ): float {
        // Valor já pago pro-rata do plano atual
        $paidAmount = $this->calculate($currentPlanAmount, $cycleStart, $cycleEnd, $cycleStart);

        // Valor que deveria pagar com o novo plano
        $shouldPayAmount = $this->calculate($newPlanAmount, $cycleStart, $cycleEnd, $changeDate);

        // Débito = o que deveria pagar - o que pagou
        $charge = $shouldPayAmount - $paidAmount;

        return max(0, round($charge, 2));
    }
}
