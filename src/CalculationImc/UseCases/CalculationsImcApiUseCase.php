<?php

declare(strict_types=1);

namespace App\CalculationImc\UseCases;

use App\CalculationImc\UseCases\Contracts\CalculationImcRepositoryInterface;
use App\Shared\Helpers\Util;
use DateTime;

final class CalculationsImcApiUseCase
{
    private CalculationImcRepositoryInterface $calculationImc;

    public function __construct(
        CalculationImcRepositoryInterface $calculationImc
    ) {
        $this->calculationImc = $calculationImc;
    }

    public function handle(ImcInputBoundary $input): array
    {
        $imc = $this->calculateIMC($input->getHeight(), $input->getWeight());
        $classification = Util::classificationIMC($imc);
        $this->calculationImc->saveImc($imc, $input->getIdStudent(), $input->getIdProfessional());
        $student = $this->calculationImc->FindStudent($input->getIdStudent());
        $professional = $this->calculationImc->FindProfessional($input->getIdStudent());

        return  [
            'imc' => $imc,
            'classificacao' => $classification,
            'aluno' => $student['nome'],
            'personal' =>  $professional['nome'],
            'data' =>  (new DateTime())->format('d/m/Y')
        ];
    }

    private function calculateIMC(float $height, float $weight): float
    {
        $imc =   number_format($weight / ($height * $height), 2);
        return  floatval($imc);
    }
}
