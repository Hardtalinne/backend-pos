<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\User\GetUserMeUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Container\ContainerInterface;

class GetUserMeApiAction extends PayloadAction
{
    private GetUserMeUseCase $getUserMeUseCase;
    private $container;

    public function __construct(
        GetUserMeUseCase   $getUserMeUseCase,
        ContainerInterface $container
    )
    {
        $this->getUserMeUseCase = $getUserMeUseCase;
        $this->container = $container;
    }

    protected function handle(): array
    {
        try {
            $token = $this->request->getHeaderLine('Authorization');
            $configJwt = $this->container->get('config')['jwt'];
            list($jwt) = sscanf($token, 'Bearer %s');

            $token = JWT::decode($jwt, new Key($configJwt['key'], $configJwt['algorithm']));

            $userMe = $this->getUserMeUseCase->handle($token->data->id);

            return ["userMe" => $userMe];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
