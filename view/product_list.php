<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/product_controller.php');
require_once(__DIR__ . '/../controller/database/product_feedback_controller.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');

require_once(__DIR__ . '/../controller/database/purchase_order_controller.php');
require_once(__DIR__ . '/../controller/database/purchased_product_controller.php');

require_once(__DIR__ . '/../model/purcharse_order/purchase_order_builder.php');
require_once(__DIR__ . '/../model/purcharse_order/purchase_order.php');

require_once(__DIR__ . '/../model/purchased_product/purchased_product.php');
require_once(__DIR__ . '/../model/purchased_product/purchased_product_builder.php');


Navigation::init_navigation();

$product_controller = new ProductController();
$feedback_controller = new ProductFeedbackController();

$products = $product_controller->get_all_products($_SESSION['account']['id']);


if (array_key_exists('delete_product', $_POST) && isset($_POST['product_id'])) {
    $product = $product_controller->get_product($_POST['product_id']);

    if (($product->is_auction() || $product->is_best_offer()) && $product->get_account_id_last_proposal_auction() != null) {
        $purchase_order_controller = new PurchaseOrderController();
        $purchased_product_controller = new PurchasedProductController();

        $purchase_order_guid = trim(com_create_guid(), '{}');
        $purchase_order_builder = new PurchaseOrderBuilder();
        $purchase_order = $purchase_order_builder
            ->set_account_id($product->get_account_id_last_proposal_auction())
            ->set_guid($purchase_order_guid)
            ->set_total_price($product->get_price())
            ->set_date(date("F j, Y"))
            ->build();

        if ($purchase_order_controller->create_purchase_order($purchase_order)) {
            $purchased_product_builder = new PurchasedProductBuilder();

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
            } else {
                $account_controller = new AccountController();
                $owner = $account_controller->get_account_name($product->get_account_id_last_proposal_auction());

                if ($product->is_auction())
                    echo "<script>alert('Prematurely ended auction, the winning bidder of the auction that you have offered is $owner.') </script>";
                else
                    echo "<script>alert('The winning bidder of the best_offer is $owner.') </script>";
            }
        }
    }
    if (!$product_controller->delete_product($_POST['product_id']))
        echo "<script>alert('An error occurred while requesting the database.')</script>";
    else {
        if (!$feedback_controller->delete_feedbacks($_POST['product_id']))
            echo "<script>alert('An error occurred while requesting the database.')</script>";
    }
    header("Refresh:0");
}


function compute_category($category_code)
{
    return $category_code == 1 ?  'Suit' : 'Sneaker';
}

function compute_type_of_sale($type_of_sale_code)
{
    return ($type_of_sale_code == 0 ? 'Best offer' : ($type_of_sale_code == 1)) ? 'Auction' : 'Buy it now';
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

    <div class="container my-5">
        <div class="row">
            <!-- Product list starts -->
            <div class="col-md-9">
                <h1><em>Product List</em></h1> <br>
                <!-- Single product detail starts -->
                <?php foreach ($products as $product) : $fdb = $feedback_controller->get_feedback_infos($product['id']); ?>
                    <div class="row border-top py-3">
                        <!-- Product image starts -->
                        <div class="col-md-4 text-center">
                            <img src="data:image;base64,<?= base64_encode($product['thumbnail']) ?>" alt="product image 01">
                        </div> <!-- Product image ends -->

                        <!-- Product details starts -->
                        <div class="col-md-8">
                            <a href="<?= Navigation::product_page($product['id']) ?>"><?= $product['name'] ?></a>
                            <p class="text-muted my-0">Category : <?= compute_category($product['category']) ?></p>
                            <p class="text-muted my-0">Type of sale : <?= compute_type_of_sale($product['type_of_sale']) ?> </p>
                            <p class="text-muted my-0"><?= $fdb->get_count_reviews() ?> Review(s)</p>
                            <?php for ($i = 0; $i < $fdb->get_average(); $i++) : ?>
                                <i class="fas fa-star text-warning"></i>
                            <?php endfor; ?>

                            <?php for ($i = 0; $i < 5 - $fdb->get_average(); $i++) : ?>
                                <i class="far fa-star text-warning"></i>
                            <?php endfor; ?>
                            <form method="POST">
                                <p class="text-uppercase my-0 font-weight-bold text-danger">
                                    <?= $product['price'] ?> <i class="fas fa-dollar-sign" style="font-size: 18;"></i> &nbsp; &nbsp;

                                    <button type="submit" name="delete_product" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    <input type="text" value="<?= $product['id'] ?>" name="product_id" hidden>
                                </p>

                            </form>
                        </div> <!-- Product details ends -->

                    </div> <!-- Product list ends -->
                <?php endforeach; ?>

            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>