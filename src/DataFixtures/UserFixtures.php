<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)   
    {
        $user = new User();
        $user->setEmail($this->container->getParameter('fixture_email'));
        $user->setRoles(['ROLE_ADMIN']); 
        $user->setPassword($this->container->getParameter('fixture_password'));
        $user->setName($this->container->getParameter('fixture_name'));
        $user->setSurname($this->container->getParameter('fixture_surname'));
        $user->setCode($this->container->getParameter('fixture_code'));
        
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1; 
    }
}