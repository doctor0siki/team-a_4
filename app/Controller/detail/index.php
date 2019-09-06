<?php

use Model\Dao\Movie;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * 商品一覧を出すコントローラです
 *
 * detail/1 = 1番の商品を
 * detail/13 = 13番の商品を
 * 表示する仕組みになっています。
 *
 * {item_id}の中身は$argsに入ります。
 * 取得する時は、$args["item_id"]で取得できます。
 */
$app->get('/detail/{movie_id}', function (Request $request, Response $response, $args) {

    $data = [];

    //URLパラメータのitem_idを取得します。
    $movie_id = $args["movie_id"];

    //アイテムDAOをインスタンス化します。
    $movieDB = new Movie($this->db);

    //URLパラメータのitem_id部分を引数として渡し、戻り値をresultに格納します
    $movie = $movieDB->getItem($movie_id);

    $data['title']=$movie['movie_name'];
    $data['description']=$movie["movie_description"];
    $data['movie_path'] = $movie["movie_path"];
    $data['map_url'] = $movie["map_url"];
    // Render index view
    return $this->view->render($response, '/detail/index.twig', $data);

});
