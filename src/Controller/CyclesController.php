<?php

namespace App\Controller;

use App\Entity\Cycles;
use App\Form\CyclesType;
use App\Repository\CyclesRepository;
use App\Repository\NiveauxRepository;
use App\Repository\PublicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cycles')]
class CyclesController extends AbstractController
{
    #[Route('/', name: 'app_cycles_index', methods: ['GET'])]
    public function index(CyclesRepository $cyclesRepository): Response
    {
        return $this->render('cycles/index.html.twig', [
            'cycles' => $cyclesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cycles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CyclesRepository $cyclesRepository): Response
    {
        $cycle = new Cycles();
        $form = $this->createForm(CyclesType::class, $cycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cyclesRepository->add($cycle, true);

            return $this->redirectToRoute('app_cycles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cycles/new.html.twig', [
            'cycle' => $cycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cycles_show', methods: ['GET'])]
    public function show(Cycles $cycle, CyclesRepository $cyclesRepos, PublicationsRepository $publicationsRepos, NiveauxRepository $niveauxRepos): Response
    {
        return $this->render('cycles/show.html.twig', [
            'publications' => $publicationsRepos->findAll(),
            'niveaux' => $niveauxRepos->find($cycle),
            'cycle' => $cycle,
            'cycles' => $cyclesRepos->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cycles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cycles $cycle, CyclesRepository $cyclesRepository): Response
    {
        $form = $this->createForm(CyclesType::class, $cycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cyclesRepository->add($cycle, true);

            return $this->redirectToRoute('app_cycles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cycles/edit.html.twig', [
            'cycle' => $cycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cycles_delete', methods: ['POST'])]
    public function delete(Request $request, Cycles $cycle, CyclesRepository $cyclesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cycle->getId(), $request->request->get('_token'))) {
            $cyclesRepository->remove($cycle, true);
        }

        return $this->redirectToRoute('app_cycles_index', [], Response::HTTP_SEE_OTHER);
    }
}