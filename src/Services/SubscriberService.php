<?php

namespace Infomaniak\ClientApiNewsletter\Services;

class SubscriberService extends ApiService
{
        static $endpoint = 'contact';

        protected $id;

        public function __construct($client, $id = null)
        {
            parent::__construct($client);
            $this->id = $id;
        }

}