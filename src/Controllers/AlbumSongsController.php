<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\SongsRepository;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\PathParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class AlbumSongsController
{
    public function __construct(
        private readonly SongsRepository $songsRepository
    )
    {
    }

    #[Path('/albums/{id}/songs')]
    #[Method(HttpMethod::GET)]
    public function index(
        #[PathParameter('id')] string $id
    ): ResponseBuilder
    {
        $songs = $this->songsRepository->getSongsForAlbumById($id);

        return (new ResponseBuilder())
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setData($songs);
    }
}