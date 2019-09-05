<?php

use Slim\Http\Request;
use Slim\Http\Response;

// aboutページのコントローラ
$app->get('/about', function (Request $request, Response $response) {

    $data = [];

    // Render index view
    return $this->view->render($response, 'about/about.twig', $data);
});
