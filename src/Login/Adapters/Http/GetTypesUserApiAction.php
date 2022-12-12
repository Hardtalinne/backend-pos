<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\User\GetTypesUserUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;

class GetTypesUserApiAction extends PayloadAction
{
    private GetTypesUserUseCase $getTypesUserUseCase;

    public function __construct(
        GetTypesUserUseCase $getTypesUserUseCase,
    )
    {
        $this->getTypesUserUseCase = $getTypesUserUseCase;
    }

    protected function handle(): array
    {
        try {
            return $this->getTypesUserUseCase->handle();

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
