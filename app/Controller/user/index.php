<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;

// 動画確認画面コントローラ
$app->get('/user/', function (Request $request, Response $response) {

    // $dd(user_info); 正常に取れています。
    //GETされた内容を取得します。
    $data = $this->session["user_info"];

    if (!$data ) {
      return $response->withRedirect('/login/');
    }

    // user idを持ってくる。


    return $this->view->render($response, '/user/user.twig', $data);
});
