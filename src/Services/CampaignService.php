<?php

namespace Infomaniak\ClientApiNewsletter\Services;

class CampaignService extends ApiService
{
        static $endpointV3 = 'campaigns';
        static $endpointV1 = 'campaign';

        /**
        * CampaignService constructor.
        * @param string $token
        */
        public function __construct($token, $secret, $version)
        {
            parent::__construct($token, $secret, $version);
        }

}