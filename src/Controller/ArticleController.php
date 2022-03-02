<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="admin_articles")
     */
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findAll();
        //dd($articles);
        

        return $this->render('admin/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/admin/articles/create", name="admin_articles_create")
     */
    public function create(Request $request)
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setUser($this->getUser());
            $article->setActive(false);
            $article->setIsBest(false);

            $infoIllustration = $form['illustration']->getData();
            $nomOldIllustration = $article->getIllustration();
            if($infoIllustration !== null){

                $cheminIllustration = $this->getParameter('articles_directory') . '/' . $nomOldIllustration;
                $extensionIllustration = $infoIllustration->guessExtension();
                $nomIllustration = time(). '-1.' . $extensionIllustration;
                $infoIllustration->move($this->getParameter('articles_directory'), $nomIllustration);
                $article->setIllustration($nomIllustration);
            } else {
                $article->setIllustration($nomOldIllustration);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('success', 'L\'article a bien été créé');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/articleForm.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/activer/{id}", name="admin_articles_activer")
     */
    public function activer(ArticlesRepository $articlesRepository, $id)
    {
        $article = $articlesRepository->find($id);
        $article->setActive(($article->getActive()) ? false : true );

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        return new Response('true');
    }

        /**
     * @Route("/admin/articles/isBest/{id}", name="admin_articles_isBest")
     */
    public function isBest(ArticlesRepository $articlesRepository, $id)
    {

        $article = $articlesRepository->find($id);
        
        $article->setIsBest(($article->getIsBest()) ? false : true );

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        return new Response('true');
    }

    /**
     * @Route("/admin/articles/update/{id}", name="admin_articles_update")
     */
    public function update(ArticlesRepository $articlesRepository, $id, Request $request)
    {
        $article = $articlesRepository->find($id);
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $infoIllustration = $form['illustration']->getData();
            $nomOldIllustration = $article->getIllustration();

            if($infoIllustration !== null){

                $cheminIllustration = $this->getParameter('articles_directory') . '/' . $nomOldIllustration;

                if(file_exists($cheminIllustration)){
                    unlink($cheminIllustration);
                }
                $extensionIllustration = $infoIllustration->guessExtension();
                $nomIllustration = time() . '-1.' . $extensionIllustration;
                $infoIllustration->move($this->getParameter('articles_directory'), $nomIllustration);
                $article->setIllustration($nomIllustration);
            } else {
                $article->setIllustration($nomOldIllustration);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('message', 'L\'article a bien été mis à jour');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/articleForm.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/delete/{id}", name="admin_articles_delete")
     */
    public function delete(ArticlesRepository $articlesRepository, $id)
    {
        $article = $articlesRepository->find($id);
        $nomIllustration = $article->getIllustration();

        if($nomIllustration !== null){
            $cheminIllustration = $this->getParameter('articles_directory') . '/' . $nomIllustration;
            if(file_exists($cheminIllustration)){
                unlink($cheminIllustration);
            }
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();
        $this->addFlash('message', 'L\'article a bien été supprimé');
        
        return $this->redirectToRoute('admin_articles');
    }
}
