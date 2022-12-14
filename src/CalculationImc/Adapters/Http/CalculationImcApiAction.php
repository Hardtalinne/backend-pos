<?php

declare(strict_types=1);

namespace App\CalculationImc\Adapters\Http;

use App\CalculationImc\UseCases\CalculationsImcApiUseCase;
use App\CalculationImc\UseCases\ImcInputBoundary;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class CalculationImcApiAction extends PayloadAction
{
    private CalculationsImcApiUseCase $useCase;
    private float $height;
    private float $weight;
    private int $id_student;
    private int $id_professional;

    public function __construct(CalculationsImcApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->body);

        $input = new ImcInputBoundary($this->height, $this->weight, $this->id_student, $this->id_professional);

        return  $this->useCase->handle($input);
    }

    protected function ValidateInput(array $input)
    {
        if (empty($input['height'])) {
            throw new Exception("Campo height não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['weight'])) {
            throw new Exception("Campo weight não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['id_student'])) {
            throw new Exception("Campo id_student não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['id_professional'])) {
            throw new Exception("Campo id_professional não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->height = floatval($input['height']);
        $this->weight = floatval($input['weight']);
        $this->id_student = intval($input['id_student']);
        $this->id_professional = intval($input['id_professional']);
    }
}
