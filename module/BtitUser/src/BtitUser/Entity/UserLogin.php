<?php
namespace BtitUser\Entity;

use DateTime;
use DateTimeZone;
use Zend\Http\PhpEnvironment\RemoteAddress;

class UserLogin
{
    protected $id;
    protected $userId;
    protected $loginDatetime;
    protected $loginIp;
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
    
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($id)
    {
        $this->userId = (int) $id;
        return $this;
    }

    public function getLoginDatetime()
    {
        if(null === $this->loginDatetime){
            //TODO Time zone
            $date = new \DateTime('now', new \DateTimeZone('Europe/Rome'));
            $this->loginDatetime = $date->format('Y-m-d H:i:s') ;
        }
        return $this->loginDatetime;
    }

    public function setLoginDatetime($loginDatetime)
    {
        $this->loginDatetime = $loginDatetime;
        return $this;
    }
    
    public function getLoginIp()
    {
        if(null === $this->loginIp){
            $remote = new RemoteAddress();
            $this->loginIp =  $remote->getIpAddress();
        }
        return $this->loginIp;
    }

    public function setLoginIp($ip)
    {
        $this->loginIp = $ip;
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
