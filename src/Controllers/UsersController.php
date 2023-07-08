<?php

namespace Vaugenwakeling\Api\Controllers;

use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class UsersController
{
    #[Path('/user/{user_id}')]
    #[Method(HttpMethod::GET)]
    public function show(): ResponseBuilder
    {
        return (new ResponseBuilder())
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setData(['user' => 123]);
    }
}