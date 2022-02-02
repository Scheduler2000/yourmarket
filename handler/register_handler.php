<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
require_once(__DIR__ . '/../model/account/account_builder.php');

Navigation::init_navigation();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $account_controller = new AccountController();
    $account_builder = new AccountBuilder();

    $account = $account_builder
        ->set_name($_POST['name'])
        ->set_email($_POST['email'])
        ->set_password($_POST['password'])
        ->set_is_seller(false)
        ->set_is_admin(false)
        ->build();
    $status_code = $account_controller->create_account($account);

    switch ($status_code) {
        case 0: /* success */
            $login_page = Navigation::sign_in_page();
            //            $_SESSION['account'] = $account->get_data();
            //           $_SESSION['shopping_cart'] = array();

            echo "<script>alert('account created successfully.')</script>";
            echo "<script>window.location = '{$login_page}';</script>";
            break;

        case 1:/* duplicate email on database. */
            $register_page = Navigation::register_page();
            echo "<script>alert('An account with email : {$_POST['email']} already exists.')</script>";
            echo "<script>window.location = '{$register_page}';</script>";
            break;
        case 2:
            $register_page = Navigation::register_page();
            echo "<script>alert('An error occurred while requesting the database.')</script>";
            echo "<script>window.location = '{$register_page}';</script>";
            break;
    }
} else echo '<strong>WTF Why you do that ?</strong>';
