<?php

class DeliveryInformations
{
    private ?int $_id;
    private int $_account_id;
    private string $_country;
    private string $_state;
    private string $_city;
    private string $_postal_code;
    private string $_address;
    private string $_owner_name;
    private string $_mobile_number;
    private array $_data;

    public function get_id(): int
    {
        return $this->_id;
    }

    public function get_account_id(): int
    {
        return $this->_account_id;
    }

    public function get_country(): string
    {
        return $this->_country;
    }

    public function get_state(): string
    {
        return $this->_state;
    }

    public function get_city(): string
    {
        return $this->_city;
    }

    public function get_postal_code(): string
    {
        return $this->_postal_code;
    }

    public function get_address(): string
    {
        return $this->_address;
    }

    public function get_owner_name(): string
    {
        return $this->_owner_name;
    }

    public function get_mobile_number(): string
    {
        return $this->_mobile_number;
    }

    public function get_data(): array
    {
        return $this->_data;
    }

    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->_id = $data['id'] ?? null;
        $this->_account_id = $data['account_id'];
        $this->_country = $data['country'];
        $this->_state = $data['state'];
        $this->_city = $data['city'];
        $this->_postal_code = $data['postal_code'];
        $this->_address = $data['address'];
        $this->_owner_name = $data['owner_name'];
        $this->_mobile_number = $data['mobile_number'];
    }
}
