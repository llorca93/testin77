<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticlesCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/actualites", name="blog")
     */
    public function index(ArticlesRepository $articlesRepository, ArticlesCategoryRepository $articlesCategoryRepository, Request $request): Response
    {
        // on définit le nombre d'éléments par page
        $limit = 4;

        // on récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // on récupère les filtres
        $filters = $request->get('category');
        
        $articleBest = $articlesRepository->findOneBy(['isBest' => true]);
        
        // on récupère les articles de la page en fonction du filtre
        $articles = $articlesRepository->getPaginatedArticles($page, $limit, $filters);
        

        // on récupère le nombre total d'articles
        $total = $articlesRepository->getTotalArticles($filters);
        
        //$articles = $articlesRepository->findBy(['active' => true], ['createdAt' => 'desc'],4);
        //dd($articles);
        $categories = $articlesCategoryRepository->findAll();

        // on vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('blog/_content.html.twig', compact('articleBest', 'articles', 'total', 'limit', 'page'))
            ]);
        }
        

        

        return $this->render('blog/index.html.twig', compact('articleBest', 'articles', 'categories', 'total', 'limit', 'page'));
    }

    /**
     * @Route("/actualites/detail/{slug}", name="actualites_detail")
     */
    public function detail(ArticlesRepository $articlesRepository, ArticlesCategoryRepository $articlesCategoryRepository, $slug)
    {
        $article = $articlesRepository->findOneBy(['slug' => $slug]);
        $categories = $articlesCategoryRepository->findAll();
        

        return $this->render('blog/detail.html.twig', [
            'article' => $article,
            'categories' => $categories
        ]);
    }
}
