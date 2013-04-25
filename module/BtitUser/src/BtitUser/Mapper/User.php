<?php
namespace BtitUser\Mapper;

use Zend\Db\TableGateway\TableGateway;
use BtitUser\Entity\User as UserEntity;

class User extends AbstractDbMapper implements UserInterface
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function findByEmail($email)
    {
        $rowset = $this->tableGateway->select(array('email' => $email));
        return $rowset->current();
       
    }

    public function findByUsername($username)
    {
        $rowset = $this->tableGateway->select(array('username' => $username));
        return $rowset->current();
    }

    public function findById($id)
    {
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function insert(UserEntity $user)
    {   
        $userHydrator = $this->getServiceLocator()->get('btituser_user_hydrator');
        $this->tableGateway->insert($userHydrator->extract($user));
        $user->setId($this->tableGateway->getLastInsertValue());
        return $user;
    }

    public function update(UserEntity $user)
    {
        $userHydrator = $this->getServiceLocator()->get('btituser_user_hydrator');
        $this->tableGateway->update($userHydrator->extract($user), array('id' => $user->getId()));
    }
}    