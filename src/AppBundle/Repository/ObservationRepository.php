<?php

namespace AppBundle\Repository;

/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    //Mes observation
    public function  getObervationByUserId($user_id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->andwhere('o.isValidate=:values')
            ->setParameter('user',$user_id)
            ->setParameter('values',1);

        return $qb->getQuery()->getResult();
    }

    //Mes observation en attente
    public function  getObervationEnAttenteByUserId($user_id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->andwhere('o.isValidate=:values')
            ->setParameter('user',$user_id)
            ->setParameter('values',0);

        return $qb->getQuery()->getResult();
    }

    //Mes observation refusés
    public function  getObervationRefuserByUserId($user_id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->andwhere('o.isValidate=:values')
            ->setParameter('user',$user_id)
            ->setParameter('values',2);

        return $qb->getQuery()->getResult();
    }

    //Les dernières observation
    public function getLastObservation()
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.isValidate= :isvalide')
            ->setParameter('isvalide', 1);
        return $qb->getQuery()->getResult();
    }

    //Mes observation à valider
    public function getObservationAvalider()
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.isValidate= :isvalide')
            ->setParameter('isvalide', 0);
        return $qb->getQuery()->getResult();
    }

    //Mes observations  validés
    public function getObservationValiderByUserId($id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->andWhere('o.isValidate= :isvalide')
            ->setParameter('isvalide', 1)
            ->setParameter('user', $id);

        return $qb->getQuery()->getResult();
    }

    //Mes observations  refusés
    public function getObservationRefuserByUserId($id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->andWhere('o.isValidate= :isvalide')
            ->setParameter('isvalide', 2)
            ->setParameter('user', $id);

        return $qb->getQuery()->getResult();
    }

    //Requette pour avoir les observation rattaché  à un user selon id
    //Mes observation
    public function  getAllObervationByUserId($user_id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user = :user')
            ->setParameter('user',$user_id);

        return $qb->getQuery()->getResult();
    }
}
