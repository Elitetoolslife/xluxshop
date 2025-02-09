<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    // Authentication Routes
    $r->addRoute('GET', '/login', [App\Http\Controllers\AuthController::class, 'showLoginForm']);
    $r->addRoute('POST', '/login', [App\Http\Controllers\AuthController::class, 'login']);
    $r->addRoute('GET', '/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    // Signup Routes
    $r->addRoute('GET', '/signup', [App\Http\Controllers\AuthController::class, 'showSignupForm']);
    $r->addRoute('POST', '/signup', [App\Http\Controllers\AuthController::class, 'signup']);

    // Home Page (Buyer Dashboard)
    $r->addRoute('GET', '/home', [App\Http\Controllers\HomeController::class, 'showHomePage']);

    // Huntington Bank Logs
    $r->addRoute('GET', '/huntington-log-info', [App\Http\Controllers\HuntingtonController::class, 'showHuntingtonbank']);

    // AJAX Info Route (Returns JSON Response)
    $r->addRoute('GET', '/ajaxinfo', [App\Http\Controllers\AjaxInfoController::class, 'fetchAjaxInfo']);

    // AJAX Info Test Page (BladeOne View)
    $r->addRoute('GET', '/ajaxinfo/view', function () {
        $ajaxInfoController = new App\Http\Controllers\AjaxInfoController();
        echo $ajaxInfoController->blade->run("ajaxInfo");
    });

    // Huntington Bank Routes
    $r->addRoute('GET', '/huntingtonbanks', [App\Http\Controllers\HuntingtonController::class, 'showHuntingtonbank']);
    $r->addRoute('POST', '/buyHuntington', [App\Http\Controllers\HuntingtonController::class, 'buyHuntington']);
});