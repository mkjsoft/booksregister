<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookController extends AbstractController
{
    /**
     * @Route("/panel/book", name="book")
     */
    public function index(): Response
    {
        $bookList = $this->getDoctrine()
          ->getRepository(Book::class)
          ->findAll();

        return $this->render('book/index.html.twig', [
            'items' => $bookList,
        ]);
    }

    /**
     * @Route("/panel/book/add", name="book_add")
     */
    public function add(Request $request, ValidatorInterface $validator): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUser($this->getUser());
            $errors = $validator->validate($bookcase);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $this->entityManager->persist($book);
            $this->entityManager->flush($book);

            $this->addFlash('success', 'Changes have been saved!');

            return $this->redirectToRoute('book');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}