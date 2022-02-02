<?php

require_once('delivery_informations.php');

class DeliveryInformationsBuilder
{
    private array $_underlying;


    public function set_account(int $account_id): DeliveryInformationsBuilder
    {
        $this->_underlying['account_id'] = $account_id;
        return $this;
    }

    public function set_country(string $country): DeliveryInformationsBuilder
    {
        $this->_underlying['country'] = strtolower($country);
        return $this;
    }

    public function set_city(string $city): DeliveryInformationsBuilder
    {
        $this->_underlying['city'] = $city;
        return $this;
    }

    public function set_postal_code(string $zip): DeliveryInformationsBuilder
    {
        $this->_underlying['postal_code'] = $zip;
        return $this;
    }


    public function set_state(string $state): DeliveryInformationsBuilder
    {
        $this->_underlying['state'] = $state;
        return $this;
    }


    public function set_address(string $address): DeliveryInformationsBuilder
    {
        $this->_underlying['address'] = $address;
        return $this;
    }

    public function set_mobile_number(string $number): DeliveryInformationsBuilder
    {
        $this->_underlying['mobile_number'] = $number;
        return $this;
    }

    public function set_owner_name(string $name): DeliveryInformationsBuilder
    {
        $this->_underlying['owner_name'] = $name;
        return $this;
    }

    public function build(): DeliveryInformations
    {
        return new DeliveryInformations($this->_underlying);
    }
}
