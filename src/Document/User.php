<?php

namespace App\Document;

use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use DateTime;
/**
 * @MongoDB\Document(collection="users", repositoryClass=UserRepository::class)
 * @MongoDB\HasLifecycleCallbacks
 */
class User{
    /**
     * @MongoDB\Id
     */
    protected $_id;
    
    /**
     * @MongoDB\Field(name="username", type="string")
     */
    protected $username;

    /**
     * @MongoDB\Field(name="phone", type="string")
     */
    protected $phone;

    /**
     * @MongoDB\Field(name="address", type="string")
     */
    protected $address;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
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
        return clone $this->createdAt;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = clone $createdAt;
    }
}
?>