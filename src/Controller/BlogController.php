<?php

namespace App\Controller;

use App\Repository\CyclesRepository;
use App\Repository\PublicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(PublicationsRepository $publicationsRepos, CyclesRepository $cyclesRepos): Response
    {
        return $this->render('blog/index.html.twig', [
            'publications' => $publicationsRepos->findAll(),
            'cycles' => $cyclesRepos->findAll()
        ]);
    }
}