<?php

namespace entities;

class UserResponse
{
    protected $login;
    protected $phone;
    protected $isVip = false;
    
    public function __construct($login, $phone, $isVip = false)
    {
        $this->login = $login;
        $this->isVip = (bool)$isVip;
        $this->phone = $phone;
    }
    
    public function getIsVip()
    {
        return $this->isVip;
    }
    
    public function getLogin()
    {
        return $this->login;
    }
    
    public function getPhone()
    {
        return $this->phone;
    }
    
    public function toArray()
    {
        return [
            'login' => $this->getLogin(),
            'phone' => $this->getPhone(),
            'isVip' => $this->getIsVip()
        ];
    }
}