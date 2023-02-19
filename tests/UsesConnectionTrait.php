<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\NovaPoshta\Tests;

use GuzzleHttp\Client;
use RuntimeException;
use SergeyNezbritskiy\NovaPoshta\Connection;

trait UsesConnectionTrait
{
    private Connection $client;

    public function getConnection(): Connection
    {
        if (empty($this->client)) {
            $apiKey = getenv('apiKey');
            if (empty($apiKey)) {
                throw new RuntimeException('apiKey not provided. Please pass it through phpunit.xml or env variables');
            }
            $this->client = new Connection($apiKey, new Client());
        }
        return $this->client;
    }
}
