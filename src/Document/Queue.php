<?php
namespace App\Document;
use App\Repository\QueueRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="queues", repositoryClass=QueueRepository::class)
 * @MongoDB\HasLifecycleCallbacks
 */
class Queue
{
    /**
     * @MongoDB\Id
     */
    protected $_id;
    
    
    /**
     * @MongoDB\Field(name="email", type="string")
     */
    protected $email;
    
    /**
     * @MongoDB\Field(name="createdAt", type="date")
     *
     */
    protected $createdAt;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $_id
     */
    public function setId($_id)
    {
        $this->_id = $_id;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}

