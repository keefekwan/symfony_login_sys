<?php
// src/Simple/ProfileBundle/DataFixtures/ORM/LoadUserDataFixtures.php

namespace Simple\ProfileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Simple\ProfileBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        var_dump('getting container here');
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
      $user1 = new User();
      $user1->setUsername("someuser");
      $user1->setSalt(md5(uniqid()));
      $encoder = $this->container
      	->get('security.encoder_factory')
      	->getEncoder($user1);
      $user1->setPassword($encoder->encodePassword('blue', $user1->getSalt()));
      $user1->setEmail("someuser@mail.ca");

      $manager->persist($user1);
      
      $user2 = new User();
      $user2->setUsername("johndoe");
      $user2->setSalt(md5(uniqid()));
      $encoder = $this->container
      ->get('security.encoder_factory')
      ->getEncoder($user2);
      $user2->setPassword($encoder->encodePassword('password', $user2->getSalt()));
      $user2->setEmail("johndoe@nowhere.com");
      
      $manager->persist($user2);

      $manager->flush();
    }
}