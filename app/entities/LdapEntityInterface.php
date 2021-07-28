<?php

namespace entities;

/**
 * Interface LdapEntityInterface
 * @package entities
 */
interface LdapEntityInterface
{
    /**
     * @return mixed
     */
    public function connect();
    
    /**
     * @return mixed
     */
    public function findQuery();
    
    /**
     * @return mixed
     */
    public function insertQuery();
}