<?php
require 'vendor/autoload.php';
require 'blade.php';
require 'Controllers/SignupController.php';

use App\Controllers\SignupController;

$signupController = new SignupController($dbcon, $blade);
$signupController->handleSignup();
?><?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function FastRoute\simpleDispatcher;

// Load Database Config
$config = require __DIR__ . '/config/database.php';
$database = $config['connections'][$config['default']];

$db = mysqli_connect(
    $database['DB_HOST'], 
    $database['DB_USER'], 
    $database['DB_PASS'], 
    $database['DB_NAME']
);

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize Controllers
$controllers = [


        App\Http\Controllers\OrderController::class => new App\Http\Controllers\OrderController($db),



App\Http\Controllers\PurchaseController::class => new App\Http\Controllers\PurchaseController($db),
    App\Http\Controllers\AuthController::class => new App\Http\Controllers\AuthController($db),
    App\Http\Controllers\HomeController::class => new App\Http\Controllers\HomeController($db),
    App\Http\Controllers\HuntingtonController::class => new App\Http\Controllers\HuntingtonController($db),
    App\Http\Controllers\AjaxInfoController::class => new App\Http\Controllers\AjaxInfoController($db),
];

// Load Routes
$dispatcher = require __DIR__ . '/routes/web.php';

// Get Request Info
$request = Request::createFromGlobals();
$httpMethod = $request->getMethod();
$uri = $request->getPathInfo();

// Dispatch FastRoute
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        if (is_callable($handler)) {
            // If the handler is a direct function call
            $response = call_user_func_array($handler, array_merge([$request], $vars));
        } elseif (is_array($handler)) {
            [$controller, $method] = $handler;

            if (!isset($controllers[$controller])) {
                sendError(Response::HTTP_INTERNAL_SERVER_ERROR, "Controller not found: $controller");
                return;
            }

            // Call the controller method with parameters
            $response = call_user_func_array([$controllers[$controller], $method], array_merge([$request], $vars));
        } else {
            sendError(Response::HTTP_INTERNAL_SERVER_ERROR, "Invalid route handler.");
            return;
        }

        sendResponse($response);
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        sendError(Response::HTTP_METHOD_NOT_ALLOWED, "Method Not Allowed.");
        break;

    case FastRoute\Dispatcher::NOT_FOUND:
    default:
        sendError(Response::HTTP_NOT_FOUND, "Page Not Found.");
        break;
}

/**
 * Send a response in JSON or HTML
 */
function sendResponse(mixed $content): void
{
    $response = new Response();

    if (is_array($content)) {
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($content));
    } else {
        $response->setContent($content);
    }

    $response->send();
}

/**
 * Send an error response
 */
function sendError(int $code, string $message): void
{
    $response = new Response($message, $code);
    $response->send();
    exit();
}