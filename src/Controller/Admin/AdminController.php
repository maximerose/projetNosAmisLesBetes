<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage()
        ]);
    }

    private function getPage(): string
    {
        return 'admin';
    }

    private function getAdminPage(): string
    {
        return 'accueil';
    }
}
