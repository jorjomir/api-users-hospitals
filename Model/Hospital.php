<?php

namespace Model;

class Hospital
{
    private $id;
    private $name;
    private $address;
    private $phone;

    const MANDATORY_HOSPITAL_COLUMNS = array(
        'name', 'address', 'phone'
    );
    const EMPLOYEES_METHOD_DELETE = "delete";
    const EMPLOYEES_METHOD_SAVE = "save";

    public function toArray()
    {
        $arr = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'address' => $this->getAddress(),
            'phone' => $this->getPhone(),
        );

        return $arr;
    }

    public function setAllData($data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['address'])) {
            $this->setAddress($data['address']);
        }
        if (isset($data['phone'])) {
            $this->setPhone($data['phone']);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


}