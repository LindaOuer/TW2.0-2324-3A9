<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{

    private $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
    );

    #[Route('/authorList', name: 'author_list')]
    public function list(): Response
    {
        return $this->render('author/list.html.twig', [
            'authors' => $this->authors,
        ]);
    }

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/author/{name}', name: 'author_show')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('authorDetails/{id}', name: 'author_details')]
    public function authorDetails($id): Response
    {
        return $this->render('author/details.html.twig', [
            'id' => $id,
            'authors' => $this->authors
        ]);
    }

    #[Route('/getAll', name: 'author_listDB')]
    public function getAll(AuthorRepository $repo): Response
    {
        $list = $repo->findAll(); /* Select * from Author */
        return $this->render('author/listDB.html.twig', [
            'authors' => $list
        ]);
    }

    #[Route('/getOne/{id}', name: 'author_getOne')]
    public function getAuthor(AuthorRepository $repo, $id): Response
    {
        $author = $repo->find($id);
        /* Select * from Author where id=$id */
        return $this->render('author/details.html.twig', [
            'author' => $author
        ]);
    }

    #[Route('/addAuthor', name: 'author_add')]
    public function addAuthor(ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();

        $author = new Author();
        $author->setEmail("author3@esprit.tn");
        $author->setUsername("author 3");

        $em->persist($author);
        $em->flush();
        return new Response("Author added");
    }
}
