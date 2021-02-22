<?php

namespace Model;

class User {
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $type;
    private $workplace_id;
    private $created_at;

    const MANDATORY_USER_COLUMNS = array(
        'email', 'first_name', 'last_name', 'type', 'workplace_id'
    );

    /*
    public function __construct($email, $first_name, $last_name, $type, $workplace_id, $id=null, $created_at=null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->type = $type;
        $this->workplace_id = $workplace_id;

        $timezone=new \DateTimeZone('Europe/Sofia');
        $this->created_at = new \DateTime('now', $timezone);
    }
    */

    public function toArray(){
        $arr = array(
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'type' => $this->getType(),
            'workplace_id' => $this->getWorkplaceId(),
            'created_at' => $this->getCreatedAt(),
        );

        return $arr;
    }

    public function setAllData($data) {
        if(isset($data['email'])) {
            $this->setEmail($data['email']);
        }
        if(isset($data['first_name'])) {
            $this->setFirstName($data['first_name']);
        }
        if(isset($data['last_name'])) {
            $this->setLastName($data['last_name']);
        }
        if(isset($data['type'])) {
            $this->setType($data['type']);
        }
        if(isset($data['workplace_id'])) {
            $this->setWorkplaceId($data['workplace_id']);
        }
        if(isset($data['id'])) {
            $this->setId($data['id']);
        }
        if(isset($data['created_at'])) {
            $this->setCreatedAt($data['created_at']);
        }

        return $this;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getWorkplaceId()
    {
        return $this->workplace_id;
    }

    /**
     * @param mixed $workplace_id
     */
    public function setWorkplaceId($workplace_id)
    {
        $this->workplace_id = $workplace_id;
    }

    /**
     * @return null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param null $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

}