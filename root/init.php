<?php

use Symfony\Component\Dotenv\Dotenv;

$rootDir = dirname(__DIR__);

include_once $rootDir . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
if (file_exists($rootDir . DIRECTORY_SEPARATOR . 'docker/.env')) {
    $dotenv = new Dotenv();
    $dotenv->load($rootDir . DIRECTORY_SEPARATOR . 'docker/.env');
    $dotenv->usePutenv(true);
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key) ?: $_ENV[$key] ?: $_SERVER[$key];
        if ($value === false) {
            return $default;
        }
       
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
        }
        
        return $value;
    }
}
spl_autoload_register(function($class_name) use ($rootDir) {
    $file = $rootDir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $class_name . '.php';
    $file = strtr($file, '\\', DIRECTORY_SEPARATOR);
    if (file_exists($file)) {
        include_once $file;
    }
});
