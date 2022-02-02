<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
require_once(__DIR__ . '/../model/product/product.php');
$account_controller = new AccountController();
$total_price = 0;
$total_item = 0;
Navigation::init_navigation();

if (array_key_exists('increment_quantity_btn', $_POST)) {
    $already_in_shopping_cart = false;
    $index = -1;

    foreach ($_SESSION['shopping_cart'] as $key => $item) {
        if (unserialize($item)->get_id() == $_POST['pid']) {
            $already_in_shopping_cart = true;
            $index = $key;
            break;
        }
    }

    if ($already_in_shopping_cart) {
        $prd = unserialize($_SESSION['shopping_cart'][$index]);
        $prd->increment_quantity();
        $_SESSION['shopping_cart'][$index] = serialize($prd);
    } else
        throw new Exception('WTF YOU CAN ADD A PRODUCT THAT ISNT ALREADY IN YOUR SHOPPING BAG');
}

if (array_key_exists('decrement_quantity_btn', $_POST)) {
    $already_in_shopping_cart = false;
    $index = -1;

    foreach ($_SESSION['shopping_cart'] as $key => $item) {
        if (unserialize($item)->get_id() == $_POST['pid']) {
            $already_in_shopping_cart = true;
            $index = $key;
            break;
        }
    }

    if ($already_in_shopping_cart) {
        $prd = unserialize($_SESSION['shopping_cart'][$index]);
        $prd->decrement_quantity();
        if ($prd->get_quantity() > 0)
            $_SESSION['shopping_cart'][$index] = serialize($prd);
        else
            unset($_SESSION['shopping_cart'][$index]);
    } else
        throw new Exception('WTF YOU CAN REMOVE A PRODUCT THAT ISNT ALREADY IN YOUR SHOPPING BAG');
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
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

</head>

<body>
    <?php include "components/navbar.php" ?>

    <div class="container my-5">

        <!-- Cart title start -->
        <div class="row">
            <div class="col-md-8">
                <h3>Shopping Cart</h3>
            </div>
        </div> <!-- Cart title ends -->

        <!-- Product list start -->
        <div class="row">

            <!-- Product Detail start -->
            <div class="col-md-8">

                <!-- Product row starts -->
                <?php foreach ($_SESSION['shopping_cart'] as $item) : $product = unserialize($item); ?>
                    <div class="row border-top py-3">
                        <!-- Product image -->
                        <div class="col-md-3">
                            <img src="data:image;base64,<?= base64_encode($product->get_thumbnail()) ?>" class="img-fluid" alt="product 01 image">
                        </div>

                        <!-- Product details -->
                        <div class="col-md-9">
                            <a href="<?= Navigation::product_page($product->get_id()) ?>"><?= $product->get_name() ?></a>
                            <p class="text-uppercase font-weight-bold my-0 float-right">
                                <span><?= $product->get_price() ?></span> <i class="fas fa-dollar-sign" style="font-size: 10px;"></i>
                            </p>
                            <p class="text-muted my-0">Sold by : <?= $account_controller->get_account_name($product->get_seller_account_id()) ?></p>

                            <div class="d-flex flex-row mt-2">
                                <!-- Quatinty select -->
                                <div class="number-input md-number-input">
                                    <form method="POST">
                                        <input type="text" name="pid" hidden value="<?= $product->get_id() ?>">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="btn btn-info btn-sm" type="submit" name="decrement_quantity_btn">-</button>
                                        <input class="text" min="1" name="quantity" value="<?= $product->get_quantity() ?>" type="number" disabled>
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="btn btn-info btn-sm" type="submit" name="increment_quantity_btn">+</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Product row ends -->
                <?php
                    $total_price += $product->get_price() * $product->get_quantity();
                    $total_item += $product->get_quantity();
                endforeach; ?>



                <!-- Sub total row starts -->
                <div class="row border-top py-3">
                    <div class="col-md-12 ">
                        <p class="float-right font-weight-bold">
                            Subtotal (<?= $total_item ?> items): <span><?= $total_price ?></span> <i class="fas fa-dollar-sign" style="font-size: 10px;"></i>
                        </p>
                    </div>
                </div>
            </div> <!-- Product Detail end -->



            <!-- Proceed to buy card start -->
            <div class="col-md-4 text-center pl-md-5 pl-0">

                <div class="card my-3">
                    <div class="card-header bg-transparent">
                        <p class="text-center text-success my-0" style="font-size: 15px;">
                            <!-- <i class="fas fa-info-circle text-info"></i>
              Add ₹ 17.00 of eligible items to your order to qualify for FREE Delivery. -->
                            <i class="fas fa-check"></i>
                            Your order is eligible for FREE Delivery.
                        </p>
                    </div>
                    <div class="card-body text-center" style="background-color: #f3f3f3;">
                        <p class="font-weight-bold">
                            Subtotal (<?= $total_item ?> items): <span><?= $total_price ?></span> <i class="fas fa-dollar-sign" style="font-size: 10px;"></i>
                        </p>
                        <?php if ($total_item > 0) : ?>
                            <a href="<?= Navigation::select_address_page() ?>" class="btn btn-warning btn-sm btn-block">Proceed to buy</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div> <!-- Proceed to buy card end -->
        </div> <!-- Product list end -->


    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>