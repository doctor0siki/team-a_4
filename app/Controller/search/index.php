<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\Movie;

$app->get('/search/', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $keyword = $request->getParam('keyword');
    $data=[];

    //アイテムDAOをインスタンス化します。
    $movie = new Movie($this->db);
    $data["result"]= $movie->search($keyword);

    // Render index view
    return $this->view->render($response, '/search/index.twig', $data);


});
