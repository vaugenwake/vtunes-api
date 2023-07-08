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
class PingController
{
    #[Path('/')]
    #[Method(HttpMethod::GET)]
    public function index(): ResponseBuilder
    {
        return (new ResponseBuilder)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData([
                'table' => $_ENV['TABLE_NAME']
            ])
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK);
    }
}