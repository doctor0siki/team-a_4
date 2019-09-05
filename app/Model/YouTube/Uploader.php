<?php

namespace Model\YouTube;
use Google_Client;
use Google_Service_YouTube;
use Google_Http_MediaFileUpload;
use Google_Service_Exception;
use Google_Exception;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Service_YouTube_Video;
use Slim\Http\Request;


//757000144812-fdstur21vbnanni1asphj0827s5l1268.apps.googleusercontent.com
//Z2VlTEYdh7TV9aoMBYrSgits


class Uploader{

    /**
     * @var Google_Client
     */
    private $_client;

    //リダイレクトURL
    private $_redirectUrl;


    /**
     * Uploader constructor.
     * @param string $OAuth2ClientId アプリケーションのクライアントID
     * @param string $OAuth2ClinetSecret アプリケーションのクライアントシークレット
     * @param string $AccessToken アクセストークン
     */
    public function __construct (string $OAuth2ClientId,string $OAuth2ClinetSecret,string $AccessToken='') {
        //クライアント初期化
        $client = new Google_Client();

        //環境変数から取ってくるのが筋かな
        $client->setClientId($OAuth2ClientId);
        $client->setClientSecret($OAuth2ClinetSecret);
        $client->setScopes('https://www.googleapis.com/auth/youtube');

        //リダイレクト作る
        $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
            FILTER_SANITIZE_URL);

        //リダイレクトURLの設定
        $client->setRedirectUri($redirect);

        $this->_client=$client;
        $this->_redirectUrl=$redirect;

    }

    /**
     * @return Google_Client
     */
    public function getClient (): Google_Client
    {
        return $this->_client;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl ()
    {
        return $this->_redirectUrl;
    }
    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUrl ($redirectUrl): void
    {
        $this->_redirectUrl = $redirectUrl;
    }

    //参考:https://developers.google.com/youtube/v3/code_samples/php?hl=ja

    /**
     * @param string $videoPath
     * @return Google_Service_YouTube_Video
     */
    public function done(string $videoPath){

        $youtube = new Google_Service_YouTube($this->_client);
// Check to ensure that the access token was successfully acquired.


                // Create a snippet with title, description, tags and category ID
                // Create an asset resource and set its snippet metadata and type.
                // This example sets the video's title, description, keyword tags, and
                // video category.
                $snippet = new Google_Service_YouTube_VideoSnippet();

                //タイトル
                $snippet->setTitle("Test title");
                //説明文
                $snippet->setDescription("Test description");
                //タグ
                $snippet->setTags(array("tag1", "tag2"));

                //カテゴリー
                // Numeric video category. See
                // https://developers.google.com/youtube/v3/docs/videoCategories/list
                $snippet->setCategoryId("22");

                //公開・非公開とかそういうやつ
                // Set the video's status to "public". Valid statuses are "public",
                // "private" and "unlisted".
                $status = new Google_Service_YouTube_VideoStatus();
                $status->privacyStatus = "public";

                // Associate the snippet and status objects with a new video resource.
                $video = new Google_Service_YouTube_Video();
                $video->setSnippet($snippet);
                $video->setStatus($status);

                // Specify the size of each chunk of data, in bytes. Set a higher value for
                // reliable connection as fewer chunks lead to faster uploads. Set a lower
                // value for better recovery on less reliable connections.
                $chunkSizeBytes = 1 * 1024 * 1024;

                // Setting the defer flag to true tells the client to return a request which can be called
                // with ->execute(); instead of making the API call immediately.
                $this->_client->setDefer(true);

                // Create a request for the API's videos.insert method to create and upload the video.
                $insertRequest = $youtube->videos->insert("status,snippet", $video);

                // Create a MediaFileUpload object for resumable uploads.
                $media = new Google_Http_MediaFileUpload(
                    $this->_client,
                    $insertRequest,
                    'video/*',
                    null,
                    true,
                    $chunkSizeBytes
                );
                $media->setFileSize(filesize($videoPath));


                // Read the media file and upload it chunk by chunk.
                $status = false;
                $handle = fopen($videoPath, "rb");
                while (!$status && !feof($handle)) {
                    $chunk = fread($handle, $chunkSizeBytes);
                    $status = $media->nextChunk($chunk);
                }

                fclose($handle);

                // If you want to make other calls after the file upload, set setDefer back to false
                $this->_client->setDefer(false);



            $_SESSION['token'] = $this->_client->getAccessToken();

         return $insertRequest;
    }




}