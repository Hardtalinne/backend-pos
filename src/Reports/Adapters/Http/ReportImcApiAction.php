<?php

declare(strict_types=1);

namespace App\Reports\Adapters\Http;

use App\Reports\UseCases\User\ReportImcApiUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportImcApiAction extends PayloadAction
{
    private ReportImcApiUseCase $useCase;
    private int $id_user;

    public function __construct(ReportImcApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->args);
        return  $this->useCase->handle($this->id_user);
    }

    protected function ValidateInput(array $input)
    {
        if (empty($input['id_user'])) {
            throw new Exception("Campo id_user não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->id_user = intval($input['id_user']);
    }
}
