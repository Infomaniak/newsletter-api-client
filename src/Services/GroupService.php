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
        public function addContacts(array $data, int $groupId = null) {
            $id = $groupId ?? $this->id;
            if (!$id) {
                throw new \Exception('No id provided');
            }
            return $this->protectedPost(static::$endpoint . '/' . $id . '/importcontact', [
                    'contacts' => $data
            ]);
        }

    /**
     * @param string $data
     * @param int|null $groupId
     * @return mixed
     * @throws Exception
     */
    public function subscribeEmail(string $email, int $groupId = null) {
        $id = $groupId ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        return $this->protectedPost(static::$endpoint . '/' . $id . '/importcontact', [
            'contacts' => [
                [
                    'email' => $email
                ]
            ]
        ]);
    }

        public function deleteEmail($email, $groupId = null) {
            $id = $groupId ?? $this->id;
            if (!$id) {
                throw new \Exception('No id provided');
            }
            return $this->protectedPost(static::$endpoint . '/' . $id . '/managecontact', [
                'email' => $email,
                'status' => 'delete'
            ]);
        }

    public function unsubscribeEmail($email, $groupId = null) {
        $id = $groupId ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        return $this->protectedPost(static::$endpoint . '/' . $id . '/managecontact', [
            'email' => $email,
            'status' => 'unsub'
        ]);
    }

    public function subscribers(int $page= 1, int $perPage = 10, $groupId = null) {
        $id = $groupId ?? $this->id;
        if (!$id) {
            throw new \Exception('No id provided');
        }
        return $this->protectedGet(static::$endpoint . '/' . $id . '/contact'. '?page=' . $page . '&perPage=' . $perPage);
    }


}