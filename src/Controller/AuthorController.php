<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorController extends AbstractController
{
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/panel/author", name="author")
     */
    public function index(): Response
    {
        $authorList = $this->getDoctrine()
          ->getRepository(Author::class)
          ->findAll();

        return $this->render('author/index.html.twig', [
            'items' => $authorList,
        ]);
    }

    /**
     * @Route("/panel/author/add", name="author_add")
     */
    public function add(Request $request, ValidatorInterface $validator): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($author);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $this->entityManager->persist($author);
            $this->entityManager->flush($author);

            $this->addFlash('success', 'Changes have been saved!');

            return $this->redirectToRoute('author');
        }

        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/panel/author/edit/{id}", name="author_edit")
     */
    public function edit(int $id, Request $request, ValidatorInterface $validator): Response
    {
        $author = $this->entityManager->getRepository(Author::class)->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $id);
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($author);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $this->entityManager->persist($author);
            $this->entityManager->flush($author);

            $this->addFlash('success', 'Changes have been saved!');

            return $this->redirectToRoute('author');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/panel/author/delete/{id}", name="author_delete")
     */
    public function delete(int $id): Response
    {
        $author = $this->entityManager->getRepository(Author::class)->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $id);
        }

        $this->entityManager->remove($author);
        $this->entityManager->flush($author);

        $this->addFlash('success', 'Changes have been saved!');

        return $this->redirectToRoute('author');
    }

}