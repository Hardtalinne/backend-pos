<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\Domain\Exceptions\UserDomainException;
use App\Login\UseCases\User\DeleteUserApiUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Fig\Http\Message\StatusCodeInterface;

final class DeleteUserApiAction extends PayloadAction
{
    private DeleteUserApiUseCase $useCase;
    private int $id_usuario;

    public function __construct(DeleteUserApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $this->ValidateInput($this->args);

        return $this->useCase->handle($this->id_usuario);
    }

    protected function ValidateInput(array $input)
    {
        if (empty($input['id'])) {
            throw new UserDomainException("Campo id não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }
        $this->id_usuario = intval($input['id']);
    }
}
