<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\Search\AnimalSearch;
use App\Form\AnimalSearchType;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/animal", name="admin_animal_")
 */
class AdminAnimalController extends AbstractController
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
        $search = new AnimalSearch();

        $form = $this->createForm(AnimalSearchType::class, $search);
        $form->handleRequest($request);

        $animaux = $paginator->paginate(
            $animalRepository->findAllQuery($search),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/animal/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'animaux' => $animaux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($animal);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Animal ajouté !'
            );
            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/new.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Animal $animal
     * @return Response
     */
    public function show(Animal $animal): Response
    {
        return $this->render('admin/animal/show.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'animal' => $animal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Animal $animal
     * @return Response
     */
    public function edit(Request $request, Animal $animal): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Animal modifié !'
            );
            return $this->redirectToRoute('admin_animal_show', ['id' => $animal->getId()]);
        }

        return $this->render('admin/animal/edit.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Animal $animal
     * @return Response
     */
    public function delete(Request $request, Animal $animal): Response
    {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($animal);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Animal supprimé !'
            );
        }

        return $this->redirectToRoute('admin_animal_index');
    }

    private function getPage(): string
    {
        return 'admin';
    }

    private function getAdminPage(): string
    {
        return 'animal';
    }
}
