<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
require_once(__DIR__ . '/../controller/database/delivery_informations_controller.php');
require_once(__DIR__ . '/../controller/database/purchase_order_controller.php');
require_once(__DIR__ . '/../controller/database/purchased_product_controller.php');

require_once(__DIR__ . '/../model/product/product.php');

require_once(__DIR__ . '/../model/purcharse_order/purchase_order_builder.php');
require_once(__DIR__ . '/../model/purcharse_order/purchase_order.php');

require_once(__DIR__ . '/../model/purchased_product/purchased_product.php');
require_once(__DIR__ . '/../model/purchased_product/purchased_product_builder.php');

$account_controller = new AccountController();
$addr_controller = new DeliveryInformationsController();
$purchase_order_controller = new PurchaseOrderController();
$purchased_product_controller = new PurchasedProductController();



$total_price = 0;
$total_item = 0;
$addr = ($addr_controller->get_delivery_informations($_SESSION['account']['id']))[$_SESSION['selected_address_index']];
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

        <!-- Progress Status -->
        <div class="d-flex flex-column">
            <!-- Cart Movement -->
            <div class="d-flex flex-row text-uppercase justify-content-around" style="font-size: 12px;">
                <p></p>
                <p></p>
                <p></p>
                <p></p>
                <p class="mb-0 pb-0"><i class="fas fa-cart-arrow-down fa-3x text-success"></i></p>
                <p></p>

            </div>

            <!-- Progress bar starts -->
            <div class="progress" style="height: 10px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30.5%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; background-color: #e47911;"></div>
            </div>

            <div class="d-flex flex-row text-uppercase justify-content-around" style="font-size: 12px;">
                <p>sign in</p>
                <p class="font-weight-bold">delivery</p>
                <p class="text-muted">payment</p>
                <p class="text-muted">place order</p>
                <p class="text-muted">complete payment</p>
            </div>
        </div> <!-- Progress Status ends -->

        <h3>Review your order </h3>
        <p>By placing your order, you agree to Yourmarket 's privacy notice and conditions of use.</p>
        <div class="dropdown-divider"></div>


        <div class="row">
            <!-- Product details -->
            <div class="col-md-8">
                <!-- Address & Payment Detail -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Shipping Address -->
                                    <div class="col-md-4" style="font-size: 15px;">
                                        <u>
                                            <p class="my-0 py-0">Shipping Address</p>
                                        </u> <br>
                                        <p class="font-weight-bold my-0 py-0"><?= $addr['owner_name'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['city'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['address'] ?>, <?= $addr['postal_code'] ?></p>
                                        <p class="my-0 py-0" <?= $addr['state'] ?></p>
                                        <p class="my-0 py-0">Phone Number: <?= $addr['mobile_number'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['country'] ?></p>
                                    </div>
                                    <!-- Billing Address -->
                                    <div class="col-md-4" style="font-size: 15px;">
                                        <u>
                                            <p class=" my-0 py-0">Billing Address</p>
                                        </u> <br>
                                        <p class="font-weight-bold my-0 py-0"><?= $addr['owner_name'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['city'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['address'] ?>, <?= $addr['postal_code'] ?></p>
                                        <p class="my-0 py-0" <?= $addr['state'] ?></p>
                                        <p class="my-0 py-0">Phone Number: <?= $addr['mobile_number'] ?></p>
                                        <p class="my-0 py-0"><?= $addr['country'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Address & Payment Detail ends -->



                <?php foreach ($_SESSION['shopping_cart'] as $item) : $product = unserialize($item); ?>
                    <!-- Single Order Detail Card -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="row">

                                        <!-- Product Image Col -->
                                        <div class="col-md-2">
                                            <img src="img/product_images/product04.png" class="img-fluid" alt="product 04 image">
                                        </div>

                                        <!-- Product Detail Col -->
                                        <div class="col-md-6">
                                            <a href="<?= Navigation::product_page($product->get_id()) ?>"><?= $product->get_name() ?></a>
                                            <p class="text-muted my-0">Sold by : <?= $account_controller->get_account_name($product->get_seller_account_id()) ?></p>
                                            <p class="text-uppercase font-weight-bold my-0 text-danger">
                                                <span><?= $product->get_price() ?></span> <i class="fas fa-dollar-sign" style="font-size: 10px;"></i>
                                            </p>
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
                                        </div> <!-- Product Detail Col ends -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Single Order Detail Card ends -->
                <?php
                    $total_price += $product->get_price() * $product->get_quantity();
                    $total_item += $product->get_quantity();
                endforeach; ?>
            </div> <!-- Product details ends -->

            <!-- Place your order & pay -->
            <div class="col-md-4">
                <div class="card mt-md-0 mt-3">
                    <div class="card-body">
                        <form method="POST">
                            <button class="btn btn-sm btn-warning btn-block text-capitalize" name="purchase_shopping_bag">Purchase</button>
                        </form>
                        <br>
                        <p class="my-0">Order Summary</p>
                        <p style="font-size: 15px;" class="my-0">Items:
                            <span class="float-right">
                                <?= $total_price ?> <i class="fas fa-dollar-sign"></i>
                            </span>
                        </p>
                        <p style="font-size: 15px;" class="my-0">Delivery:
                            <span class="float-right">
                                0.00 <i class="fas fa-dollar-sign"></i>
                            </span>
                        </p>
                        <p style="font-size: 15px;" class="my-0">Subtotal : <?= $total_item ?> item(s)
                        </p>
                        <br>
                        <div class="dropdown-divider"></div>
                        <p class="my-0 text-danger font-weight-bold">Order Total:
                            <span class="float-right">
                                <?= $total_price ?> <i class="fas fa-dollar-sign"></i>
                            </span>
                        </p>

                    </div> <!-- Card body ends -->
                    <br>
                    <div class="card-footer">
                        <a href="#">How are delivery costs calculated ?</a>
                        <p>Yourmarket Prime Delivery has been applied to the eligible items in your order.</p>
                        <a href="<?= Navigation::shopping_cart_page() ?>" class="btn btn-danger btn-sm btn-block">Return to your shopping bag</a>
                    </div>
                </div>
            </div> <!-- Place your order & pay ends -->
        </div>

    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>

<?php

if (array_key_exists('purchase_shopping_bag', $_POST)) {
    $purchase_order_guid = trim(com_create_guid(), '{}');
    $purchase_order_builder = new PurchaseOrderBuilder();
    $purchase_order = $purchase_order_builder
        ->set_account_id($_SESSION['account']['id'])
        ->set_guid($purchase_order_guid)
        ->set_total_price($total_price)
        ->set_date(date("F j, Y"))
        ->build();

    if ($purchase_order_controller->create_purchase_order($purchase_order)) {
        $purchased_product_builder = new PurchasedProductBuilder();

        foreach ($_SESSION['shopping_cart'] as $item) {
            $product = unserialize($item);
            $purchased_product = $purchased_product_builder
                ->set_purchase_order_guid($purchase_order_guid)
                ->set_product_name($product->get_name())
                ->set_product_thumbnail($product->get_thumbnail())
                ->set_product_price($product->get_price() * $product->get_quantity())
                ->set_product_quantity($product->get_quantity())
                ->set_seller_account_id($product->get_seller_account_id())
                ->build();

            if (!$purchased_product_controller->create_purchased_product($purchased_product)) {
                echo "<script>alert('Error during the creation of the purchased product.')</script>";
            }
        }


        unset($_SESSION['shopping_cart']);
        $_SESSION['shopping_cart'] = array();

        $your_orders = Navigation::your_orders_page();
        echo "<script>alert('Successful payment.')</script>";
        echo "<script>window.location = '{$your_orders}';</script>";
    } else {
        echo "<script>alert('Error during the creation of the purchase order.')</script>";
    }
}
