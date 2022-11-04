<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SongService;

#[Route(path: '/{_locale}/songs', name: 'song', requirements: ['_locale' => 'en|fr', ] )]
class SongController extends AbstractController
{
    #[Route(path: '/', name: '_list', methods:['GET'] )]
    public function TangoIndex(SongService $tangoService): Response
    {
        $artist = $tangoService->getRandomArtist();

        return $this->render('song/list.html.twig', [
            'tango_artist' => $artist,
        ]);
    }
}