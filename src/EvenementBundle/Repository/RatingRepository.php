<?php

namespace EvenementBundle\Repository;
use Doctrine\ORM\EntityRepository;
/**
 * RatingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RatingRepository extends EntityRepository
{
    public function avgrating()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT c.idE , AVG(c.rating) AS avgrating FROM EvenementBundle:Rating c
             GROUP BY c.idE  "
        );
        return $query->getResult();

    }
}