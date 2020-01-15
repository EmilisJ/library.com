<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Book;
use Faker\Factory;

class BookFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 200; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence($nbWords = rand(1,8), $variableNbWords = true));
            $book->setPages(rand(40,550));
            $book->setYear($faker->year($max = 'now'));
            $book->setDescription($faker->text($maxNbChars = 300));
            // for( $i = 0; $i < rand(1,3); $i++){
                $book->addAuthor(
                    $this->getReference('author'.rand(0,19))
                );
                $book->addAuthor(
                    $this->getReference('author'.rand(0,19))
                );
                $book->addAuthor(
                    $this->getReference('author'.rand(0,19))
                );
            // }
            $manager->persist($book);
            // $this->setReference('book'.$i, $book);
            }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3; 
    }
}
