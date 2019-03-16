<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * l'annotation Route
     * Quand le navigateur appellera mon site.com /blog
     * voici la fonction que tu dois appeler
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        //cela va retourner la vue du fichier template blog/index.html.twig
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
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
    * @Route("/blog/12", name="blog_show")
    */
    public function show()
    {
        return $this->render('blog/show.twig.html');
    }
}
