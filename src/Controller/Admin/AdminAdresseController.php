<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
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
     * @return Response
     */
    public function index(AdresseRepository $adresseRepository): Response
    {
        return $this->render('admin/adresse/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'adresses' => $adresseRepository->findAll(),
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
        if ($this->isCsrfTokenValid('delete' . $adresse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adresse);
            $entityManager->flush();
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
