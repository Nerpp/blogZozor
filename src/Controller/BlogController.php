<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    /**
     * l'annotation Route
     * Quand le navigateur appellera mon site.com /blog
     * voici la fonction que tu dois appeler
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        // repo va appeler la fonction getDoctrine en utilisant la classe Artice en tant que statique
        // $repo = $this->getDoctrine()->getRepository(Article::class); n'est plus utile car je l'appelle dans la fonction index(ArticleRepository $repo)

        $articles = $repo->findAll();

        //cela va retourner la vue du fichier template blog/index.html.twig
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            // je passe a twig les articles trouvés
            'articles' => $articles
        ]);
    }

    /**
     * 
     * @Route("/", name="home")
     */
    public function home()
    {
        //le deuxieme parametre de la fonction render est un tableau avec la liste des variables que twig va utiliser
        return $this->render('blog/home.html.twig',[
            'title'=> 'Bienvenue sur le Blog de Zozor',
            'age' => 31
        ]);
    }

   /**
    * j'ecrit une route paramétré qui suivra l'id de l'article
    * @Route("/blog/{id}", name="blog_show")
    */
    public function show(Article $article)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //cette ligne est inutile car je l'ai injecter dans la fonction show(ArticleRepository $repo, $id)

        //$article = $repo->find($id);
        //je peu meme demander a Show de me charger l'id directement sans cette ligne grace au param converter https://symfony.com/doc/current/best_practices/controllers.html
        //que je recupere de src/Entity/Article.php voir mes use
        //Merci le service Container

        return $this->render('blog/show.html.twig' , [
            'article' => $article
        ]);
    }
}
