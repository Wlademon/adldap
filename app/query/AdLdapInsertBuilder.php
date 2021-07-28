<?php

namespace query;

use Adldap\Models\Entry;
use exceptions\ADLdapQueryException;

/**
 * Class AdLdapInsertBuilder
 *
 * @mixin Entry
 *
 * @package query
 */
class AdLdapInsertBuilder
{
    protected $model;
    
    /**
     * AdLdapInsertBuilder constructor.
     * @param Entry $factory
     */
    public function __construct(Entry $factory)
    {
        $this->model = $factory;
    }
    
    /**
     * @param string $name
     * @param array $arguments
     * @return $this|false|mixed
     * @throws ADLdapQueryException
     */
    public function __call(string $name, array $arguments)
    {
        try {
            $result = call_user_func_array([$this->model, $name], $arguments);
            if ($result instanceof Entry) {
                $this->model = $result;
            
                return $this;
            }
        
            return $result;
        } catch (\Throwable $throwable) {
            throw (new ADLdapQueryException($throwable->getMessage()))->setEntity($this->model)->setException($throwable);
        }
    }
    
    /**
     * @return Entry
     */
    public function getModelEntity()
    {
        return $this->model;
    }
    
    /**
     * @param $cn
     * @return $this
     */
    public function setCn($cn)
    {
        $this->model->cn = $cn;
        
        return $this;
    }
    
    /**
     * @param $sn
     * @return $this
     */
    public function setSn($sn)
    {
        $this->model->sn = $sn;
        
        return $this;
    }
    
    /**
     * @param $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->model->uid = $uid;
        
        return $this;
    }
    
    /**
     * @param $sAMAccountName
     * @return $this
     */
    public function setSAMAccountName($sAMAccountName)
    {
        $this->model->sAMAccountName = $sAMAccountName;
        
        return $this;
    }
    
    /**
     * @param $userPassword
     * @return $this
     */
    public function setUserPass($userPassword)
    {
        $this->model->userPassword = $userPassword;
        
        return $this;
    }
    
    /**
     * @param $memberOf
     * @return $this
     */
    public function setMemberOf($memberOf)
    {
        $this->model->memberOf = $memberOf;
        
        return $this;
    }
    
    /**
     * @param $uid
     * @param $ou
     * @return $this
     */
    public function setUserDn($uid, $ou)
    {
        $this->model->setDn($this->model->getDnBuilder()->addUid($uid)->addOu($ou));
        
        return $this;
    }
    
    /**
     * @param array $objectClass
     * @return $this
     */
    public function setObjectClass(array $objectClass)
    {
        $this->model->objectClass = $objectClass;
        
        return $this;
    }
}