<?php
// # use Namespaces for HTTP request
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// # include the Slim framework
require '../vendor/autoload.php';

// # include DB connection file
require '../src/config/bd.php';

require '../src/modele.php';

// # create new Slim instance
$app = new \Slim\App;

// # Converti l'en-tête au format JSON
$app->add(function (Request $request, Response $response, callable $next) {
    // Use the PSR-7 $response object
    $response = $response->withHeader('Content-type', 'application/json');
    return $next($request, $response);
});

require '../src/routes/get.php';
require '../src/routes/delete.php';
require '../src/routes/insert.php';
require '../src/routes/update.php';

// # let Slim starts to run
// without run(), the api routes won't work
$app->run();