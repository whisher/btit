<?php
namespace BtitUser\Mapper;

use BtitUser\Entity\User as UserEntity;

interface UserInterface
{
    public function findByEmail($email);

    public function findByUsername($username);

    public function findById($id);

    public function insert(UserEntity $user);

    public function update(UserEntity $user);
}
