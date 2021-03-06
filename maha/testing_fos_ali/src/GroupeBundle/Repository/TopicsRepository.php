<?php

namespace GroupeBundle\Repository;

/**
 * TopicsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TopicsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findTopic($groupe_id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT t FROM GroupeBundle:Topics t where t.groupe = :groupe_id")
            ->setParameter('groupe_id', $groupe_id);
        return $query->getResult();
    }
}
