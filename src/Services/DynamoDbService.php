<?php

namespace Vaugenwakeling\Api\Services;

use Aws\DynamoDb\DynamoDbClient;

class DynamoDbService
{
    private DynamoDbClient $client;

    public function __construct()
    {
//        var_dump($this->getConfigFromEnv()); die;
        $this->client = new DynamoDbClient($this->getConfigFromEnv());
    }

    public function getClient(): DynamoDbClient
    {
        return $this->client;
    }

    private function getConfigFromEnv(): array
    {
        $config = [
            'version' => 'latest',
            'region' => $_ENV['AWS_REGION'] ?? 'us-east-1',
            'endpoint' => $_ENV['AWS_ENDPOINT'] ?? null,
            'profile' => $_ENV['AWS_PROFILE'] ?? null
        ];

        return $config;
    }
}