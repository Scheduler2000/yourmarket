<?php

require_once('purchased_product.php');

class PurchasedProductBuilder
{
    private array $_underlying;

    public function set_purchase_order_guid(string $purchase_order_guid): PurchasedProductBuilder
    {
        $this->_underlying['purchase_order_guid'] = $purchase_order_guid;
        return $this;
    }

    public function set_product_name(string $product_name): PurchasedProductBuilder
    {
        $this->_underlying['product_name'] = $product_name;
        return $this;
    }

    public function set_product_thumbnail(string $product_thumbnail): PurchasedProductBuilder
    {
        $this->_underlying['product_thumbnail'] = $product_thumbnail;
        return $this;
    }

    public function set_product_price(float $product_price): PurchasedProductBuilder
    {
        $this->_underlying['product_price'] = $product_price;
        return $this;
    }

    public function set_seller_account_id(int $seller_account_id): PurchasedProductBuilder
    {
        $this->_underlying['seller_account_id'] = $seller_account_id;
        return $this;
    }

    public function set_product_quantity(int $product_quantity): PurchasedProductBuilder
    {
        $this->_underlying['product_quantity'] = $product_quantity;
        return $this;
    }

    public function build(): PurchasedProduct
    {
        return new PurchasedProduct($this->_underlying);
    }
}
