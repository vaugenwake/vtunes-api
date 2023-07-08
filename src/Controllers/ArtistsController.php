<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\ArtistsRepository;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\PathParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class ArtistsController
{
    public function __construct(
        private readonly ArtistsRepository $artistsRepository
    )
    {
    }

    #[Path('/artists/{id}')]
    #[Method(HttpMethod::GET)]
    public function show(
        #[PathParameter('id')] string $id
    ): ResponseBuilder
    {
        $artist = $this->artistsRepository->getArtistById($id);

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData($artist);
    }
}