<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
Navigation::init_navigation();

if (isset($_POST['old_password']) && isset($_POST['new_password'])) {
    $account_controller = new AccountController();
    $account_email = $_SESSION['account']['email'];
    $account = $account_controller->fetch_account($account_email, $_POST['old_password']);

    if ($account == null) {
        $change_pwd_page = Navigation::change_passowrd_page();

        echo ("<script>
         alert('Incorrect password : {$_POST['old_password']}');
         window.location = '{$change_pwd_page}';
         </script>");
    } else {
        if ($account->get_password() == $_POST['new_password']) {
            $change_pwd_page = Navigation::change_passowrd_page();

            echo ("<script>
         alert('Incorrect Old Password and New Password are similar.');
         window.location = '{$change_pwd_page}';
         </script>");
        } else {
            $account_page = Navigation::your_account_page();
            $account_controller->change_password($account->get_id(), $_POST['new_password']);

            echo ("<script>
         alert('Password was successfully changed : {$_POST['new_password']}');
         window.location = '{$account_page}';
         </script>");
        }
    }
}
