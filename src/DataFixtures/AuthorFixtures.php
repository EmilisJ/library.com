<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Author;
use Faker\Factory;

class AuthorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $author = new Author();
            $author->setName($faker->firstName);
            $author->setSurname($faker->lastName);
            // for( $i = 0; $i < rand(1,10); $i++){
            //     $author->addBook(
            //         $this->getReference('book'.rand(0,199))
            //     );
            // }
            $this->setReference('author'.$i, $author);
            $manager->persist($author);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2; 
    }
}
