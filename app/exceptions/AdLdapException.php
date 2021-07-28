<?php

namespace exceptions;

/**
 * Class ADLdapException
 * @package exceptions
 */
class AdLdapException extends \Exception
{
    public const USER_NOT_FOUND = 1000;
    public const USER_PHONE_NOT_FOUND = 1001;
    public const CONNECT_ERROR = 1002;
    public const NOT_CONNECT = 1003;
    
    public static function notConnect()
    {
        throw new self('Вход в аккаунт не был выполнен', self::NOT_CONNECT);
    }
    
    public static function loginFail($login = '')
    {
        throw new self('Ошибка при входе.' . ($login ? " Пользователь: $login" : "" ), self::CONNECT_ERROR);
    }
    
    public static function userNotFound($login = '')
    {
        throw new self('Пользователь' . ($login ? " $login" : "" ) . ' не найден!', self::USER_NOT_FOUND);
    }
    
    public static function userPhoneNotFound($login = '')
    {
        throw new self('Телефон пользователя' . ($login ? " $login" : "" ) . ' не найден!', self::USER_PHONE_NOT_FOUND);
    }
    
    
}