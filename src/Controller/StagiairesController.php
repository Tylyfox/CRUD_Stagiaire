<?php

namespace App\Controller;

use App\Entity\Stagiaires;
use App\Form\StagiairesType;
use App\Repository\StagiairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stagiaires")
 */
class StagiairesController extends AbstractController
{
    /**
     * @Route("/", name="app_stagiaires_index", methods={"GET"})
     */
    public function index(StagiairesRepository $stagiairesRepository): Response
    {
        return $this->render('stagiaires/index.html.twig', [
            'stagiaires' => $stagiairesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_stagiaires_new", methods={"GET", "POST"})
     */
    public function new(Request $request, StagiairesRepository $stagiairesRepository): Response
    {
        $stagiaire = new Stagiaires();
        $form = $this->createForm(StagiairesType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiairesRepository->add($stagiaire);
            return $this->redirectToRoute('app_stagiaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaires/new.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_stagiaires_show", methods={"GET"})
     */
    public function show(Stagiaires $stagiaire): Response
    {
        return $this->render('stagiaires/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_stagiaires_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Stagiaires $stagiaire, StagiairesRepository $stagiairesRepository): Response
    {
        $form = $this->createForm(StagiairesType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiairesRepository->add($stagiaire);
            return $this->redirectToRoute('app_stagiaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaires/edit.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_stagiaires_delete", methods={"POST"})
     */
    public function delete(Request $request, Stagiaires $stagiaire, StagiairesRepository $stagiairesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stagiaire->getId(), $request->request->get('_token'))) {
            $stagiairesRepository->remove($stagiaire);
        }

        return $this->redirectToRoute('app_stagiaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
