<?php

namespace SponsorsBundle\Repository;

use Symfony\Component\Validator\Constraints\Date;

/**
 * PackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PackRepository extends \Doctrine\ORM\EntityRepository
{
    public function  adsLeftQB(){

        $query=$this->getEntityManager()
            ->createQuery("SELECT count(p) FROM SponsorsBundle:Pack p WHERE p.position =:pos")
            ->setParameter('pos','Left');
        return $query->getSingleScalarResult();
    }
    public function  adsRightQB(){

        $query=$this->getEntityManager()
            ->createQuery("SELECT count(p) FROM SponsorsBundle:Pack p WHERE p.position =:pos")
            ->setParameter('pos','Right');
        return $query->getSingleScalarResult();
    }

    public function  editCurrentAdQB(){

        $query=$this->getEntityManager()
            ->createQuery("UPDATE SponsorsBundle:Pack p SET p.status=:stat WHERE CURRENT_DATE() BETWEEN p.displaydate AND p.discarddate")
            ->setParameter(':stat','Displaying')
            ->execute();

    }
    public function  editHistoryAdQB(){

        $query=$this->getEntityManager()
            ->createQuery("UPDATE SponsorsBundle:Pack p SET p.status=:stat WHERE CURRENT_DATE() > p.discarddate")
            ->setParameter(':stat','History')
            ->execute();

    }
    public function  editProgAdQB(){

        $query=$this->getEntityManager()
            ->createQuery("UPDATE SponsorsBundle:Pack p SET p.status=:stat WHERE CURRENT_DATE() < p.displaydate")
            ->setParameter(':stat','Programmed')
            ->execute();

    }
}
