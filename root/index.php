<?php

include_once 'init.php';
$config = new \configurators\AdLdapConfigurator('pdc.vostok.service', 'DC=vostok,DC=service', 'CN=cpadm,OU=Admin Accounts,OU=admins,DC=vostok,DC=service', 'PaRusNik7');
$adLdap = new \services\ActiveDirectoryLdap($config);
var_dump($adLdap->dataOfUser('cpuser')->toArray());

die();