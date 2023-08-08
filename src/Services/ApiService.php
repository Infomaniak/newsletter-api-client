<?php

namespace Infomaniak\ClientApiNewsletter\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class ApiService{
    private static $endpoint;

    private static $urlV1 = 'https://newsletter.infomaniak.com/api/v1/public/';

    private static $urlV3 = 'https://api.infomaniak.com/v3/api/1/newsletter/';

    /**
     * @var Client $client
     */
    private $client;

    private $version;

    public function __construct( $key, $secret = '', $version = 'v3')
    {
        $credentials = base64_encode($key . ':' . $secret);
        $url = 'url' . strtoupper($version);
        $config = [
            'base_uri' => self::$$url,
            'headers' => [
                'Authorization' => $version == 'v3' ? 'Bearer ' . $credentials : 'Basic ' . $credentials,
            ]
        ];
        $this->client = new Client($config);
        $this->version = $version;
    }

    private function _endpoint()
    {
        $variableName = 'endpoint' . strtoupper($this->version);
        return static::$$variableName;
    }

    /**
     * Get all campaigns
     * @return string
     */
    public function all()
    {
        $response = $this->client->get($this->_endpoint());

        return $this->parseResponse($response);
    }

    /**
     * Get a campaign
     * @param string $id
     * @return Response
     */
    public function get($id)
    {
        return $this->client->get(static::$endpoint . '/' . $id);
    }

    /**
     * Create a campaign
     * @param array $data
     * @return Response
     */
    public function create($data)
    {
        return $this->client->post(static::$endpoint, $data);
    }

    /**
     * Update a campaign
     * @param string $id
     * @param array $data
     * @return Response
     */
    public function update($id, $data)
    {
        return $this->client->put(static::$endpoint . '/' . $id, $data);
    }

    /**
     * Delete a campaign
     * @param string $id
     * @return Response
     */
    public function delete($id)
    {
        return $this->client->delete(static::$endpoint . '/' . $id);
    }


    private function parseResponse($response)
    {
        $body = $response->getBody()->getContents();
        return json_decode($body, true);
    }

}