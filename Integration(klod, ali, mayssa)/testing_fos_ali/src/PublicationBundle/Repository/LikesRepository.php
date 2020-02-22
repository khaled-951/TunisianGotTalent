<?php

namespace PublicationBundle\Repository;

/**
 * LikesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LikesRepository extends \Doctrine\ORM\EntityRepository
{
    public function removePublicationLikes($idPublication)
    {
        $query = $this->getEntityManager()->createQuery(
            'DELETE PublicationBundle:Likes Likes
               WHERE Likes.Publication_id = :idPublication')
            ->setParameter("idPublication", $idPublication);

        $query->execute();
    }
}
