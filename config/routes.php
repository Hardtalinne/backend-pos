<?php

/** @var App $app */

use App\Login\Adapters\Http\GetTypesUserApiAction;
use App\Login\Adapters\Http\GetUserMeApiAction;
use App\Login\UseCases\User\GetTypesUserUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Api\Adapters\Http\ApiAction;
use App\CalculationImc\Adapters\Http\CalculationImcApiAction;
use App\Login\Adapters\Http\CreateUserApiAction;
use App\Login\Adapters\Http\DeleteUserApiAction;
use App\Login\Adapters\Http\LoginAction;
use App\Login\Adapters\Http\ValidateTokenAction;
use App\Middleware\AuthenticationMiddleware;


use App\Middleware\CorsMiddleware;
use App\Middleware\ExceptionNotFoundMiddleware;
use App\Middleware\SentryMiddleware;
use App\Reports\Adapters\Http\ReportImcApiAction;
use App\Reports\Adapters\Http\ReportUserApiAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Factory\AppFactory;

//Here I pass the DI-PHP Container variable. So he performs the dependency injection
$app = AppFactory::createFromContainer($container);

$app->addBodyParsingMiddleware();

// This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
$app->add(new CorsMiddleware());

// The RoutingMiddleware should be added after our CORS middleware so routing is performed first
$app->addRoutingMiddleware();


$app->add(new SentryMiddleware());
// Personalizando mensagens de retorno das exceptions padrões da aplicação
$app->add(ExceptionNotFoundMiddleware::class);

$app->group('/', function (RouteCollectorProxyInterface $group) {
    $group->get('', ApiAction::class);
});

$app->group('/api', function (RouteCollectorProxyInterface $group) {
    $group->post('/login', LoginAction::class);
    $group->post('/authorization', ValidateTokenAction::class);
    $group->get('/me', GetUserMeApiAction::class)->add(AuthenticationMiddleware::class);
    $group->post('/user', CreateUserApiAction::class);
    $group->put('/user', CreateUserApiAction::class);
    $group->get('/user', ReportUserApiAction::class);
    $group->get('/types-users', GetTypesUserApiAction::class);
    $group->post('/calculate-imc', CalculationImcApiAction::class)->add(AuthenticationMiddleware::class);
    $group->get('/imc', ReportImcApiAction::class)->add(AuthenticationMiddleware::class);
    $group->delete('/user/{id}', DeleteUserApiAction::class)->add(AuthenticationMiddleware::class);

    $group->options('/login', function (Request $request, Response $response): Response {
        return $response;
    });

    $group->options('/authorization', function (Request $request, Response $response): Response {
        return $response;
    });

    $group->options('/me', function (Request $request, Response $response): Response {
        return $response;
    });

    $group->options('/user', function (Request $request, Response $response): Response {
        return $response;
    });

    $group->options('/calculate-imc', function (Request $request, Response $response): Response {
        return $response;
    });

    $group->options('/imc', function (Request $request, Response $response): Response {
        return $response;
    });
});
