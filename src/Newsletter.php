<?php

namespace Infomaniak\ClientApiNewsletter;

use GuzzleHttp\Client;
use Infomaniak\ClientApiNewsletter\Services\CampaignService;
use Infomaniak\ClientApiNewsletter\Services\CreditService;
use Infomaniak\ClientApiNewsletter\Services\GroupService;
use Infomaniak\ClientApiNewsletter\Services\SubscriberService;
use Infomaniak\ClientApiNewsletter\Services\TaskService;

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

    public function subscribers($id = null){
        return new SubscriberService($this->client, $id);
    }

    public function groups($id = null){
        return new GroupService($this->client, $id);
    }

    public function tasks($id = null){
        return new TaskService($this->client, $id);
    }

    public function credits($id = null){
        return new CreditService($this->client, $id);
    }
}