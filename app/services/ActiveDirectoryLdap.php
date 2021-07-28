<?php

namespace services;

use Adldap\Models\Model;
use Adldap\Models\User;
use Adldap\Query\Collection;
use configurators\AdLdapConfigurator;
use entities\UserResponse;
use exceptions\AdLdapException;
use query\AdLdapInsertBuilder;
use query\AdLdapQueryBuilder;

/**
 * Class ActiveDirectoryLdap
 * @package services
 */
class ActiveDirectoryLdap implements LdapServiceInterface
{
    
    const PHONE_ATTRIBUTE = 'extensionattribute14';
    const VIP_GROUP_NAME = 'VS';
    
    /**
     * @var \entities\AdLdap
     */
    protected $entity;
    
    /**
     * ActiveDirectoryLdap constructor.
     * @param AdLdapConfigurator $configurator
     */
    public function __construct(AdLdapConfigurator $configurator)
    {
        $this->entity = new \entities\AdLdap($configurator);
    }
    
    /**
     * @param $name
     * @return \Adldap\Models\Group|array|null
     * @throws \Adldap\AdldapException
     */
    protected function getGroup($name)
    {
        return $this->find()->groups()->where('name', '=', $name)->first();
    }
    
    /**
     * @param $login
     * @return \Adldap\Query\Builder
     * @throws \Adldap\AdldapException
     */
    protected function getUserQuery($login)
    {
        return $this->find()->users()->where('cn', '=', $login);
    }
    
    /**
     * @param $login
     * @return \Adldap\Models\User|array|null
     * @throws \Adldap\AdldapException
     */
    protected function getUser($login)
    {
        return $this->getUserQuery($login)->first();
    }

    /**
     * @param $login
     * @return UserResponse
     * @throws AdLdapException
     * @throws \Adldap\AdldapException
     */
    public function dataOfUser($login)
    {
        $user = $this->getUser($login);
        
        if (!$user) {
            AdLdapException::userNotFound($login);
        }
        $isVip = false;
        $group = $this->getGroup(self::VIP_GROUP_NAME);
        if ($group) {
            $isVip = in_array(self::VIP_GROUP_NAME, $user->getGroupNames(true));
        }
        if (!$user->getFirstAttribute(self::PHONE_ATTRIBUTE)) {
            AdLdapException::userPhoneNotFound($login);
        }
        
        return new UserResponse($login, $user->getFirstAttribute(self::PHONE_ATTRIBUTE), $isVip);
    }
    
    public function setPassword($login, $password)
    {
        /** @var User $user */
        $user = $this->getUser($login);
        if (!$user) {
            AdLdapException::userNotFound($login);
        }
    
        return $user->setPassword($password)->update();
    }
    
    /**
     * @param User $user
     * @param $groupDn
     * @return bool
     */
    protected static function inGroup(User $user, $groupDn)
    {
        var_dump($user->getMemberOf());
        return in_array($groupDn, $user->getMemberOf());
    }
    
    /**
     * @param $login
     * @return \Adldap\Models\User|array|null
     * @throws \Adldap\AdldapException
     */
    protected function getUserWithPhone($login)
    {
        return $this->getUserQuery($login)->whereHas(self::PHONE_ATTRIBUTE)->first();
    }
    
    /**
     * @return AdLdapQueryBuilder
     * @throws \Adldap\AdldapException
     */
    public function find()
    {
        return new AdLdapQueryBuilder($this->entity->findQuery());
    }
}