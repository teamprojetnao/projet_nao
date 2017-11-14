<?php

namespace AppBundle\Repository;

/**
 * AvesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AvesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAvesByString($str){
        $qb = $this->createQueryBuilder('e');
        $qb->select('CONCAT(e.nomscientifique, \' - \',e.nomvernaculaire) as value, CONCAT(e.nomscientifique, \' - \',e.nomvernaculaire) as label')
            ->where('e.nomvernaculaire LIKE :str')
            ->orWhere('e.nomscientifique LIKE :str')

            ->setParameter('str', '%'.$str.'%');
        return $qb ->getQuery()->getArrayResult();
    }




}
