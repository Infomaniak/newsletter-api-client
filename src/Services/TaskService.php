<?php

namespace Infomaniak\ClientApiNewsletter\Services;

class TaskService extends ApiService
{
        static $endpoint = 'task';

        protected $id;

        public function __construct($client, $id = null)
        {
            parent::__construct($client);
            $this->id = $id;
        }

}