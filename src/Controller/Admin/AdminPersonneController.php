<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Personne;
use App\Form\PersonneEditType;
use App\Form\PersonneNewType;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/personne", name="admin_personne_")
 */
class AdminPersonneController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param PersonneRepository $personneRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PersonneRepository $personneRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $personnes = $paginator->paginate(
            $personneRepository->findAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        // TODO Recherche
        return $this->render('admin/personne/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'personnes' => $personnes,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneNewType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Personne ajoutée !'
            );

            return $this->redirectToRoute('admin_personne_index');
        }

        return $this->render('admin/personne/new.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Personne $personne
     * @return Response
     */
    public function show(Personne $personne): Response
    {
        return $this->render('admin/personne/show.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Personne $personne
     * @return Response
     */
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(PersonneEditType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Personne modifiée !'
            );

            return $this->redirectToRoute('admin_personne_show', ['id' => $personne->getId()]);
        }

        return $this->render('admin/personne/edit.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Personne $personne
     * @return Response
     */
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Personne supprimée !'
            );
        }

        return $this->redirectToRoute('admin_personne_index');
    }

    private function getPage(): string
    {
        return 'admin';
    }

    private function getAdminPage(): string
    {
        return 'personne';
    }
}
