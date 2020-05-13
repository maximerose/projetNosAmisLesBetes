<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/espece", name="admin_espece_")
 */
class AdminEspeceController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/admin_espece/index.html.twig', [
            'controller_name' => 'AdminEspeceController',
        ]);
    }
}
