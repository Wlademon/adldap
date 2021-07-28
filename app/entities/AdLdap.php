<?php

namespace entities;

use Adldap\AdldapException;
use Adldap\Connections\Ldap;
use Adldap\Connections\ProviderInterface;
use configurators\AdLdapConfigurator;

/**
 * Class ADLdap
 * @package entities
 */
class AdLdap implements LdapEntityInterface
{
    /**
     * @var AdLdapConfigurator
     */
    protected $config;
    
    /**
     * @var \Adldap\Adldap
     */
    protected $entity;
    
    /**
     * @var ProviderInterface
     */
    protected $connectedEntity;
    
    /**
     * AdLdap constructor.
     * @param AdLdapConfigurator $config
     * @param false $lazy
     * @throws AdldapException
     * @throws \exceptions\AdLdapException
     */
    public function __construct(AdLdapConfigurator $config, $lazy = false)
    {
        $this->config = $config;
        $this->entity = new \Adldap\Adldap();
        $connection = new Ldap('first');
        $connection->tls();
        
        $this->entity->addProvider(array_merge($this->config->toArray(),
            [
                'custom_options' => [
                    LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER
                ]
            ]
        ), 'first', $connection);
        $this->entity->setDefaultProvider('first');
        if (!$lazy) {
            $this->connect();
        }
    }
    
    /**
     * @return mixed|void
     * @throws \exceptions\AdLdapException
     */
    public function connect()
    {
        try {
            $this->connectedEntity = $this->entity->connect('first', $this->config->getUsername(), $this->config->getPassword());
        } catch (\Throwable $t) {
            \exceptions\AdLdapException::loginFail($this->config->getUsername());
        }
    }
    
    /**
     * @return \Adldap\Models\Factory
     * @throws AdldapException
     */
    public function insertQuery()
    {
        return $this->getConnectedEntity()->make();
    }
    
    /**
     * @return ProviderInterface
     * @throws \exceptions\AdLdapException
     */
    protected function getConnectedEntity()
    {
        if (!$this->connectedEntity) {
            \exceptions\AdLdapException::notConnect();
        }
        
        return $this->connectedEntity;
    }
    
    /**
     * @return \Adldap\Query\Factory
     * @throws AdldapException
     */
    public function findQuery()
    {
        return $this->getConnectedEntity()->search();
    }
}