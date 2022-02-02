<?php

require_once('database_controller.php');
require_once(__DIR__ . '/../../model/purchased_product/purchased_product.php');

class PurchasedProductController extends DatabaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_purchased_product(PurchasedProduct $purchased_product): bool
    {
        $sql = 'INSERT INTO purchased_product (purchase_order_guid, product_name, product_thumbnail, product_price, product_quantity, seller_account_id)
                VALUES (:purchase_order_guid, :product_name, :product_thumbnail, :product_price, :product_quantity,  :seller_account_id)';


        $query = $this->_database->prepare($sql);
        $res = $query->execute(array(
            'purchase_order_guid' => $purchased_product->get_purchase_order_guid(),
            'product_name' => $purchased_product->get_product_name(),
            'product_thumbnail' => $purchased_product->get_product_thumbnail(),
            'product_price' => $purchased_product->get_product_price(),
            'product_quantity' => $purchased_product->get_product_quantity(),
            'seller_account_id' => $purchased_product->get_seller_account_id()
        ));

        return $res;
    }

    public function get_purchased_products(string $purchase_order_guid): ?array
    {
        $sql = 'SELECT * FROM purchased_product WHERE purchase_order_guid = :pog';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('pog' => $purchase_order_guid)))
            return null;

        return $query->fetchAll();
    }

    public function delete_pruchased_products(string $purchase_order_guid): bool
    {
        $sql = 'DELETE FROM purchased_product WHERE purchase_order_guid = :pog';

        $query = $this->_database->prepare($sql);

        return $query->execute(array('pog' => $purchase_order_guid));
    }
}
