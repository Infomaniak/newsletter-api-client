<?php

namespace Infomaniak\ClientApiNewsletter\Services;

class CreditService extends ApiService
{
        static $endpoint = 'credit';

        protected $id;

        public function __construct($client, $id = null)
        {
            parent::__construct($client);
            $this->id = $id;
        }

}