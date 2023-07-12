<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\PlaylistsRepository;
use willitscale\Streetlamp\Attributes\Controller\RouteController;
use willitscale\Streetlamp\Attributes\Parameter\BodyParameter;
use willitscale\Streetlamp\Attributes\Parameter\PathParameter;
use willitscale\Streetlamp\Attributes\Path;
use willitscale\Streetlamp\Attributes\Route\Method;
use willitscale\Streetlamp\Builders\ResponseBuilder;
use willitscale\Streetlamp\Enums\HttpMethod;
use willitscale\Streetlamp\Enums\HttpStatusCode;
use willitscale\Streetlamp\Enums\MediaType;

#[RouteController]
class UsersPlaylistController
{
    public function __construct(
        private readonly PlaylistsRepository $playlistsRepository
    )
    {
    }

    #[Path('/users/{id}/playlists')]
    #[Method(HttpMethod::POST)]
    public function store(
        #[PathParameter('id')] string $user_id,
        #[BodyParameter] string $bodyData
    ): ResponseBuilder
    {
        $data = json_decode($bodyData, false);

        $playlist = $this->playlistsRepository->createNewPlaylistForUser(
            userId: $user_id,
            name: $data->name
        );

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_CREATED)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData($playlist);
    }

    #[Path('/users/{id}/playlists')]
    #[Method(HttpMethod::GET)]
    public function index(
        #[PathParameter('id')] string $user_id
    ): ResponseBuilder
    {
        $playlists = $this->playlistsRepository->getPlaylistsForUserById($user_id);

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData($playlists);
    }

    #[Path('/users/{user_id}/playlists/{playlist_id}')]
    #[Method(HttpMethod::GET)]
    public function show(
        #[PathParameter('user_id')] string $userId,
        #[PathParameter('playlist_id')] string $playlistId
    ): ResponseBuilder
    {
        $playlist = $this->playlistsRepository->getPlaylistForUserById($userId, $playlistId);

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_OK)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData($playlist);
    }
}