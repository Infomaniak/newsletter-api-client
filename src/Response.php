<?php

    namespace Infomaniak\ClientApiNewsletter;
    use Psr\Http\Message\ResponseInterface;

    /**
     * Class Response
     * @package Infomaniak\ClientApiNewsletter
     */
    class Response {

        private $status;
        private $success;
        private $body;
        private $raw;

        /**
         * Construct response
         * @param ResponseInterface $response Guzzle response
         */
        public function __construct($response)
        {
            if ($response) {
                $this->raw = $response;
                $this->status = $response->getStatusCode();
                $this->body = json_decode($response->getBody(), true);
                $this->success = floor($this->status / 100) == 2 ? true : false;
            }
        }

        /**
         * Get status code
         * @return int
         */
        public function status()
        {
            return $this->status;
        }

        /**
         * Get response success
         * @return bool
         */
        public function success()
        {
            return $this->success;
        }

        /**
         * Get response body
         * @return mixed
         */
        public function body()
        {
            return $this->body;
        }

        /**
         * Get response datas
         * @return mixed
         */
        public function datas()
        {
            if (isset($this->body['data']))
            {
                return $this->body['data'];
            }

            return $this->body;
        }

        /**
         * Get response errors
         * @return bool
         */
        public function errors()
        {
            if (isset($this->body['error']))
            {
                $json_error = current($this->body['error']);
                return json_decode($json_error, true);
            }

            return false;
        }

        /**
         * Get raw content
         * @return string
         */
        public function rawContent()
        {
            return $this->raw->getBody()->getContents();
        }

        /**
         * Get reason phrase
         * @return string
         */
        public function reason()
        {
            return $this->raw->getReasonPhrase();
        }
    }