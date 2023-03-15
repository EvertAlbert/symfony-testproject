<?php

namespace App\Controller;

use App\Entity\PhotoAlbum;
use App\Form\PhotoAlbumType;
use App\Repository\PhotoAlbumRepository;
use Carbon\Carbon;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends AbstractController
{
    private PhotoAlbumRepository $albumRepository;

    public function __construct(PhotoAlbumRepository $albumRepository)
    {

        $this->albumRepository = $albumRepository;
    }

    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $photoAlbums = $this->albumRepository->findAll();

        return $this->render('photos/index.html.twig', [
            'photoAlbums' => $photoAlbums,
        ]);
    }
}
