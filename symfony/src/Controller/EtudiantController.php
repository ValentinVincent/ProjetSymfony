<?php

namespace App\Controller;

use App\Entity\Etudiant;
use Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiant' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="account_show", methods={"GET"})
    //  */
    // public function show(Etudiant $etudiant): Response
    // {
    //     $debitsCredits = array_merge($account->getCreditTransactions()->toArray(), $account->getDebitTransactions()->toArray());
    //     return $this->render('account/show.html.twig', [
    //         'account' => $account,
    //         'debitsCredits' => $debitsCredits,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name="account_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Account $account): Response
    // {
    //     $form = $this->createForm(AccountType::class, $account);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('account_index');
    //     }

    //     return $this->render('account/edit.html.twig', [
    //         'account' => $account,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="account_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, Account $account): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$account->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($account);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('account_index');
    // }
}
