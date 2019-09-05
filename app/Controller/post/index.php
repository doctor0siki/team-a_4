<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Model\YouTube;

$app->get('/post/',function (Request $request,Response $response){
    return $this->view->render($response, 'post/post_movie.twig', []);
});

$app->post ('/post_movie/',function (Request $request,Response $response){



    //フォームからアップロードされたものを
    $uploadedFiles = $request->getUploadedFiles();

    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['file_upload'];

    //
    if(is_null ($uploadedFile)){
        //return $this->view->render();
    }

    //アップロード先 TODO:いつかリファクタリング
    $directory=realpath(__DIR__.'/../../../uploads');

    //アップロード先に移動させる
    if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
        //TODO:エラー処理
    }

    $filename = moveUploadedFile($directory, $uploadedFile);

    $uploader=new YouTube\Uploader('757000144812-fdstur21vbnanni1asphj0827s5l1268.apps.googleusercontent.com','Z2VlTEYdh7TV9aoMBYrSgits');

    if (0 < strlen ($request->getAttribute ('code'))) {
        if (strval($this->session->get('state')) !== strval($request->getAttribute ('state'))) {

            //TODO:エラー処理のところ dieはまずいよ
            die('The session state did not match.');
        }

        $uploader->getClient ()->authenticate ($request->getAttribute ('code'));
        $this->session->set('token',$uploader->getClient ()->getAccessToken ());

        return $response->withRedirect ($uploader->getRedirectUrl ());
    }

    try{
        $uploader->done ($directory.DIRECTORY_SEPARATOR.$filename);
    }catch(Google_Service_Exception $e){

    }catch(Google_Exception $e){

    }


    return $this->view->render($response, 'post/post_movie_done.twig', []);
});

/**
 * ぶっちゃけヘルパー（コピペした）
 *
 * @param $directory
 * @param UploadedFile $uploadedFile
 * @return string
 * @throws Exception
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}