<?php

namespace App\Controller;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $photoAlbums = ['albums go here', 'and here'];

        return $this->render('photos/index.html.twig', [
            'photoAlbums' => $photoAlbums,
        ]);
    }

    public function createAlbumAction()
    {

    }

    public function temporaryUploadAction(Request $request)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = Urlizer::urlize($originalFileName) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        dd($uploadedFile->move(
            $destination,
            $newFileName,
        ));
    }
}
