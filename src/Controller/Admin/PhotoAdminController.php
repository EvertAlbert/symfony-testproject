<?php

namespace App\Controller\Admin;

use App\Form\PhotoAlbumType;
use App\Repository\PhotoAlbumRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoAdminController extends AbstractController
{
    private PhotoAlbumRepository $albumRepository;

    public function __construct(PhotoAlbumRepository $albumRepository)
    {

        $this->albumRepository = $albumRepository;
    }

    public function createAlbumAction(Request $request): Response
    {
        $newPhotoAlbum = $this->albumRepository->initiateAlbum();

        $form = $this->createForm(PhotoAlbumType::class, $newPhotoAlbum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $newPhotoAlbum = $form->getData();

            // ... perform some action, such as saving the task to the database
            $this->albumRepository->add($newPhotoAlbum);

            return $this->redirectToRoute('photos');
        }

        return $this->renderForm('admin/photos/create_album.html.twig', [
            'form' => $form
        ]);
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