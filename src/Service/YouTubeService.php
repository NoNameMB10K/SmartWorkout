<?php

namespace App\Service;

use Google_Client;
use Google_Exception;
use Google_Service_Exception;
use Google_Service_YouTube;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class YouTubeService
{
    private $client;

    public function __construct(string $apiKey)
    {
        $this->client = new Google_Client();
        $this->client->setDeveloperKey($apiKey);

        // Disable SSL verification for GuzzleHttp Client
        $guzzleClient = new Client(['verify' => false]);
        $this->client->setHttpClient($guzzleClient);
    }

    public function searchFirstVideoUrl(string $query): ?string
    {
        try {
            $youtube = new Google_Service_YouTube($this->client);


            $response = $youtube->search->listSearch('id,snippet', [
                'q' => $query,
                'maxResults' => 1,
                'type' => 'video'
            ]);


            $videos = $response->getItems();

            if (count($videos) > 0) {
                $videoId = $videos[0]->getId()->getVideoId();
                //return 'https://www.youtube.com/watch?v=' . $videoId;
                return $videoId;
            }

            return null;

        } catch (Google_Service_Exception $e) {
            dd($e);
            // Handle Google service exception
            // Log or return null
            return null;

        } catch (Google_Exception $e) {
            // Handle Google client exception
            // Log or return null
            return null;

        } catch (GuzzleException $e) {
            // Handle Guzzle HTTP exception
            // Log or return null
            return null;
        }
    }
}
