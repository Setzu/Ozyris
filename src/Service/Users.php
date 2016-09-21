<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/16
 * Time: 16:50
 */

namespace Ozyris\Service;

class Users
{

    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $date_registration;
    protected $admin = false;

    /**
     * Users constructor.
     * @param array $aDonnees
     */
    public function __construct(array $aDonnees = array())
    {
        if (!empty($aDonnees)) {
            try {
                $this->hydrate($aDonnees);
            } catch(\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @param array $aUsers
     * @return $this
     * @throws \Exception
     */
    public function hydrate(array $aUsers = array())
    {
        foreach($aUsers as $attribut => $value) {

            $method = 'set' . ucfirst(strtolower($attribut));

            if (!method_exists($this, $method)) {
                throw new \Exception('La méthode set' . ucfirst(strtolower($attribut)) . ' n\'existe pas.');
            }

            $this->$method($value);
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getDateRegistration()
    {
        return $this->date_registration;
    }

    /**
     * @param mixed $date_registration
     */
    public function setDateRegistration($date_registration)
    {
        $this->date_registration = $date_registration;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }


}