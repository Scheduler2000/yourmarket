<?php

require_once('product.php');

class ProductBuilder
{
    private array $_underlying;

    public function set_seller_account_id(int $id): ProductBuilder
    {
        $this->_underlying['seller_account_id'] = $id;
        return $this;
    }

    public function set_name(string $name): ProductBuilder
    {
        $this->_underlying['name'] = $name;
        return $this;
    }

    public function set_description(string $description): ProductBuilder
    {
        $this->_underlying['description'] = $description;
        return $this;
    }

    public function set_price(float $price): ProductBuilder
    {
        $this->_underlying['price'] = $price;
        return $this;
    }

    public function set_thumbnail(string $blob): ProductBuilder
    {
        $this->_underlying['thumbnail'] = $blob;
        return $this;
    }

    public function set_image1(string $blob): ProductBuilder
    {
        $this->_underlying['image_1'] = $blob;
        return $this;
    }

    public function set_image2(string $blob): ProductBuilder
    {
        $this->_underlying['image_2'] = $blob;
        return $this;
    }

    public function set_image3(string $blob): ProductBuilder
    {
        $this->_underlying['image_3'] = $blob;
        return $this;
    }

    public function set_image4(string $blob): ProductBuilder
    {
        $this->_underlying['image_4'] = $blob;
        return $this;
    }

    public function set_category(int $category): ProductBuilder
    {
        $this->_underlying['category'] = $category;
        return $this;
    }

    public function set_type_of_sale(int $type_of_sale): ProductBuilder
    {
        $this->_underlying['type_of_sale'] = $type_of_sale;
        return $this;
    }

    public function set_end_of_auction(?string $date): ProductBuilder
    {
        $this->_underlying['end_of_auction'] = $date;
        return $this;
    }

    public function set_account_id_last_proposal_auction(?int $id): ProductBuilder
    {
        $this->_underlying['account_id_last_proposal_auction'] = $id;
        return $this;
    }

    public function build(): Product
    {
        return new Product($this->_underlying);
    }
}
