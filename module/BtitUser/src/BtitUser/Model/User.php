<?php
namespace BtitBase\Model;

class User
{
    public $id;
    public $firstname;
    public $surname;
    public $email;
    public $password;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
        $this->surname  = (isset($data['surname'])) ? $data['surname'] : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
    }
}