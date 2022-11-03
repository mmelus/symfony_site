<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SongService;

class SongController extends AbstractController
{
    #[Route(path: '/{_locale}/tango', name: 'tango_list', requirements: ['_locale' => 'en|fr|es', ], methods:['GET'] )]
    public function TangoIndex(SongService $tangoService): Response
    {
        $artist = $tangoService->getRandomArtist();

        return $this->render('tango/list.html.twig', [
            'tango_artist' => $artist,
        ]);
    }
}