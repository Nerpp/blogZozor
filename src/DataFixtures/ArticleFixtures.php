<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
// j'explique a php d'ou vient la classe Article
use App\Entity\Article;
//j'explique a php d'ou vient les Fakes
use App\Entity\Category;
//j'explique d'ou vient les comments a php
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3 categories fakées
        for ($i=0; $i <= 3 ; $i++) {
            # code...
            $category = new Category();

            // $faker->paragraphs() sur la doc est un tableau donc je vais le retyper en string
            $content =  '<p>' . join($faker->paragraphs(), '</p><p>') . '</p>';

            $category->setTitle($faker->sentence());
            $category->setDescription($content);

            // avant d'envoyer au flush j'initialise comme dans PDO
            $manager->persist($category);

        

            //Créer entre 4 et 6 articles
            for($j = 1; $j <= mt_rand(4,6); $j++) {
                    $article  = new Article();

                    // $faker->paragraphs(5) sur la doc est un tableau donc je vais le retyper en string
                   $content =  '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';


                    $article->setTitle($faker->sentence());
                    $article->setContent($content);
                    $article->setImage($faker->imageUrl());
                    $article->setCreatedAt($faker->dateTimeBetween('-6 months'));
                    $article->setCategory($category);

                // avant d'envoyer au flush j'initialise comme dans PDO
                $manager->persist($article);
            

            

            //on donne des commentaires à l'article pour cela que l'on debute la boucle de 1 pour commenter le premier article
            for ($k=1; $k <= mt_rand(4, 10); $k++) {
                # code...
                $comment = new Comment();

                // $faker->paragraphs(5) sur la doc est un tableau donc je vais le retyper en string
                $content =  '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                //j'adapte la date de creation du commentaire a la date de la creation de l'article
                $now = new \DateTime();
                $interval = $now->diff($article->getCreatedAt());
                $days = $interval->days;
                $minimum = '-' . $days . ' days'; //-100 days

                $comment->setAuthor($faker->name);
                $comment->setContent($content);
                $comment->setCreatedAt($faker->dateTimeBetween($minimum));
                $comment->setArticle($article);

                // avant d'envoyer au flush j'initialise comme dans PDO
                $manager->persist($comment);

            }

        }

    }

        
        // je balance dans mysql
        $manager->flush();
    }
}
