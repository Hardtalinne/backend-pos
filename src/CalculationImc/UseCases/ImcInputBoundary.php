<?php

declare(strict_types=1);

namespace App\CalculationImc\UseCases;

use Exception;

final class ImcInputBoundary
{
    private float $height;
    private float $weight;
    private int $id_student;
    private int $id_professional;
    public function __construct(float $height, float $weight, int $id_student, int $id_professional)
    {
        $this->height = $height;
        $this->weight = $weight;
        $this->id_student = $id_student;
        $this->id_professional = $id_professional;
    }


    public function getHeight(): float
    {
        return $this->height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getIdStudent(): int
    {
        return $this->id_student;
    }

    public function getIdProfessional(): int
    {
        return $this->id_professional;
    }
}
