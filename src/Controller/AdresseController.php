<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Adresse;
use App\Repository\AdresseRepository;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adresse", name="adresse_")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param AdresseRepository $adresseRepository
     * @return Response
     */
    public function index(AdresseRepository $adresseRepository): Response
    {
        // TODO Paginer
        // TODO Recherche
        return $this->render('adresse/index.html.twig', [
            'page' => $this->getPage(),
            'adresses' => $adresseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Adresse $adresse
     * @return Response
     */
    public function show(Adresse $adresse, AnimalRepository $animalRepository): Response
    {
        return $this->render('adresse/show.html.twig', [
            'page' => $this->getPage(),
            'moyenneAge' => $animalRepository->getMoyenneAge($adresse),
            'adresse' => $adresse,
        ]);
    }

    private function getPage(): string
    {
        return 'adresse';
    }
}
