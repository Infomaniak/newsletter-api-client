<?php

namespace Infomaniak\ClientApiNewsletter\Services;

use Exception;

class GroupService extends ApiService
{
        static $endpoint = 'mailinglist';

        protected $id;

        public function __construct($client, $id = null)
        {
            parent::__construct($client);
            $this->id = $id;
        }

        /**
         * Data example:
         * [
         *  ['email' => 'john@doe.com', 'firstname' => 'John', 'lastname' => 'Doe'],
         * ]
         * @param array $data
         * @param int|null $groupId
         * @return mixed
         * @throws Exception
         */
        public function addContact($data = null, $groupId = null) {
            $id = $groupId ?? $this->id;
            if (!$id) {
                throw new \Exception('No id provided');
            }
            $url = static::$endpoint . '/' . $id . '/importcontact';
            return $this->protectedPost(static::$endpoint . '/' . $id . '/importcontact', [
                    'contacts' => $data
            ]);
        }
}