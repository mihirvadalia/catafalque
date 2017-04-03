<?php

namespace App\Traits;

trait Solr {

    protected $client;

    public function __construct(\Solarium\Client $client)
    {
        $this->client = $client;
    }

}