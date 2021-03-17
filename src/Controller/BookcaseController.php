<?php

namespace App\Controller;

use App\Entity\Bookcase;
use App\Form\BookcaseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookcaseController extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/bookcase", name="bookcase")
     */
    public function index(): Response
    {
        $bookcaseList = $this->getDoctrine()
          ->getRepository(Bookcase::class)
          ->findAll();

        return $this->render('bookcase/index.html.twig', [
            'items' => $bookcaseList,
        ]);
    }

    /**
     * @Route("/bookcase/add", name="bookcase_add")
     */
    public function add(Request $request, ValidatorInterface $validator): Response
    {
        $bookcase = new Bookcase();
        $form = $this->createForm(BookcaseType::class, $bookcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($bookcase);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $this->entityManager->persist($bookcase);
            $this->entityManager->flush($bookcase);

            $this->addFlash('success', 'Changes have been saved!');

            return $this->redirectToRoute('bookcase');
        }

        return $this->render('bookcase/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bookcase/edit/{id}", name="bookcase_edit")
     */
    public function edit(int $id, Request $request, ValidatorInterface $validator): Response
    {
        $bookcase = $this->entityManager->getRepository(Bookcase::class)->find($id);
        if (!$bookcase) {
            throw $this->createNotFoundException('No bookcase found for id ' . $id);
        }

        $form = $this->createForm(BookcaseType::class, $bookcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($bookcase);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $this->entityManager->persist($bookcase);
            $this->entityManager->flush($bookcase);

            $this->addFlash('success', 'Changes have been saved!');

            return $this->redirectToRoute('bookcase');
        }

        return $this->render('bookcase/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bookcase/delete/{id}", name="bookcase_delete")
     */
    public function delete(int $id): Response
    {
        $bookcase = $this->entityManager->getRepository(Bookcase::class)->find($id);
        if (!$bookcase) {
            throw $this->createNotFoundException('No bookcase found for id ' . $id);
        }

        $this->entityManager->remove($bookcase);
        $this->entityManager->flush($bookcase);

        $this->addFlash('success', 'Changes have been saved!');
        
        return $this->redirectToRoute('bookcase');
    }

}