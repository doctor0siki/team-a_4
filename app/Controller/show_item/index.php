<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;

// 動画確認画面コントローラ
$app->get('/show_item', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $data = $request->getQueryParams();
    $data['title']="モックタイトル";
    $data['description']="説明文説明文";
    // Render index view
    return $this->view->render($response, '/show_item/index.twig', $data);
});