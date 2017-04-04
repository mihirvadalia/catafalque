<?php

namespace App\Traits;

/**
 * Helper functions for Solr
 * Class Solr
 * @package App\Traits
 */
trait Solr {

    protected $client;

    public function __construct(\Solarium\Client $client)
    {
        $this->client = $client;
    }

}