<?php

use Model\Dao\Movie;
use Slim\Http\Request;
use Slim\Http\Response;

// 商品一覧を出すコントローラです
$app->get('/all_list/', function (Request $request, Response $response) {
    //GETされた内容を取得します。
    $keyword = $request->getParam('keyword');

    $data=[];

    //アイテムDAOをインスタンス化します。
    $movie = new Movie($this->db);

    if(empty($keyword)){
        //アイテム一覧を取得し、戻り値をresultに格納します
        $data["result"] = $movie->getItemList();
    }else{
        $data["result"]= $movie->search($keyword);
    }


    // Render index view
    return $this->view->render($response, 'all_list/index.twig', $data);

});
