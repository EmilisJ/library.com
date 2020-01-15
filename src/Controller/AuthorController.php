<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Service\FileUploader;

class AuthorController extends AbstractController
{
    
    public function index(AuthorRepository $authorRepository): Response
    {
        if(isset($_GET['val'])){
            if($_GET['val'] == 'sa'){
                $value = [ 'authors' => $authorRepository->sortBySurnameASC() ];
            } elseif($_GET['val'] == 'sd'){
                $value = [ 'authors' => $authorRepository->sortBySurnameDESC() ];
            } 
        } else{
            $value = [ 'authors' => $authorRepository->findAll() ];
        }
        return $this->render('author/index.html.twig', $value);
    }

    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $photoFile = $form['photo']->getData();
            if ($photoFile) {
                $photoFileName = $fileUploader->upload($photoFile);
                $author->setPhotoFilename($photoFileName);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    public function show(Author $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    public function edit(Request $request, Author $author, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form['photo']->getData();
            if ($photoFile) {
                $photoFileName = $fileUploader->upload($photoFile);
                $author->setPhotoFilename($photoFileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }
    
    public function delete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($author);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('author_index');
    }
}
