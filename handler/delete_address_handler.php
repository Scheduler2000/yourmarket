<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/delivery_informations_controller.php');
require_once(__DIR__ . '/../model/delivery_informations/delivery_informations_builder.php');

Navigation::init_navigation();


if (isset($_GET['zip']) && isset($_GET['addr']) && isset($_GET['owner'])) {
    $controller = new DeliveryInformationsController();

    $res = $controller->delete_delivery_informations(
        $_SESSION['account']['id'],
        $_GET['zip'],
        $_GET['addr'],
        $_GET['owner']
    );

    if (!$res) {
        $addresses_page = Navigation::your_addresses_page();
        echo "<script>alert('An error occurred while requesting the database.')</script>";
        echo "<script>window.location = '{$addresses_page}';</script>";
    } else {
        $account_page = Navigation::your_account_page();

        echo ("<script>
         alert('Delivery informations was successfully deleted.');
         window.location = '{$account_page}';
         </script>");
    }
} else echo '<strong>WTF Why you do that ?</strong>';
