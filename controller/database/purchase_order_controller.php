<?php

require_once('database_controller.php');
require_once(__DIR__ . '/../../model/purcharse_order/purchase_order.php');

class PurchaseOrderController extends DatabaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_purchase_order(PurchaseOrder $purchase_order): bool
    {
        $sql = 'INSERT INTO purchase_order (guid, account_id, date, total_price)
                VALUES (:guid, :aid, :date, :total_price)';


        $query = $this->_database->prepare($sql);
        $res = $query->execute(array(
            'guid' => $purchase_order->get_guid(),
            'aid' => $purchase_order->get_account_id(),
            'total_price' => $purchase_order->get_total_price(),
            'date' => $purchase_order->get_date()
        ));

        return $res;
    }

    public function get_purchase_orders(int $account_id): ?array
    {
        $sql = 'SELECT * FROM purchase_order WHERE account_id = :aid';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('aid' => $account_id)))
            return null;

        return $query->fetchAll();
    }

    public function delete_purchase_order(string $guid): bool
    {
        $sql = 'DELETE FROM purchase_order WHERE guid = :guid';

        $query = $this->_database->prepare($sql);

        return $query->execute(array('guid' => $guid));
    }
}
