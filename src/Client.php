<?php

    namespace Infomaniak\ClientApiNewsletter;
    use GuzzleHttp\Exception\ClientException;
    use GuzzleHttp\Exception\ServerException;
    use GuzzleHttp\RequestOptions;

    /**
     * Class Client
     * @package Infomaniak\ClientApiNewsletter
     */
    class Client {

        private $base_uri = 'https://newsletter.infomaniak.com/api/v1/public/';
        private $client;

        const MAILINGLIST   = "mailinglist";
        const CONTACT       = "contact";
        const CAMPAIGN      = "campaign";
        const TASK          = "task";

        /**
         * Client constructor.
         * @param $client_api
         * @param $client_secret
         */
        public function __construct($client_api, $client_secret)
        {
            $this->client = new \GuzzleHttp\Client([
                'base_uri'              => $this->base_uri,
                RequestOptions::HEADERS => [
                    'User-Agent' => 'PHP wrapper for API newsletter'
                ],
                RequestOptions::AUTH    => [$client_api, $client_secret],
            ]);
        }

        /**
         * Perform request with curl.
         * @param $method
         * @param $resource
         * @param array $args
         * @return Response
         */
        private function _request($method, $resource, $args=[])
        {
            $uri = $this->_buildURL($resource, $args);

            $options = [];
            if (array_key_exists('params', $args))
                $options = ['json' => $args['params']];

            try {
                $response = $this->client->request($method, $uri, $options);
            }
            catch (ClientException $e) {
                $response = $e->getResponse();
            }
            catch (ServerException $e) {
                $response = $e->getResponse();
            }

            return new Response($response);
        }

        /**
         * Build URL with parameters.
         * @param $resource
         * @param array $args
         * @return mixed
         */
        private function _buildURL($resource, $args=[])
        {
            $args = array_merge(
                [
                    'id'        => '',
                    'action'    => '',
                    'action_id' => '',
                ],
                array_change_key_case($args)
            );

            return join(
                '/',
                array_filter(
                    array(
                        $resource, $args['id'], $args['action'], $args['action_id']
                    )
                )
            );
        }

        /**
         * Perform a GET request to server.
         * @param $resource
         * @param array $args
         * @return Response
         */
        public function get($resource, $args=[])
        {
            return $this->_request('GET', $resource, $args);
        }

        /**
         * Perform a POST request to server.
         * @param $resource
         * @param array $args
         * @return Response
         */
        public function post($resource, $args=[])
        {
            return $this->_request('POST', $resource, $args);
        }

        /**
         * Perform a PUT request to server.
         * @param $resource
         * @param array $args
         * @return Response
         */
        public function put($resource, $args=[])
        {
            return $this->_request('PUT', $resource, $args);
        }

        /**
         * Perform a DELETE request to server.
         * @param $resource
         * @param array $args
         * @return Response
         */
        public function delete($resource, $args=[])
        {
            return $this->_request('DELETE', $resource, $args);
        }

        /**
         * Perform a PING request to server.
         * @return Response
         */
        public function ping()
        {
            return $this->get('ping');
        }
    }