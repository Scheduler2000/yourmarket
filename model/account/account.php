<?php

class Account
{
    private ?int $_id;
    private string $_name;
    private string $_email;
    private string $_password;
    private bool $_is_seller;
    private bool $_is_admin;
    private array $_data;


    public function get_id(): int
    {
        return $this->_id;
    }

    public function get_name(): string
    {
        return $this->_name;
    }

    public function get_email(): string
    {
        return $this->_email;
    }

    public function get_password(): string
    {
        return $this->_password;
    }

    public function get_is_seller(): bool
    {
        return  $this->_is_seller;
    }

    public function get_is_admin(): bool
    {
        return  $this->_is_admin;
    }

    public function get_data(): array
    {
        return $this->_data;
    }

    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->_id = $data['id'] ?? null;
        $this->_name = $data['name'];
        $this->_email = $data['email'];
        $this->_password = $data['password'];
        $this->_is_seller = $data['is_seller'];
        $this->_is_admin = $data['is_admin'];
    }
}
