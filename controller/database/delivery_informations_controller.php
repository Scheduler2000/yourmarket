<?php

require_once('database_controller.php');
require_once(__DIR__ . '/../../model/delivery_informations/delivery_informations.php');

class DeliveryInformationsController extends DatabaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_delivery_informations(DeliveryInformations $infos): int   /* 0 => success / 1 => doublon / 2 => error on query / 3 => addresses slots = 6*/
    {
        $sql_doublon = 'SELECT * FROM delivery_informations WHERE account_id = :aid AND postal_code = :zip AND address = :addr AND owner_name = :owner';

        $query_doublon = $this->_database->prepare($sql_doublon);
        $query_doublon->execute(array(
            'aid' => $infos->get_account_id(),
            'zip' => $infos->get_postal_code(),
            'addr' => $infos->get_address(),
            'owner' => $infos->get_owner_name()
        ));

        if (!empty($query_doublon->fetch()))
            return 1;

        $sql_slots = 'SELECT COUNT(*) FROM delivery_informations WHERE account_id = :account_id';

        $query_slots = $this->_database->prepare($sql_slots);
        $query_slots->execute(array('account_id' => $infos->get_account_id()));
        $count = $query_slots->fetch();

        if (!empty($count) && $count == 6)
            return 3;

        $sql_create = 'INSERT INTO delivery_informations (account_id, country, state, postal_code, city, address, owner_name, mobile_number) 
                       VALUES (:account_id, :country, :state, :postal_code, :city, :address, :owner_name, :mobile_number)';

        $query_create = $this->_database->prepare($sql_create);
        $res = $query_create->execute(array(
            'account_id' => $infos->get_account_id(),
            'country' => $infos->get_country(),
            'state' => $infos->get_state(),
            'postal_code' => $infos->get_postal_code(),
            'city' => $infos->get_city(),
            'address' => $infos->get_address(),
            'owner_name' => $infos->get_owner_name(),
            'mobile_number' => $infos->get_mobile_number()
        ));

        return $res == true ? 0 : 2;
    }

    public function delete_delivery_informations(int $account_id, string $zip, string $addr, string $owner): bool
    {
        $sql = 'DELETE FROM delivery_informations WHERE account_id = :aid AND postal_code = :zip AND address = :addr AND owner_name = :owner';
        $query = $this->_database->prepare($sql);

        return $query->execute(array(
            'aid' => $account_id,
            'zip' => $zip,
            'addr' => $addr,
            'owner' => $owner
        ));
    }

    public function get_delivery_informations(int $account_id): ?array
    {
        $sql = 'SELECT * FROM delivery_informations WHERE account_id = :account_id';
        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('account_id' => $account_id)))
            return null;

        return $query->fetchAll();
    }
}
