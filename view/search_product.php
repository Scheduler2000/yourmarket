<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/product_controller.php');
require_once(__DIR__ . '/../controller/database/product_feedback_controller.php');

Navigation::init_navigation();

$product_controller = new ProductController();
$feedback_controller = new ProductFeedbackController();

if (!isset($_GET['category'])) $_GET['category'] = 'all';
if (!isset($_GET['filter'])) $_GET['filter'] = '';

$products = $product_controller->get_products($_GET['category'], $_GET['filter']);




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
                <h1><em><?= count($products) ?> Result(s)</em></h1>
                <h10><em>Category : <?= $_GET['category'] ?></em></h10> <br>
                <h10><em>Filter : <?= $_GET['filter'] == '' ? 'empty' : $_GET['filter'] ?></em></h10> <br>
                <br>
                <!-- Single product detail starts -->
                <?php foreach ($products as $product) : $fdb = $feedback_controller->get_feedback_infos($product['id']); ?>
                    <div class="row border-top py-3">
                        <!-- Product image starts -->
                        <div class="col-md-4 text-center">
                            <img src="data:image;base64,<?= base64_encode($product['thumbnail']) ?>" alt="btn image">
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
                                    150 <i class="fas fa-dollar-sign" style="font-size: 18;"></i> &nbsp; &nbsp;

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