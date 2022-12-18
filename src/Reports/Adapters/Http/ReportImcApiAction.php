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
    private string $data_avalicao = '0';

    public function __construct(ReportImcApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->request->getQueryParams());
        return  $this->useCase->handle($this->id_user, $this->data_avalicao);
    }

    protected function ValidateInput($input)
    {

        if (empty($input['id_user'])) {
            throw new Exception("Campo id_user não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (!empty($input['data_avalicao'])) {
            $this->data_avalicao = $input['data_avalicao'];
        }

        $this->id_user = intval($input['id_user']);
    }
}
