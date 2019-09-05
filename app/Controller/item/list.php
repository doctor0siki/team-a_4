<?php

use Model\Dao\Movie;
use Slim\Http\Request;
use Slim\Http\Response;

// 商品一覧を出すコントローラです
$app->get('/item/list/', function (Request $request, Response $response) {

    $data=[];

    //アイテムDAOをインスタンス化します。
    $movie = new Movie($this->db);

    //アイテム一覧を取得し、戻り値をresultに格納します
    $data["result"] = $movie->getItemList();

    // Render index view
    return $this->view->render($response, 'item/list.twig', $data);

});
