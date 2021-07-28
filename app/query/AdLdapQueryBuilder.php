<?php

namespace query;

use Adldap\Query\Factory;
use exceptions\ADLdapQueryException;

/**
 * Class AdLdapQueryBuilder
 *
 * @mixin Factory
 *
 * @package query
 */
class AdLdapQueryBuilder
{
    /**
     * @var Factory
     */
    protected $query;
    
    /**
     * AdLdapQueryBuilder constructor.
     * @param Factory $query
     */
    public function __construct(Factory $query)
    {
        $this->query = $query;
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
            $result = call_user_func_array([$this->query, $name], $arguments);
            if ($result instanceof Factory) {
                return $this;
            }
    
            return $result;
        } catch (\Throwable $throwable) {
            throw (new ADLdapQueryException($throwable->getMessage()))->setEntity($this->query)->setException($throwable);
        }
    }
    
    /**
     * @return Factory
     */
    public function getQueryObject()
    {
        return $this->query;
    }
    
    /**
     * @param $dn
     * @return $this
     */
    public function whereDn($dn)
    {
        $this->query->whereHas('dn')->where('dn', '=', $dn);
        
        return $this;
    }
    
    /**
     * @param $ou
     * @return $this
     */
    public function whereOu($ou)
    {
        $this->query->where('ou', '=', $ou);
    
        return $this;
    }
    
    /**
     * @param $uid
     * @return $this
     */
    public function whereUid($uid)
    {
        $this->query->where('uid', '=', $uid);

        return $this;
    }
}