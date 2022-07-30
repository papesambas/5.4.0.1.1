<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Categories;
use App\Entity\Classes;
use App\Entity\Comments;
use App\Entity\Cycles;
use App\Entity\Enseignements;
use App\Entity\Etablissements;
use App\Entity\Niveaux;
use App\Entity\Publications;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Walanda-5.4.0.1');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToRoute('Mon Site', 'fa fa-home', 'app_home');
        yield MenuItem::linkToRoute('Mon Blog', 'fa fa-blog', 'app_blog');
        yield MenuItem::subMenu('Utlisateurs', 'fas fa-users')->setSubItems([
            MenuItem::linkToCrud('Liste Utlisateurs', 'fas fa-users', Users::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Users::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher', 'fas fa-plus', Users::class)->setAction(Crud::PAGE_DETAIL),
        ]);
        yield MenuItem::subMenu('Etablissements', 'fas fa-university')->setSubItems([
            MenuItem::linkToCrud('Liste établissements', 'fas fa-list', Etablissements::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Etablissements::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Types d\'enseign', 'fas fa-list', Enseignements::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Enseignements::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des Cycles', 'fas fa-list', Cycles::class),
            MenuItem::linkToCrud('Ajouter un Cycle', 'fas fa-plus', Cycles::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste Niveaux', 'fas fa-list', Niveaux::class),
            MenuItem::linkToCrud('Ajouter un Niveau', 'fas fa-plus', Niveaux::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des Classe', 'fas fa-list', Classes::class),
            MenuItem::linkToCrud('Ajouter une Classe', 'fas fa-plus', Classes::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::subMenu('Publications', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Liste les publications', 'fas fa-list', Publications::class),
            MenuItem::linkToCrud('Ajouter Publication', 'fas fa-plus', Publications::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Toutes les catégories', 'fas fa-list', Categories::class),
            MenuItem::linkToCrud('Ajouter une Catégorie', 'fas fa-plus', Categories::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comments::class);
    }
}