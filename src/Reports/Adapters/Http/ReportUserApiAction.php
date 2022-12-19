<?php

declare(strict_types=1);

namespace App\Reports\Adapters\Http;

use App\Reports\UseCases\User\ReportUserApiUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportUserApiAction extends PayloadAction
{
    private ReportUserApiUseCase $useCase;
    private int $type_user = 0;
    private String $name = "";
    private int $id = 0;

    public function __construct(ReportUserApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->request->getQueryParams());
        return  $this->useCase->handle($this->type_user, $this->name, $this->id);
    }

    protected function ValidateInput(array $input)
    {
        if (!empty($input['type_user'])) {
            $this->type_user = intval($input['type_user']);
        }

        if (!empty($input['name'])) {
            $this->name = $input['name'];
        }

        if (!empty($input['id'])) {
            $this->id = intval($input['id']);
        }
    }
}
