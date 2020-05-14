<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/animal", name="animal_")
 */
class AnimalController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param AnimalRepository $animalRepository
     * @return Response
     */
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'page' => $this->getPage(),
            'animaux' => $animalRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Animal $animal
     * @return Response
     */
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'page' => $this->getPage(),
            'animal' => $animal,
        ]);
    }

    private function getPage(): string
    {
        return 'animal';
    }
}
