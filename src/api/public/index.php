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

require '../src/routes/get.php';
require '../src/routes/delete.php';
require '../src/routes/insert.php';
require '../src/routes/update.php';

// # let Slim starts to run
// without run(), the api routes won't work
$app->run();