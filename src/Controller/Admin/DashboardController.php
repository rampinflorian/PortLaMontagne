<?php

namespace App\Controller\Admin;

use App\Entity\Area;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Site;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PortLaMontagne');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Article', 'icon class', Article::class);
        yield MenuItem::linkToCrud('Area', 'icon class', Area::class);
        yield MenuItem::linkToCrud('Category', 'icon class', Category::class);
        yield MenuItem::linkToCrud('Site', 'icon class', Site::class);
        yield MenuItem::linkToCrud('User', 'icon class', User::class);
    }
}
