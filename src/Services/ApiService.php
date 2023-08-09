<?php

namespace Infomaniak\ClientApiNewsletter\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiService
{
    static $endpoint = '';

    /**
     * @var Client $client
     */
    public Client $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function get($id = null)
    {
        $id = $id ?? $this->id;
        $url = static::$endpoint . '/' . $id;
        $response = $this->client->get($url);
        return $this->parseResponse($response);
    }

    public function create($data)
    {
        try{
        $response = $this->client->post(static::$endpoint, [
            'json' => $data
        ]);
        return $this->parseResponse($response);
        }catch(\GuzzleHttp\Exception\GuzzleException $e){
            return $this->parseError($e);
        }
    }

    public function update($id = null, $data = [])
    {
        $id = $id ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        $response = $this->client->put(static::$endpoint . '/' . $id, [
            'json' => $data
        ]);
        return $this->parseResponse($response);
    }

    public function delete($id = null)
    {
        $id = $id ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        $response = $this->client->delete(static::$endpoint . '/' . $id);
        return $this->parseResponse($response);
    }

    public function parseResponse(ResponseInterface $response)
    {
        $body = $response->getBody();
        $contents = $body->getContents();
        return json_decode($contents);
    }

    public function parseError($e)
    {
        $code = $e->getCode();
        $response = ($e->getResponse()->getBody()->getContents());
        return json_decode($response);
    }

    public function protectedPost($endpoint, $data) {
        try{
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
            return $this->parseResponse($response);
        }catch(\GuzzleHttp\Exception\GuzzleException $e){
            return $this->parseError($e);
        }
    }
}