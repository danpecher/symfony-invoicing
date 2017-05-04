<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ClientRepository extends EntityRepository
{
    public function findAllForUser($userId)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q->select('c')
          ->from('AppBundle:Client', 'c')
          ->where('c.user = :user_id')
          ->setParameters([
              'user_id' => $userId
          ]);

        return $q->getQuery()->getResult();
    }
}