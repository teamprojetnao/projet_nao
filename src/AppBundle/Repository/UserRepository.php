<?php

namespace AppBundle\Repository;
use AppBundle\AppBundle;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public  function findNaturalists()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%'.'ROLE_NATURALIST'.'%');
        return $qb ->getQuery()->getArrayResult();
    }

    public  function findUsers()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%'.'ROLE_USER'.'%');
        return $qb ->getQuery()->getArrayResult();
    }

    public function countNaturalists()
    {
        $qb=$this->createQueryBuilder('u')
          
            ->select('COUNT(u)')
            ->where ('u.roles LIKE :roles')
            ->setParameter('roles', '%'.'ROLE_NATURALIST'.'%');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countUsers()
    {
        $qb=$this->createQueryBuilder('u')
            ->select('COUNT(u)')

            ->where ('u.roles LIKE :roles')
            ->setParameter('roles', '%'.'ROLE_USER'.'%');



        return $qb->getQuery()->getSingleScalarResult();

    }

   public function countIsNaturalistRequired()
    {
        $qb=$this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where ('u.isNaturalistRequired = 1');

        return $qb->getQuery()->getSingleScalarResult();

    }
}
