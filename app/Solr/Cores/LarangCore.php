<?php

namespace App\Solr\Cores;

use App\Solr\Solr;

/**
 * Helper functions for Solr Cores
 * Class Solr Cores
 * @package App\Traits\Solr
 */
class LarangCore extends Solr {

    public function __construct(\Solarium\Client $client)
    {
        $this->client = $client;
        $this->baseUri = $this->client->getEndpoint('localhost')->getBaseUri();
    }

}