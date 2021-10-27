<?php 

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class UserRepository extends DocumentRepository{
    
    public function findAll() : array{
        return $this->createQueryBuilder('users')
            ->sort('username','desc')
            ->getQuery()
            ->execute()
            ->toArray();
    }
    
    public function findOneByProperty($field, $data){
        return $this->createQueryBuilder('users')
            ->field($field)->equals($data)
            ->getQuery()
            ->getSingleResult();
    }
    
}
?>