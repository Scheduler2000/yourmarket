<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/delivery_informations_controller.php');
require_once(__DIR__ . '/../model/delivery_informations/delivery_informations_builder.php');

Navigation::init_navigation();


if (
    isset($_POST['country']) &&
    isset($_POST['owner_name']) &&
    isset($_POST['mobile_number']) &&
    isset($_POST['state']) &&
    isset($_POST['city']) &&
    isset($_POST['zip']) &&
    isset($_POST['address'])
) {
    $controller = new DeliveryInformationsController();
    $builder = new DeliveryInformationsBuilder();


    $delivery_informations = $builder
        ->set_account($_SESSION['account']['id'])
        ->set_country($_POST['country'])
        ->set_owner_name($_POST['owner_name'])
        ->set_mobile_number($_POST['mobile_number'])
        ->set_postal_code($_POST['zip'])
        ->set_state($_POST['state'])
        ->set_city($_POST['city'])
        ->set_address($_POST['address'])
        ->build();

    $status_code = $controller->create_delivery_informations($delivery_informations);

    switch ($status_code) {
        case 0:
            $account_page = Navigation::your_account_page();
            echo "<script>window.location = '{$account_page}';</script>";
            break;

        case 1:
            $register_page = Navigation::add_address_page();
            echo "<script>alert('Same address already exists.')</script>";
            echo "<script>window.location = '{$register_page}';</script>";
            break;
        case 2:
            $register_page = Navigation::add_address_page();
            echo "<script>alert('An error occurred while requesting the database.')</script>";
            echo "<script>window.location = '{$register_page}';</script>";
            break;
        case 3:
            $account_page = Navigation::your_account_page();
            echo "<script>alert('Your account has already 6 addresses.')</script>";
            echo "<script>window.location = '{$account_page}';</script>";
            break;
    }
} else echo '<strong>WTF Why you do that ?</strong>';
