<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Search\AdresseSearch;
use App\Form\AdresseSearchType;
use App\Repository\AdresseRepository;
use App\Repository\AnimalRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(AdresseRepository $adresseRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new AdresseSearch();

        $form = $this->createForm(AdresseSearchType::class, $search);
        $form->handleRequest($request);

        $adresses = $paginator->paginate(
            $adresseRepository->findAllQuery($search),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('adresse/index.html.twig', [
            'page' => $this->getPage(),
            'adresses' => $adresses,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Adresse $adresse
     * @param AnimalRepository $animalRepository
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
