<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/")
     */
    public function indexAction(): Response
    {
        return new Response('welcome home');
    }

    /**
     * @Route ("/{slug}")
     * @param $slug
     * @return Response
     */
    public function home($slug): Response
    {
        return new Response('second page');
    }
}
