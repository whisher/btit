<?php
namespace BtitUser\Mapper;

use Zend\Db\TableGateway\TableGateway;
use BtitUser\Entity\UserLogin as UserLoginEntity;

class UserLogin extends AbstractDbMapper implements UserLoginInterface
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function insert(UserLoginEntity $user)
    {   
        $userHydrator = $this->getServiceLocator()->get('btituser_userlogin_hydrator');
        $this->tableGateway->insert($userHydrator->extract($user));
        $user->setId($this->tableGateway->getLastInsertValue());
        return $user;
    }

    
}    