<?php

namespace Vaugenwakeling\Api\Controllers;

use Vaugenwakeling\Api\Repositories\PlaylistsRepository;
use Vaugenwakeling\Api\Repositories\SongsRepository;
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
class PlaylistSongsController
{
    public function __construct(
        private readonly PlaylistsRepository $playlistsRepository,
        private readonly SongsRepository $songsRepository
    )
    {
    }

    #[Path('/playlists/{playlist_id}/songs')]
    #[Method(HttpMethod::GET)]
    public function index(
        #[PathParameter('playlist_id')] string $playlistId
    ): ResponseBuilder
    {
        $songs = $this->playlistsRepository->getPlaylistsSongsById($playlistId);

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_CREATED)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData([
                'count' => $songs->count(),
                'tracks' => $songs
            ]);
    }

    #[Path('/playlists/{playlist_id}/songs')]
    #[Method(HttpMethod::POST)]
    public function store(
        #[PathParameter('playlist_id')] string $playlistId,
        #[BodyParameter] string $bodyParams
    ): ResponseBuilder
    {
        $bodyParams = json_decode($bodyParams, false);

        $song = $this->songsRepository->getSongByAlbumId($bodyParams->album_id, $bodyParams->song_id);

        $attached = $this->playlistsRepository->attachSongToPlaylist(
            $playlistId,
            $song
        );

        return (new ResponseBuilder())
            ->setHttpStatusCode(HttpStatusCode::HTTP_CREATED)
            ->setContentType(MediaType::APPLICATION_JSON)
            ->setData([
                'success' => $attached,
                'song' => [
                    'id' => $song->getId()
                ]
            ]);
    }
}