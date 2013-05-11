<?php
namespace BtitUser\Mapper;

use BtitUser\Entity\UserLogin as UserLoginEntity;

interface UserLoginInterface
{
   public function insert(UserLoginEntity $user);
}
