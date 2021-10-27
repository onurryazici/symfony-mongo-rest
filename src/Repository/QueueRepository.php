<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class QueueRepository extends DocumentRepository{
    
    public function findAll() : array{
        return $this->createQueryBuilder('queues')
        ->sort('email','desc')
        ->getQuery()
        ->execute()
        ->toArray();
    }
    
    public function findOneByProperty($field, $data){
        return $this->createQueryBuilder('queues')
        ->field($field)->equals($data)
        ->getQuery()
        ->getSingleResult();
    }
    
    public function findExpiredQueues(){
        /* $timeBefore24HoursAgo  = new \DateTime(date('Y-m-d H:i:s',\time() - 24 * 60 * 60));
        return $this->createQueryBuilder('queues')
        ->field("createdAt")->gte($timeBefore24HoursAgo)
        ->getQuery()
        ->execute();*/

        $timeBefore5MinutesAgo  = new \DateTime(date('Y-m-d H:i:s',\time() - 5 * 60));
        return $this->createQueryBuilder('queues')
        ->field("createdAt")->lte($timeBefore5MinutesAgo)
        ->getQuery()
        ->execute();
    }




    
}
?>