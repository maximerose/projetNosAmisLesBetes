<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(AnimalRepository $animalRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $animaux = $paginator->paginate(
            $animalRepository->findAllQuery(),
            $request->query->getInt('page', 1),
            12
        );

        // TODO Recherche
        return $this->render('animal/index.html.twig', [
            'page' => $this->getPage(),
            'animaux' => $animaux,
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
