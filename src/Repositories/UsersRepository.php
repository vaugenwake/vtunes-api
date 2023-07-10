<?php

namespace Vaugenwakeling\Api\Repositories;

use Vaugenwakeling\Api\Models\User;

class UsersRepository extends RepositoryAbstract
{
    public function getUserById(string $userId): User
    {
        $user = $this->dbService->getClient()
            ->getItem([
                'TableName' => $this->getTableName(),
                'Key' => [
                    'PK' => ['S' => "USER#{$userId}"],
                    'SK' => ['S' => "USER"]
                ]
            ]);

        return User::fromItem($this->marshaler->unmarshalItem($user['Item']));
    }

    public function getUserByEmail(string $email): ?User
    {
        $user = $this->dbService->getClient()
            ->query([
                'TableName' => $this->getTableName(),
                'IndexName' => 'GSI1_UsersEmail',
                'KeyConditionExpression' => 'GSI1_PK = :pk',
                'ExpressionAttributeValues' =>  array (
                    ':pk'  => array('S' => "USER#{$email}")
                )
            ]);

        if($user['Count'] == 0) {
            return null;
        }

        return User::fromItem($this->marshaler->unmarshalItem($user['Items'][0]));
    }

    public function loginUser(string $email, string $password): User|false
    {
        $user = $this->getUserByEmail($email);

        if (is_null($user)) {
            return false;
        }

        if($user->authenticate($password)) {
            return $user;
        }

        return false;
    }
}