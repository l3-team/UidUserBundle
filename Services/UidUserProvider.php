<?php

namespace L3\Bundle\UidUserBundle\Services;

use L3\Bundle\UidUserBundle\Entity\UidUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UidUserProvider implements UserProviderInterface {

    public function __construct() {}

    public function loadUserByIdentifier($identifier): UserInterface {
        $user = new UidUser();
        $user->setUid($identifier);
        $roles = Array();
        if ($identifier === '__NO_USER__') {
            $roles = array('ROLE_ANON');
        } else {
            $roles = array('ROLE_ANON', 'ROLE_USER');
        }
        $user->updateRoles($roles);
        return $user;
    }

    public function refreshUser(UserInterface $user) {
        if(!$user instanceof UidUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUid());
    }

    public function supportsClass($class) {
        return UidUser::class === $class;
    }
} 
