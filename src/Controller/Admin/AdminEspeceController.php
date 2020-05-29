<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Espece;
use App\Form\EspeceType;
use App\Repository\EspeceRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/espece", name="admin_espece_")
 */
class AdminEspeceController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param EspeceRepository $especeRepository
     * @return Response
     */
    public function index(EspeceRepository $especeRepository): Response
    {
        return $this->render('admin/espece/index.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'especes' => $especeRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $espece = new Espece();
        $form = $this->createForm(EspeceType::class, $espece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($espece);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Espèce ajoutée !'
            );

            return $this->redirectToRoute('admin_espece_index');
        }

        return $this->render('admin/espece/new.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'espece' => $espece,
            'form' => $form->createView(),
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
        return $this->render('admin/espece/show.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'parite' => $personneRepository->getPariteEspece($espece),
            'espece' => $espece,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Espece $espece
     * @return Response
     */
    public function edit(Request $request, Espece $espece): Response
    {
        $form = $this->createForm(EspeceType::class, $espece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Espèce modifiée !'
            );

            return $this->redirectToRoute('admin_espece_show', ['id' => $espece->getId()]);
        }

        return $this->render('admin/espece/edit.html.twig', [
            'page' => $this->getPage(),
            'adminPage' => $this->getAdminPage(),
            'espece' => $espece,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Espece $espece
     * @return Response
     */
    public function delete(Request $request, Espece $espece): Response
    {
        if (count($espece->getAnimaux()) == 0) {
            if ($this->isCsrfTokenValid('delete' . $espece->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($espece);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Espèce supprimée !'
                );
            }
        } else {
            $this->addFlash(
                'warning',
                'Il y a des animaux de cette espèce, vous ne pouvez pas la supprimer'
            );
        }

        return $this->redirectToRoute('admin_espece_index');
    }

    private function getPage(): string
    {
        return 'admin';
    }

    private function getAdminPage(): string
    {
        return 'espece';
    }
}
