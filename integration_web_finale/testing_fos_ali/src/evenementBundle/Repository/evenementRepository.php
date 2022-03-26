<?php

namespace evenementBundle\Repository;

/**
 * evenementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class evenementRepository extends \Doctrine\ORM\EntityRepository
{

    public function Deleteevenement($id){
        $query = $this->getEntityManager()
            ->createQuery("DELETE evenementBundle:evenement e
          where e.evenement=:id")->setParameter('id', $id);


        return $query->getResult();
    }

    public function findEntitiesByString($str)
    {
        /*$date_from = new \DateTime('now');
        ->setParameter('date_from', $date_from)
        ->andWhere('e.datedeb > = :date_form')*/

        return $this->getEntityManager()->createQuery(
            'SELECT p 
            FROM evenementBundle:evenement p
            WHERE p.titre LIKE :str
        ORDER BY p.titre ASC'
        )
            ->setParameter('str','%'.$str.'%')
            ->getResult();
    }

    public function Tri(){

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT q  FROM evenementBundle:evenement q order by q.datedebut ASC");
        $result= $query->execute();
        //$query = $this->getEntityManager()
        //->createQuery(" SELECT ReclamationBundle:reclamation e ORDER BY LOWER(status)");
        //return $query->getResult();
        return $result;
    }

}