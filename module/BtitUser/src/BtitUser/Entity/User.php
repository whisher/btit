<?php
namespace BtitUser\Entity;

use DateTime;
use DateTimeZone;
use Zend\Http\PhpEnvironment\RemoteAddress;

class User
{
    protected $id;
    protected $firstname;
    protected $surname;
    protected $username;
    protected $email;
    protected $password;
    protected $state;
    protected $role;
    protected $joinDatetime;
    protected $joinIp;
    protected $referrer;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }
    
    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

     public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = (int)$state;
        return $this;
    }
    
    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    
    public function getJoinDatetime()
    {
        if(null === $this->joinDatetime){
            //TODO Time zone
            $date = new \DateTime('now', new \DateTimeZone('Europe/Rome'));
            $this->joinDatetime = $date->format('Y-m-d H:i:s') ;
        }
        return $this->joinDatetime;
    }

    public function setJoinDatetime($joinDatetime)
    {
        $this->joinDatetime = $joinDatetime;
        return $this;
    }
    
    public function getJoinIp()
    {
        if(null === $this->joinIp){
            $remote = new RemoteAddress();
            $this->joinIp =  $remote->getIpAddress();
        }
        return $this->joinIp;
    }

    public function setJoinIp($ip)
    {
        $this->joinIp = $ip;
        return $this;
    }
    
    public function getReferrer()
    {
        if(null === $this->referrer){
            $this->referrer = (isset($_SERVER['HTTP_REFERRER']) && !empty($_SERVER['HTTP_REFERRER']))?$_SERVER['HTTP_REFERRER']:NULL;  
        }
        return $this->referrer;
    }

    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
        return $this;
    }
    
 }
