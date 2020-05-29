<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Espece;
use App\Repository\EspeceRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/espece", name="espece_")
 */
class EspeceController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param EspeceRepository $especeRepository
     * @return Response
     */
    public function index(EspeceRepository $especeRepository): Response
    {
        // TODO Paginer
        // TODO Recherche
        return $this->render('espece/index.html.twig', [
            'page' => $this->getPage(),
            'especes' => $especeRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Espece $espece
     * @param PersonneRepository $personneRepository
     * @return Response
     */
    public function show(Espece $espece, PersonneRepository $personneRepository): Response
    {
        return $this->render('espece/show.html.twig', [
            'page' => $this->getPage(),
            'parite' => $personneRepository->getPariteEspece($espece),
            'espece' => $espece,
        ]);
    }

    private function getPage(): string
    {
        return 'espece';
    }
}
