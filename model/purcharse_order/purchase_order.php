<?php

class PurchaseOrder
{
    private string $_guid;
    private int $_account_id;
    private float $_total_price;
    private string $_date;

    public function get_guid(): string
    {
        return $this->_guid;
    }


    public function get_account_id(): int
    {
        return $this->_account_id;
    }

    public function get_total_price(): float
    {
        return $this->_total_price;
    }

    public function get_date(): string
    {
        return $this->_date;
    }

    public function __construct(array $data)
    {
        $this->_guid = $data['guid'];
        $this->_account_id = $data['account_id'];
        $this->_total_price = $data['total_price'];
        $this->_date = $data['date'];
    }
}
