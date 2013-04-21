<?php
namespace BtitBase\Model;

use Zend\Db\TableGateway\TableGateway;
/*
 * public function findByEmail($email);

    public function findByUsername($username);

    public function findById($id);

    public function insert($user);

    public function update($user);
 */
class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getById($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function save(User $user)
    {
        $data = array(
            'firstname' => $user->firstname,
            'surname'  => $user->surname,
            'email'  => $user->email,
            'password'  => $user->password,
        );

        $id = (int)$user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
}    