<?php

namespace exceptions;

/**
 * Class ADLdapQueryException
 * @package exceptions
 */
class ADLdapQueryException extends \Exception
{
    protected $entity;

    protected $exception;
    
    /**
     * @param $entity
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * @param $exception
     * @return $this
     */
    public function setException($exception)
    {
        $this->exception = $exception;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }
}