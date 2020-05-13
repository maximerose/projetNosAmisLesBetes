<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/personne", name="admin_personne_")
 */
class AdminPersonneController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/admin_personne/index.html.twig', [
            'controller_name' => 'AdminPersonneController',
        ]);
    }
}
