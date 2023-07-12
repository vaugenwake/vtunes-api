<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\UsersRepository;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\PathParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class UsersController
{
    public function __construct(
        private readonly UsersRepository $usersRepository
    )
    {
    }

    #[Path('/users/{user_id}')]
    #[Method(HttpMethod::GET)]
    public function show(
        #[PathParameter('user_id')] string $user_id
    ): ResponseBuilder
    {
        $user = $this->usersRepository->getUserById($user_id);

        return (new ResponseBuilder())
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setData($user);
    }
}