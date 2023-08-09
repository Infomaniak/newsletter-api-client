<?php

namespace Infomaniak\ClientApiNewsletter\Services;

class CampaignService extends ApiService
{
        static $endpoint = 'campaign';

        protected $id;

        public function __construct($client, $id = null)
        {
            parent::__construct($client);
            $this->id = $id;
        }

        public function send($id = null) {
            $id = $id ?? $this->id;
            if (!$id) {
                throw new \Exception('No id provided');
            }
            $response = $this->client->post(static::$endpoint . '/' . $id . '/send');
            return $this->parseResponse($response);
        }

        public function test($id = null, $email = "") {
            $id = $id ?? $this->id;
            if (!$id) {
                throw new \Exception('No id provided');
            }
            if (!$email) {
                throw new \Exception('No email provided');
            }
            $response = $this->protectedPost(static::$endpoint . '/' . $id . '/test', [
                'email' => $email
            ]);
            return $response;
        }

    public function schedule($id = null, \DateTime $date = null) {
        $id = $id ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        if (!$date) {
            throw new \Exception('No date provided');
        }
        $response = $this->protectedPost(static::$endpoint . '/' . $id . '/schedule', [
            'scheduled_at' => $date->format('Y-m-d H:i:s')
        ]);
        return $response;
    }


}