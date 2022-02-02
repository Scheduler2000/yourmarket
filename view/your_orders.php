<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/purchase_order_controller.php');
require_once(__DIR__ . '/../controller/database/purchased_product_controller.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');

$purchase_order_controller = new PurchaseOrderController();
$purchased_product_controller = new PurchasedProductController();
$account_controller = new AccountController();

$purchase_orders = $purchase_order_controller->get_purchase_orders($_SESSION['account']['id']);
$purchased_product = $purchased_product_controller->get_purchased_products('DC48BF59-6160-4A68-B515-DC99D4266DC3');
Navigation::init_navigation();


if (array_key_exists('delete_purchase_order', $_POST) && isset($_POST['purchase_order_guid'])) {

    if (
        !($purchase_order_controller->delete_purchase_order($_POST['purchase_order_guid']) &&
            $purchased_product_controller->delete_pruchased_products($_POST['purchase_order_guid']))
    )
        echo "<script>alert('An error occurred while requesting the database.')</script>";


    header("Refresh:0");
}

if (array_key_exists('generate_invoice', $_POST) && isset($_POST['purchase_order_guid'])) {
    $products = $purchased_product_controller->get_purchased_products($_POST['purchase_order_guid']);

    $file = 'Invoice-' . $_POST['purchase_order_guid'] . '.txt';
    $writer = fopen($file, 'w') or die('Unable to generate invoice !');

    $invoice_content = 'INVOICE : ' . $_POST['purchase_order_guid'] . "\n"
        .
        "\tDate : " . $_POST['purchase_order_date']
        .  "\n\n{\n\n";
    foreach ($products as $product) {
        $invoice_content .= "\tProduct name : " . $product['product_name'] . "\n"
            .  "\tProduct quantity : " . $product['product_quantity'] . "\n"
            .  "\tProduct unit price : " . $product['product_price']  / $product['product_quantity'] . "$\n"
            .  "\tProduct total price : " . $product['product_price'] . "$\n"
            .  "\tSeller : " . $account_controller->get_account_name($product['seller_account_id']) . "\n\n";
    }
    $invoice_content .= '}             ';

    echo $invoice_content;
    fwrite($writer, $invoice_content);
    fclose($writer);
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    header("Content-Type: text/plain");
    readfile($file);
    unlink($file);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Your market</title>
    <link rel="stylesheet" href="static/style/site.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />

</head>

<body>
    <?php include "components/navbar.php" ?>

    <div class="container mt-5 mb-5">
        <!-- URL Breadcrumb Starts -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent ml-n3">
                <li class="breadcrumb-item"><a href="<?= Navigation::your_account_page() ?>">Your Account</a></li>
                <li class="breadcrumb-item active text-danger" aria-current="page">Your Orders</li>
            </ol>
        </nav> <!-- URL Breadcrumb Ends -->


        <!-- Order Card Starts -->
        <?php foreach ($purchase_orders as $purchase_order) : ?>
            <div class="card mt-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 mt-3 mt-md-0">
                            <p class="text-uppercase text-muted my-0">order placed</p>
                            <p class="text-uppercase text-muted my-0"><?= $purchase_order['date'] ?></p>
                        </div>

                        <div class="col-md-4 mt-3 mt-md-0">
                            <p class="text-uppercase text-muted my-0">total</p>
                            <p class="text-uppercase text-muted my-0">
                                <?= $purchase_order['total_price'] ?> <i class="fas fa-dollar-sign"></i>
                            </p>
                        </div>

                        <div class="col-md-4 mt-3 mt-md-0">
                            <p class="text-uppercase text-muted my-0 float-md-right">order # <?= $purchase_order['guid'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $purchased_products = $purchased_product_controller->get_purchased_products($purchase_order['guid']);
                    foreach ($purchased_products as $key => $purchased_product) : ?>
                        <div class="row">
                            <div class="col-md-1">

                                <img src="data:image;base64,<?= base64_encode($purchased_product['product_thumbnail']) ?>" width="105" height="130" alt="product 01 image">
                            </div>

                            <div class="col-md-5">
                                <a href="#"><?= $purchased_product['product_name'] ?></a>
                                <p class="text-muted my-0">Sold by : <?= $account_controller->get_account_name($purchased_product['seller_account_id']) ?></p>
                                <p class="text-muted my-0">Unit price : <?= $purchased_product['product_price']  / $purchased_product['product_quantity'] ?> <i class="fas fa-dollar-sign"></i></p>
                                <p class="text-muted my-0">Quantity : <?= $purchased_product['product_quantity'] ?></p>
                                <p class="text-uppercase my-0">
                                    <span class="text-danger"><?= $purchased_product['product_price'] ?></span> <i class="fas fa-dollar-sign"></i>
                                </p>
                            </div>

                            <?php if ($key == 0) : ?>
                                <div class="col-md-6 d-flex flex-column">
                                    <form method="POST">
                                        <button type="submit" name="delete_purchase_order" class="btn btn-outline-secondary btn-sm w-50 ml-auto my-1">Delete Purchase Order</button>
                                        <button type="submit" name="generate_invoice" class="btn btn-outline-info btn-sm w-50 ml-auto my-1">Generate Invoice</button>
                                        <input type="text" value="<?= $purchase_order['guid'] ?>" name="purchase_order_guid" hidden>
                                        <input type="text" value="<?= $purchase_order['date'] ?>" name="purchase_order_date" hidden>

                                    </form>
                                </div>
                            <?php endif;  ?>
                        </div> <br>
                    <?php endforeach; ?>

                </div>
            </div> <!-- Order Card Starts -->
        <?php endforeach; ?>
    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>