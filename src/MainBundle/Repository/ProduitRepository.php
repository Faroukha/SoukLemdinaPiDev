<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProduitRepository
 * @package MainBundle\Repository
 */
class ProduitRepository extends EntityRepository
{
    public function findPromoted()
    {

        $q = $this->getEntityManager()->createQuery("SELECT
    p.categorie,p.titre,p.prix,p.image,pp.taux  
FROM
     produit AS p , promotion AS pp
JOIN promotion pp ON 
    pp.idProduit = p.id 
WHERE p.id IN (
SELECT id FROM promotion
)");
        return $q->getResult();
    }



}