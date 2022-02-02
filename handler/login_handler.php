
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
Navigation::init_navigation();


Navigation::init_navigation();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $account_controller = new AccountController();
    $account = $account_controller->fetch_account($_POST['email'], $_POST['password']);
    if ($account != null) {
        $account_page = Navigation::your_account_page();

        $_SESSION['account'] = $account->get_data();
        $_SESSION['shopping_cart'] = array();

        echo "<script>window.location = '{$account_page}';</script>";
    } else {
        $login_page = Navigation::sign_in_page();

        echo "<script>alert('Credentials are incorrect !')</script>";
        echo "<script>window.location = '{$login_page}';</script>";
    }
} else echo '<strong>WTF Why you do that ?</strong>';
