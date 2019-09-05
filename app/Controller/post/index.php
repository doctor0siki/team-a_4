<?php

use Slim\Http\Request;
use Slim\Http\Response;

//動画を投稿するコントローラ
$app->get('/post_movie', function (Request $request, Response $response) {

    $data = [];
    // Render index view
    return $this->view->render($response, 'post/post_movie.twig', $data);
});
// 会員登録処理コントローラ
$app->post('/post_movie/', function (Request $request, Response $response) {

    //POSTされた内容を取得します
    $data = $request->getParsedBody();

    //$dataのデバッグ表示を行います
    dd($request);
    //dd($data);
    /*
    //ユーザーDAOをインスタンス化
    $movie = new Movie($this->db);

    //DBに登録をする。戻り値は自動発番されたIDが返ってきます
    $id = $movie->insert($data);
    */

    //動画登録完了ページを表示します。
    return $this->view->render($response, 'post/post_movie_done.twig', $data);
});
