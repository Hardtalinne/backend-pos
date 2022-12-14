<?php

declare(strict_types=1);

namespace App\Reports\UseCases\User;

use App\Shared\Helpers\DTO;

final class ImcOutputBoundary extends DTO
{
    public string $imc;
    public string $classificacao;
    public string $nomeAluno;
    public string $nomePersonal;
    public string $dataAvalicao;
}
