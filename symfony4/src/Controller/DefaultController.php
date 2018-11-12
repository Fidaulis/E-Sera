<?php

namespace App\Controller;

use App\Service\DefaultService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @param DefaultService $defaultservice
     * @return Response
     */
    public function index(
        DefaultService $defaultservice
    ): Response {
        return new Response(
            $defaultservice->getHomeText()
        );
    }
}
