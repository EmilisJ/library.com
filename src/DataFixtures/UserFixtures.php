<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    private function getCred($credential){
        $dotenv = new Dotenv();
        $dotenv->load('/var/www/html/library.com/.env.local');
        return $_ENV[$credential];
    }

    public function load(ObjectManager $manager)   
    {
        $user = new User();
        $user->setEmail($this->getCred('EMAIL'));
        $user->setRoles(['ROLE_ADMIN']); 
        $user->setPassword($this->getCred('PASS'));
        $user->setName($this->getCred('NAME'));
        $user->setSurname($this->getCred('SURNAME'));
        $user->setCode($this->getCred('CODE'));
        
        $manager->persist($user);
        // $this->setReference('user'.$i, $user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1; 
    }
}