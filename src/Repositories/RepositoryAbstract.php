<?php

namespace Vaugenwakeling\Api\Repositories;

use Aws\DynamoDb\Marshaler;
use Vaugenwakeling\Api\Services\DynamoDbService;

abstract class RepositoryAbstract
{
    public function __construct(
        protected readonly DynamoDbService $dbService,
        protected readonly Marshaler $marshaler
    )
    {
    }

    protected function getTableName(): string
    {
        if(empty($_ENV['TABLE_NAME']))
        {
            throw new \Exception('Missing TABLE_NAME from environment');
        }

        return $_ENV['TABLE_NAME'];
    }
}