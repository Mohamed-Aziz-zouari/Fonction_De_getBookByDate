<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Author;
use App\Form\AuthType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController
{
    #[Route('/AddAuthor', name: 'add_author')]
    public function addauthor(ManagerRegistry $manager,Request $req): Response
    {
        $em=$manager->getManager();
         // $Auth1 -> setUsername("Joanne Rowling");
        // $Auth1 -> setEmail("JoanneRowling@gmail.com");
        

        // $Auth2 = new Author();
        // $Auth2 -> setUsername("Colleen Hoover");
        // $Auth2 -> setEmail("ColleenHoover@gmail.com");
        

        // $em -> persist($Auth1);
        // $em -> persist($Auth2);
        // $em -> flush();

        $author = new Author();
        $form = $this->createForm(AuthType::class,$author);
        $form->handleRequest($req);



        if($form->isSubmitted())
   
        {
   
       $em->persist($author);
   
       $em->flush();
   
       return $this->redirectToRoute('getallAuthors');
   
       }
       
        return $this->render('author/formAuthor.html.twig',[

            'f'=>$form->createView()
      
            ]);

    }

    #[Route('/Authors/getall', name: 'getallAuthors')]
    public function getallauthors(AuthorRepository $repository)
    {
        $Authors= $repository-> findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $Authors 
        ]);  
    }

    // #[Route('/updateAuthor/{id}',name:'update_author')]
    // public function updateauthor (AuthorRepository $repository,ManagerRegistry $manager,$id){
    //     $em=$manager->getManager();
    //     $upAuthor = $repository -> find($id);
    //     $upAuthor -> setUsername('j. k. rowling');
       
    //     $em -> flush();
    //     return new Response ('author updated');
    // }


    #[Route('/author/update/{id}',name:'app_author_update')]

        public function updateAuthor(Request $req, ManagerRegistry $manager ,Author $author

        ,AuthorRepository $repo){

          //$author = $repo->find($id);
          $em=$manager->getManager();
          $form = $this->createForm(AuthType::class,$author);

          $form->handleRequest($req);

          if($form->isSubmitted())

          {

          $em->flush();

          return $this->redirectToRoute('getallAuthors');

          }

          // $author->setName("author 1");

          //$author->setEmail("author1@gmail.com");

      

          return $this->render('author/formAuthor.html.twig',[

            'f'=>$form->createView()

          ]);

        }

    #[Route('/removeAuthor/{id}',name:'remove_author')]
    public function removeauthor (AuthorRepository $repository,ManagerRegistry $manager,$id){
        $em=$manager->getManager();
        $rmAuthor = $repository -> find($id);
        $em -> remove($rmAuthor);
       
        $em -> flush();
        return $this-> redirectToRoute('getallAuthors');
    }
}
