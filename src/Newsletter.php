<?php

namespace Infomaniak\ClientApiNewsletter;

use GuzzleHttp\Client;
use Infomaniak\ClientApiNewsletter\Services\CampaignService;

class Newsletter{
    private static $url = 'https://newsletter.infomaniak.com/api/v1/public/';

    /**
     * @var Client $client
     */
    private $client;

    public function __construct( $key, $secret = '')
    {
        $credentials = base64_encode($key . ':' . $secret);
        $config = [
            'base_uri' => static::$url,
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ]
        ];
        $this->client = new Client($config);
    }

    public function campaings($id = null){
        return new CampaignService($this->client, $id);
    }

}