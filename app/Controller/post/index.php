<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\YouTube;

$app->post ('',function (Request $request,Response $response){

    //フォームからアップロードされたものを
    $uploadedFiles = $request->getUploadedFiles();
    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['example1'];

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uploadedFile);
        $response->write('uploaded ' . $filename . '<br/>');
    }


});
