<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne_index", methods={"GET"})
     * @param PersonneRepository $personneRepository
     * @return Response
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        return $this->render('personne/index.html.twig', [
            'page' => $this->getPage(),
            'personnes' => $personneRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    /**
     * @Route("/{id}", name="personne_show", methods={"GET"})
     * @param Personne $personne
     * @return Response
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'page' => $this->getPage(),
            'personne' => $personne,
        ]);
    }

    private function getPage(): string
    {
        return 'personne';
    }
}
