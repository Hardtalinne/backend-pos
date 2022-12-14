<?php

declare(strict_types=1);

namespace App\CalculationImc\UseCases\Contracts;

interface CalculationImcRepositoryInterface
{
    public function saveImc(float $imc, int $id_student, int $id_professional): bool;
    public function FindStudent(int $id_student): array;
    public function FindProfessional(int $id_professional): array;
}
