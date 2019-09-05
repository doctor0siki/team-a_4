<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;

// 動画確認画面コントローラ
$app->get('/user/', function (Request $request, Response $response) {

    // $dd(user_info); 正常に取れています。
    //GETされた内容を取得します。
    $data = $this->session["user_info"];
    // Render index view
    return $this->view->render($response, '/user/user.twig', $data);
});
