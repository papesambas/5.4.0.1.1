<?php

namespace App\Controller;

use App\Entity\Niveaux;
use App\Form\NiveauxType;
use App\Repository\CategoriesRepository;
use App\Repository\CyclesRepository;
use App\Repository\NiveauxRepository;
use App\Repository\PublicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/niveaux')]
class NiveauxController extends AbstractController
{
    #[Route('/', name: 'app_niveaux_index', methods: ['GET'])]
    public function index(NiveauxRepository $niveauxRepository): Response
    {
        return $this->render('niveaux/index.html.twig', [
            'niveauxes' => $niveauxRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_niveaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NiveauxRepository $niveauxRepository): Response
    {
        $niveau = new Niveaux();
        $form = $this->createForm(NiveauxType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niveauxRepository->add($niveau, true);

            return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('niveaux/new.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_niveaux_show', methods: ['GET'])]
    public function show(Niveaux $niveau, CyclesRepository $cyclesRepos, PublicationsRepository $publicationsRepos, CategoriesRepository $categoriesRepos): Response
    {
        return $this->render('niveaux/show.html.twig', [
            'niveau' => $niveau,
            'publications' => $publicationsRepos,
            'categories' => $categoriesRepos,
            'cycles' => $cyclesRepos->findAll(),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_niveaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Niveaux $niveau, NiveauxRepository $niveauxRepository): Response
    {
        $form = $this->createForm(NiveauxType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $niveauxRepository->add($niveau, true);

            return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('niveaux/edit.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_niveaux_delete', methods: ['POST'])]
    public function delete(Request $request, Niveaux $niveau, NiveauxRepository $niveauxRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $niveau->getId(), $request->request->get('_token'))) {
            $niveauxRepository->remove($niveau, true);
        }

        return $this->redirectToRoute('app_niveaux_index', [], Response::HTTP_SEE_OTHER);
    }
}