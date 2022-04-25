<?php

use App\Publisher\MessagePublisher;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->post('/sendMessage', function (Request $request, Response $response, array $args) {
    $messageBody = $request->getParsedBody();
    $publisher   = new MessagePublisher();
    $publisher->sendMessage($messageBody);

    return $response;
});

$app->run();
