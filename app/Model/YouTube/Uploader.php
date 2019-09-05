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

    private $_client;

    //リダイレクトURL
    private $_redirectUrl;


    public function __construct (string $OAuth2ClientId,string $OAuth2ClinetSecret) {
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


    public function initAuthticatin(Request $request){

        $code=$request->getAttribute ('code');


    }


    //参考:https://developers.google.com/youtube/v3/code_samples/php?hl=ja
    public function done(string $videoPath){
        // Define an object that will be used to make all API requests.


        if (isset($_GET['code'])) {
            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                die('The session state did not match.');
            }

            $this->_client->authenticate($_GET['code']);
            $_SESSION['token'] = $this->_client->getAccessToken();
            header('Location: ' . $redirect);
        }

        if (isset($_SESSION['token'])) {
            $this->_client->setAccessToken($_SESSION['token']);
        }

        $youtube = new Google_Service_YouTube($this->_client);
// Check to ensure that the access token was successfully acquired.
        if ($this->_client->getAccessToken()) {
            try{
                // REPLACE this value with the path to the file you are uploading.
                $videoPath = "/path/to/file.mp4";

                // Create a snippet with title, description, tags and category ID
                // Create an asset resource and set its snippet metadata and type.
                // This example sets the video's title, description, keyword tags, and
                // video category.
                $snippet = new Google_Service_YouTube_VideoSnippet();
                $snippet->setTitle("Test title");
                $snippet->setDescription("Test description");
                $snippet->setTags(array("tag1", "tag2"));

                // Numeric video category. See
                // https://developers.google.com/youtube/v3/docs/videoCategories/list
                $snippet->setCategoryId("22");

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

            } catch (Google_Service_Exception $e) {
                //エラー処理
                $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            } catch (Google_Exception $e) {
                $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                    htmlspecialchars($e->getMessage()));
            }

            $_SESSION['token'] = $client->getAccessToken();
        } else {
            // If the user hasn't authorized the app, initiate the OAuth flow
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;

            $authUrl = $client->createAuthUrl();
        }

    }




}