<?php

namespace configurators;

use Adldap\Schemas\ActiveDirectory;

/**
 * Class AdLdapConfigurator
 * @package configurators
 */
class AdLdapConfigurator
{
    /**
     * @var array
     */
    protected $hosts = [];
    
    /**
     * @var string
     */
    protected $baseDn;
    
    /**
     * @var string
     */
    protected $username;
    
    /**
     * @var string
     */
    protected $password;
    
    /**
     * @var int
     */
    protected $port = 389;
    
    /**
     * @var string
     */
    protected $schema = ActiveDirectory::class;
    
    /**
     * @var int
     */
    protected $version = 3;
    
    /**
     * AdLdapConfigurator constructor.
     * @param $host
     * @param $baseDn
     * @param $username
     * @param $password
     */
    public function __construct($host, $baseDn, $username, $password)
    {
        $this->hosts = (array)$host;
        $this->baseDn = $baseDn;
        $this->password = $password;
        $this->username = $username;
    }
    
    /**
     * @param $port int
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }
    
    /**
     * @param $version int
     */
    public function setVersion(int $version)
    {
        $this->version = $version;
    }
    
    /**
     * @param $schema string
     */
    public function setSchema(string $schema)
    {
        $this->schema = $schema;
    }
    
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'hosts' => $this->hosts,
            'base_dn' => $this->baseDn,
            'username' => $this->username,
            'password' => $this->password,
            'port' => $this->port,
            'schema' => $this->schema,
            'version' => $this->version,
        ];
    }
}