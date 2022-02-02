<?php

require_once('purchase_order.php');


class PurchaseOrderBuilder
{
    private array $_underlying;


    public function set_account_id(int $account_id): PurchaseOrderBuilder
    {
        $this->_underlying['account_id'] = $account_id;
        return $this;
    }

    public function set_guid(string $guid): PurchaseOrderBuilder
    {
        $this->_underlying['guid'] = $guid;
        return $this;
    }

    public function set_total_price(float $total_price): PurchaseOrderBuilder
    {
        $this->_underlying['total_price'] = $total_price;
        return $this;
    }

    public function set_date(string $date): PurchaseOrderBuilder
    {
        $this->_underlying['date'] = $date;
        return $this;
    }

    public function build(): PurchaseOrder
    {
        return new PurchaseOrder($this->_underlying);
    }
}
