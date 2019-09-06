<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;
use Model\Dao\Movie;

// 動画確認画面コントローラ
$app->get('/user/', function (Request $request, Response $response) {

    // $dd(user_info); 正常に取れています。
    //GETされた内容を取得します。
    $session_user = $this->session["user_info"];

    if (!$session_user ) {
      return $response->withRedirect('/login/');
    }

    // user idを持ってくる。
    //アイテムDAOをインスタンス化します。
    $movie = new Movie($this->db);
    $data=[];
    $data["name"]=$session_user["name"];
    $data["email"]=$session_user["email"];

    //アイテム一覧を取得し、戻り値をresultに格納します
    $data["result"] = $movie->getItemListOfUser($session_user['id']);
    #dd($data["result"]);
    return $this->view->render($response, '/user/user.twig', $data);
});
