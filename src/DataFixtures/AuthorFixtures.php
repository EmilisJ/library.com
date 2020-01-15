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
            $author->setPhotoFileName( [
                    '1-5e1efef8c7a9b.jpeg',
                    '2-5e1ef45fad6e6.jpeg',
                    '3-5e1ef48ac2922.jpeg'
                ][rand(0,2)]
            );
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
