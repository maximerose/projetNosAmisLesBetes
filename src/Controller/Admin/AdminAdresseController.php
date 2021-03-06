<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Search\AdresseSearch;
use App\Form\AdresseSearchType;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/adresse", name="admin_adresse_")
 */
class AdminAdresseController extends AbstractController
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

        return $this->render('admin/adresse/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'adresses' => $adresses,
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
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Adresse ajoutée !'
            );

            return $this->redirectToRoute('admin_adresse_index');
        }

        return $this->render('admin/adresse/new.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Adresse $adresse
     * @return Response
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('admin/adresse/show.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Adresse $adresse
     * @return Response
     */
    public function edit(Request $request, Adresse $adresse): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Adresse modifiée !'
            );

            return $this->redirectToRoute('admin_adresse_show', ['id' => $adresse->getId()]);
        }

        return $this->render('admin/adresse/edit.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Adresse $adresse
     * @return Response
     */
    public function delete(Request $request, Adresse $adresse): Response
    {
        if (count($adresse->getPersonnes()) === 0) {
            if ($this->isCsrfTokenValid('delete' . $adresse->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($adresse);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Adresse supprimée !'
                );
            }
        } else {
            $this->addFlash(
                'warning',
                'Il y a des personnes vivant à cette adresse, vous ne pouvez pas la supprimer'
            );
        }

        return $this->redirectToRoute('admin_adresse_index');
    }

    private function getPage(): string
    {
        return 'admin';
    }

    private function getAdminPage(): string
    {
        return 'adresse';
    }
}
