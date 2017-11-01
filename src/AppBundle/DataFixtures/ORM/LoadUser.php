<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 31/10/2017
 * Time: 17:56
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setPrenom('Anne');
        $admin->setEmail('admin@gmail.com');
        $admin->setNom('D');
        $admin->setPseudo('Anne');
        $admin->setPassword('admin');
        $admin->setBirthdate(new \DateTime('1976-12-04'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setCgu('true');
        $admin->setStatus('1');
        $manager->persist($admin);

        $naturalist = new User();
        $naturalist->setPrenom('Anne');
        $naturalist->setEmail('naturalist@gmail.com');
        $naturalist->setNom('D');
        $naturalist->setPseudo('Anne');
        $naturalist->setPassword('naturalist');
        $naturalist->setBirthdate(new \DateTime('1976-12-04'));
        $naturalist->setRoles(array('ROLE_NATURALIST'));
        $naturalist->setCgu('true');
        $naturalist->setStatus('2');
        $manager->persist($naturalist);

        $user = new User();
        $user->setPrenom('Anne');
        $user->setEmail('user@gmail.com');
        $user->setNom('D');
        $user->setPseudo('Anne');
        $user->setPassword('user');
        $user->setBirthdate(new \DateTime('1976-12-04'));
        $user->setRoles(array('ROLE_USER'));
        $user->setCgu('true');
        $user->setStatus('1');
        $manager->persist($user);

        $manager->flush();


    }
}