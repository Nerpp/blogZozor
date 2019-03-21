<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

// je dois determiner chaque use type
//la doc des formes pour le use https://symfony.com/doc/4.1/forms.html
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
     * 
     * @Route("/blog/new", name="blog_create")
     */

    public function create(){

        $article = new Article();

        // doc pour admnistrer les types https://symfony.com/doc/current/reference/forms/types.html
        // pour creer des formulaires facilements sur symfony
        $form = $this->createFormBuilder($article)
                        //on configure la forme
                        // je peu configurer les types simple input, text area etc doc : https://symfony.com/doc/current/reference/forms/types.html
                        //je peu ajouter un tableau d'option qui peut contenir un autre tableau d'option
                        ->add('title', TextType::class, [
                            'attr' => [
                                'placeholder' => "Titre de l'article"
                                // je rajoute la classe form-control dans un div
                                // 'class' => 'form-control'
                                //mais le layout bootstrap m'evite de le faire
                            ]     
                        ])
                        ->add('content', TextareaType::class,[
                            'attr' => [
                                'placeholder' => "Contenu de l'article"
                            ]
                        ])
                        ->add('image', TextType::class,[
                            'attr' => [
                                'placeholder' => "Image de l'article"
                            ]
                        ])
                        // Ajouter un bouton pour enregistrer en utilisant la statique SubmitType en le labellant Enregistrer
                        // Ne pas oublier le use pour la classe SubmitTypes
                        // ->add('save', SubmitType::class,[
                        //     'label' => 'Enregistrer'
                        // ])
                        //Si on veut ajouter ou modifier l'article vaut mieux creer un bouton sur le template create
                        // on envoit
                        ->getForm();

        // je passe a twig un tableau en plus de la route pour l'afficher
        return $this->render('blog/create.html.twig',[
            // je lui passe une variable form, mais seulement le resultat car $form contient la construction
            // la methode view va creer l'affichage
            'formArticle' => $form->createView()
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
