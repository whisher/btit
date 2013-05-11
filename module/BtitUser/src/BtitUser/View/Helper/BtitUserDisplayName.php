<?php

namespace BtitUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use BtitUser\Entity\User;

class BtitUserDisplayName extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * __invoke
     *
     * @access public
     * @param \ZfcUser\Entity\UserInterface $user
     * @throws \ZfcUser\Exception\DomainException
     * @return String
     */
    public function __invoke(User $user = null)
    {
        if (null === $user) {
            if ($this->getAuthService()->hasIdentity()) {
                $user = $this->getAuthService()->getIdentity();
                if (!$user instanceof User) {
                    throw new BtitUser\Exception\DomainException(
                        '$user is not an instance of User', 500
                    );
                }
            } else {
                return false;
            }
        }
        $displayName = $user->getUsername();
        if (null === $displayName) {
             $displayName = $user->getFirstname().' '.$user->getSurname();
        }
        return $displayName;
    }

    public function getAuthService()
    {
        return $this->authService;
    }

    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
}
