<?php

class PurchasedProduct
{
    private ?int $_id;
    private string $_purchase_order_guid;
    private string $_product_name;
    private string $_product_thumbnail;
    private float $_product_price;
    private int $_product_quantity;
    private int $_seller_account_id;


    public function get_id(): int
    {
        return $this->_id;
    }

    public function get_purchase_order_guid(): string
    {
        return $this->_purchase_order_guid;
    }

    public function get_product_name(): string
    {
        return $this->_product_name;
    }

    public function get_product_thumbnail(): string
    {
        return $this->_product_thumbnail;
    }

    public function get_product_price(): float
    {
        return $this->_product_price;
    }

    public function get_seller_account_id(): int
    {
        return $this->_seller_account_id;
    }

    public function get_product_quantity(): int
    {
        return $this->_product_quantity;
    }

    public function __construct(array $data)
    {
        $this->_id = $data['id'] ?? null;
        $this->_purchase_order_guid = $data['purchase_order_guid'];
        $this->_product_name = $data['product_name'];
        $this->_product_thumbnail = $data['product_thumbnail'];
        $this->_product_price = $data['product_price'];
        $this->_seller_account_id = $data['seller_account_id'];
        $this->_product_quantity = $data['product_quantity'];
    }
}
