<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/adresse", name="admin_adresse_")
 */
class AdminAdresseController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/admin_adresse/index.html.twig', [
            'controller_name' => 'AdminAdresseController',
        ]);
    }
}
