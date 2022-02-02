<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/product_feedback_controller.php');
require_once(__DIR__ . '/../model/product_feedback/product_feedback_builder.php');

Navigation::init_navigation();

if (
    isset($_POST['headline']) &&
    isset($_POST['comments']) &&
    isset($_POST['pid']) &&
    isset($_POST['rating']) &&
    isset($_POST['seller_aid'])
) {
    $controller = new ProductFeedbackController();
    $builder = new ProductFeedbackBuilder();

    $feedback = $builder
        ->set_headline($_POST['headline'])
        ->set_comment($_POST['comments'])
        ->set_rate($_POST['rating'])
        ->set_item_id($_POST['pid'])
        ->set_author_account_id($_SESSION['account']['id'])
        ->build();

    $status_code = $controller->create_feedback($feedback);

    switch ($status_code) {
        case 0:
            $product_page = Navigation::product_page($_POST['pid']);
            echo "<script>window.location = '{$product_page}';</script>";
            break;

        case 2:
            $add_feedback_page = Navigation::product_feedback_page($_POST['rating'], $_POST['pid'], $_POST['seller_aid']);
            echo "<script>alert('An error occurred while requesting the database.')</script>";
            echo "<script>window.location = '{$add_feedback_page}';</script>";
            break;
    }
} else echo '<strong>WTF Why you do that ?</strong>';
