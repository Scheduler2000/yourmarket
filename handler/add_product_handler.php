<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../model/product/product_builder.php');
require_once(__DIR__ . '/../controller/database/product_controller.php');

Navigation::init_navigation();


if (
    isset($_POST['product_category']) &&
    isset($_POST['type_of_sale']) &&
    isset($_POST['product_title']) &&
    isset($_POST['product_description']) &&
    isset($_POST['product_price']) &&
    isset($_FILES['thumbnail_picture']) &&
    isset($_FILES['image_1']) &&
    isset($_FILES['image_2']) &&
    isset($_FILES['image_3']) &&
    isset($_FILES['image_4'])
) {

    $builder = new ProductBuilder();
    $controller = new ProductController();

    $thumbnail = file_get_contents($_FILES['thumbnail_picture']['tmp_name']);
    $image_1 = file_get_contents($_FILES['image_1']['tmp_name']);
    $image_2 = file_get_contents($_FILES['image_2']['tmp_name']);
    $image_3 = file_get_contents($_FILES['image_3']['tmp_name']);
    $image_4 = file_get_contents($_FILES['image_4']['tmp_name']);
    $product = $builder
        ->set_seller_account_id((int)$_SESSION['account']['id'])
        ->set_name($_POST['product_title'])
        ->set_description($_POST['product_description'])
        ->set_category((int)$_POST['product_category'])
        ->set_type_of_sale((int)$_POST['type_of_sale'])
        ->set_price((float)($_POST['product_price']))
        ->set_thumbnail($thumbnail)
        ->set_image1($image_1)
        ->set_image2($image_2)
        ->set_image3($image_3)
        ->set_image4($image_4)
        ->set_end_of_auction($_POST['end_of_auction'] ?? null)
        ->build();

    $status_code = $controller->create_product($product);

    switch ($status_code) {
        case 0:
            $account_seller_page = Navigation::your_account_seller_page();
            echo "<script>window.location = '{$account_seller_page}';</script>";
            break;

        case 2:
            $add_product_page = Navigation::add_new_product_page();
            echo "<script>alert('An error occurred while requesting the database.')</script>";
            echo "<script>window.location = '{$add_product_page}';</script>";
            break;
    }
} else echo '<strong>WTF Why you do that ?</strong>';
