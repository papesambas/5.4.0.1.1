<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Niveaux;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\CyclesRepository;
use App\Repository\NiveauxRepository;
use App\Repository\PublicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categories_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriesRepository $categoriesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->add($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_categories_show', methods: ['GET'])]
    public function show(CyclesRepository $cyclesRepos, ?Categories $category, PublicationsRepository $publicationsRepos, CategoriesRepository $categoriesRepos, NiveauxRepository $niveauxRepos): Response
    {
        if (!$category) {
            return $this->redirectToRoute('app_blog');
        };
        $category = $categoriesRepos->findNiveau($category);

        $publication = $publicationsRepos->findCategorie($category);
        //dd($publication);

        return $this->render('categories/show.html.twig', [
            'category' => $category,
            'categories' => $category,
            'publications' => $publication,
            'niveau' => $niveauxRepos->findAll(),
            'cycles' => $cyclesRepos->findAll(),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->add($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoriesRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}