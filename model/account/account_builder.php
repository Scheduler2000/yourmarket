<?php

require_once('account.php');

class AccountBuilder
{
    private array $_underlying;


    public function set_name(string $name): AccountBuilder
    {
        $this->_underlying['name'] = $name;
        return $this;
    }

    public function set_email(string $email): AccountBuilder
    {
        $this->_underlying['email'] = strtolower($email);
        return $this;
    }

    public function set_password(string $password): AccountBuilder
    {
        $this->_underlying['password'] = $password;
        return $this;
    }

    public function set_is_seller(bool $flag): AccountBuilder
    {
        $this->_underlying['is_seller'] = $flag;
        return $this;
    }

    public function set_is_admin(bool $flag): AccountBuilder
    {
        $this->_underlying['is_admin'] = $flag;
        return $this;
    }

    public function build(): Account
    {
        return new Account($this->_underlying);
    }
}
