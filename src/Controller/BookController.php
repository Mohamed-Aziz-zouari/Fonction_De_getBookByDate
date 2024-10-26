<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BookType;
use App\Form\DateBookType;
class BookController extends AbstractController
{
    // #[Route('/Addbook', name: 'add_book')]
    // public function addBook(ManagerRegistry $manager , AuthorRepository $repository): Response
    // {
    //     $em=$manager->getManager();
    //     $author = $repository -> find(4);

    //     $book2 = new Book();
    //     $book2 -> setTitle("it ends with us");
    //     $book2 -> setPublicationDate("2016");
    //     $book2 -> setEnabled(true);
    //     $book2 -> setAuthor($author);

        
    //     $em -> persist($book2);
    //     $em -> flush();
    //     return new Response('book added',200);

    // }



    #[Route('/Addbook', name: 'add_book')]
    public function addBook(ManagerRegistry $manager , AuthorRepository $repository,Request $req): Response
    {
        $em=$manager->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);



        if($form->isSubmitted())
   
        {
   
       $em->persist($book);
   
       $em->flush();
   
       return $this->redirectToRoute('getallBooks');
   
       }
       
        return $this->render('book/formBook.html.twig',[

            'f'=>$form->createView()
      
            ]);
    }

    #[Route('/Books/getall', name: 'getallBooks')]
    public function getallStudent(BookRepository $repository)
    {

        $Books= $repository-> findAll();
        return $this->render('book/index.html.twig', [
            'books' => $Books 
        ]);  
    }

    #[Route('/BooksByDate', name: 'BooksBydate')]
    public function getBookByDate(BookRepository $repository,Request $req)
    {
        $form = $this->createForm(DateBookType::class);
        $form->handleRequest($req);
        
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $startDate = $data['start_date'];
            $endDate = $data['end_date'];
    
            
            $Books = $repository->getBooksByDate($startDate, $endDate);
            return $this->render('book/getBookByDate.html.twig', [
                'f' => $form->createView(),
                'books' => $Books,
            ]);
        }
    
       

        $Books= $repository-> findAll();
        return $this->render('book/getBookByDate.html.twig',[

            'f'=>$form->createView(),'books' => $Books 
      
            ]);
    }

    // #[Route('/updateBook/{id}',name:'update_book')]
    // public function updateBook (BookRepository $repository,ManagerRegistry $manager,$id){
    //     $em=$manager->getManager();
    //     $upBook = $repository -> find($id);
    //     $upBook -> setTitle('it Starts with us ');
       
    //     $em -> flush();
    //     return new Response ('book updated');
    // }

    #[Route('/updateBook/{id}',name:'update_book')]
    public function updateBook (BookRepository $repository,ManagerRegistry $manager,Book $book ,Request $req ){
        $em=$manager->getManager();
        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($req);

        if($form->isSubmitted())

        {

        $em->flush();

        return $this->redirectToRoute('getallBooks');

        }
        return $this->render('book/formBook.html.twig',[

            'f'=>$form->createView()
      
            ]);
    }

    #[Route('/removeBook/{id}',name:'remove_book')]
    public function removeBook (BookRepository $repository,ManagerRegistry $manager,$id){
        $em=$manager->getManager();
        $rmBook = $repository -> find($id);
        $em -> remove($rmBook);
       
        $em -> flush();
        return $this-> redirectToRoute('getallBooks');
    }
}
