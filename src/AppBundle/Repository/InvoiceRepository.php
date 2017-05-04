<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class InvoiceRepository extends EntityRepository
{
    public function findAllForUser($userId)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q->select('i')
          ->from('AppBundle:Invoice', 'i')
          ->where('i.user = :user_id')
          ->setParameters([
              'user_id' => $userId
          ]);

        return $q->getQuery()->getResult();
    }
}