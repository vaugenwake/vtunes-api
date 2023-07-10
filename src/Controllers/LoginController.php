<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\UsersRepository;
use willitscale\Streetlamp\Attributes\Accepts;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\BodyParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class LoginController
{
    public function __construct(
        private readonly UsersRepository $usersRepository
    )
    {
    }

    #[Path('/login')]
    #[Method(HttpMethod::POST)]
    #[Accepts(MediaType::APPLICATION_JSON)]
    public function login(
        #[BodyParameter] string $bodyData
    ): ResponseBuilder
    {
        $params = json_decode($bodyData, false);

        $result = $this->usersRepository->loginUser(
            $params->email,
            $params->password
        );

        $response = [
            'error' => true,
            'message' => 'Could not log you in with details provided.'
        ];

        if($result !== false) {
            $response = [
                'success' => true,
                'user' => $result
            ];
        }

        return (new ResponseBuilder())
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setHttpStatusCode($result ? HttpStatusCode::HTTP_OK : HttpStatusCode::HTTP_UNAUTHORIZED)
            ->setData($response);
    }
}