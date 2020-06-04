<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Search\PersonneSearch;
use App\Form\PersonneSearchType;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PersonneRepository $personneRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PersonneSearch();

        $form = $this->createForm(PersonneSearchType::class, $search);
        $form->handleRequest($request);

        $personnes = $paginator->paginate(
            $personneRepository->findAllQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('personne/index.html.twig', [
            'page' => $this->getPage(),
            'personnes' => $personnes,
            'form' => $form->createView(),
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
