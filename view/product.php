<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/product_controller.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');
require_once(__DIR__ . '/../controller/database/product_feedback_controller.php');

Navigation::init_navigation();

$product_controller = new ProductController();
$feedback_controller = new ProductFeedbackController();
$account_controller = new AccountController();


$product = $product_controller->get_product($_GET['id']);
if ($product == null) {
    $index = -1;

    foreach ($_SESSION['shopping_cart'] as $key => $item) {
        if (unserialize($item)->get_id() == $_GET['id']) {
            $index = $key;
            break;
        }
    }

    if ($index != -1) {
        unset($_SESSION['shopping_cart'][$index]);
    }

    $home_page = Navigation::home_page();
    echo "<script>alert('Product doesn't exist anymore.')</script>";
    echo "<script>window.location = '{$home_page}';</script>";
}
$feedbacks = $feedback_controller->get_last_feedbacks($product->get_id(), 10);
$feedback_informations = $feedback_controller->get_feedback_infos($product->get_id());


if (array_key_exists('add_to_cart_btn', $_POST)) {
    if (!isset($_SESSION['account'])) { /* not connected */
        $login_page = Navigation::sign_in_page();
        echo "<script>window.location = '{$login_page}';</script>";
    }

    if ($product->is_buy_it_now()) {
        $already_in_shopping_cart = false;
        $index = -1;

        foreach ($_SESSION['shopping_cart'] as $key => $item) {
            if (unserialize($item)->get_id() == $product->get_id()) {
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
            array_push($_SESSION['shopping_cart'], serialize($product));

        $product_page = Navigation::product_page($product->get_id());
        echo "<script>window.location = '{$product_page}';</script>";
    } elseif ($product->is_auction() || $product->is_best_offer()) {
        if ($product_controller->update_price($product->get_id(), $_POST['auction_proposal'], $_SESSION['account']['id'])) {
            echo "<script>alert('proposal successfully completed.')</script>";
            header("Refresh:0");
        } else
            echo "<script>alert('proposal unsuccessfully completed.')</script>";
    }
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
        <!-- Top Page Design Starts -->
        <div class="row">
            <!-- Image Select Button starts  -->
            <div class="col-md-1">
                <button class="btn btn-sm bg-transparent">
                    <img width="45px" src="data:image;base64,<?= base64_encode($product->get_image1()) ?>" alt="btn image">
                </button>
                <button class="btn btn-sm bg-transparent">
                    <img width="45px" src="data:image;base64,<?= base64_encode($product->get_image2()) ?>" alt="btn image">
                </button>
                <button class="btn btn-sm bg-transparent">
                    <img width="45px" src="data:image;base64,<?= base64_encode($product->get_image3()) ?>" alt="btn image">
                </button>
                <button class="btn btn-sm bg-transparent">
                    <img width="45px" src="data:image;base64,<?= base64_encode($product->get_image4()) ?>" alt="btn image">
                </button>
            </div> <!-- Image Select Button Ends  -->

            <!-- Product Image Starts -->
            <div class="col-md-3">
                <img src="data:image;base64,<?= base64_encode($product->get_thumbnail()) ?>" class="img-fluid" alt="product image">
            </div> <!-- Product Image Ends -->

            <!-- Product Details Starts -->
            <div class="col-md-4">
                <h8><strong>Seller :</strong> <em><?= $account_controller->get_account_name($product->get_seller_account_id()) ?></em> </h8>
                <h6 class="font-weight-bold"><?= $product->get_name() ?> </h6>
                <p>
                    <?php for ($i = 0; $i < $feedback_informations->get_average(); $i++) : ?>
                        <i class="fas fa-star text-warning"></i>
                    <?php endfor; ?>

                    <?php for ($i = 0; $i < 5 - $feedback_informations->get_average(); $i++) : ?>
                        <i class="far fa-star text-warning"></i>
                    <?php endfor; ?>
                    &nbsp; <?= $feedback_informations->get_count_reviews() ?> Reviews
                </p>

                <div class="dropdown-divider mt-3"></div>
                <p class="mb-0">
                    <span class="text-muted mr-2">Price :</span>
                    <span class="text-danger font-weight-bold"><?= $product->get_price() ?> &nbsp;<i class="fas fa-dollar-sign"></i></span>

                    <?php if ($product->is_auction() || $product->is_best_offer()) : ?>
                        <br>
                        <span class="text-muted mr-2">Author :</span>
                        <span class="text-danger font-weight-bold">
                            <?php if ($product->get_account_id_last_proposal_auction() != null)
                                echo $account_controller->get_account_name($product->get_account_id_last_proposal_auction());
                            else
                                echo 'No proposal' ?>
                            &nbsp; <i class="fas fa-user"></i>
                        </span>
                        <br>
                        <?php if ($product->is_auction()) : ?>
                            <span class="text-muted mr-2">End of auction :</span>
                            <span class="text-danger font-weight-bold"><?= $product->get_end_of_auction() ?> &nbsp;<i class="far fa-calendar-alt"></i></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
                <div class="dropdown-divider mt-3"></div>

                <!-- Delivery Quality Images starts -->
                <div class="row" style="font-size: 12px; font-weight: bold;">
                    <div class="form-group">
                        <form method="POST">
                            <?php if ($product->is_auction() || $product->is_best_offer()) : ?>
                                <br>
                                <div class="form-outline">
                                    <input type="number" id="typeNumber" class="form-control" name="auction_proposal" min="<?= $product->get_price() + 1 ?>" required>
                                    <label class="form-label" for="typeNumber">price proposal</label>
                                </div>

                            <?php endif; ?>
                            <button class="btn btn-warning btn-sm  mt-3" type="submit" name="add_to_cart_btn">
                                <i class="fas fa-cart-plus float-left text-primary" style="font-size: 25px; width:80px;"></i>
                                <?= $product->get_type_of_sale()  == 0 || ($product->get_type_of_sale()) == 1 ? 'Make an offer' : 'Add to cart'; ?>

                            </button> &nbsp; &nbsp;
                        </form>
                    </div>

                    <div class="dropdown-divider"></div>
                    <a href="#">
                        <i class="fas fa-map-marker-alt text-dark"></i>
                        Select Delivery Location
                    </a>

                </div> <!-- Product Details Starts -->
            </div> <!-- Top Page Design Ends -->

            <div class="row border-bottom mt-3">
                <div class="col-md-12 my-3">
                    <h6 class="text-warning font-weight-bold">Product description</h6>
                    <p class="ml-3"><?= $product->get_description() ?> </p>
                </div>
            </div>


            <!-- Customer Review starts -->
            <div class="row my-5">
                <div class="col-md-4">
                    <p class="text-capitalize font-weight-bold">Reviewing article</p>
                    <a class="btn btn-sm bg-transparent" href="<?= !isset($_SESSION['account']) ? Navigation::sign_in_page() : Navigation::product_feedback_page(5, $product->get_id(), $product->get_seller_account_id()) ?>">
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                    </a>
                    <br>
                    <a class="btn btn-sm bg-transparent" href="<?= !isset($_SESSION['account']) ? Navigation::sign_in_page() : Navigation::product_feedback_page(4, $product->get_id(), $product->get_seller_account_id()) ?>">
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                    </a>
                    <br />
                    <a class="btn btn-sm bg-transparent" href="<?= !isset($_SESSION['account']) ? Navigation::sign_in_page() :  Navigation::product_feedback_page(3, $product->get_id(), $product->get_seller_account_id()) ?>">
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>

                    </a>
                    <br />
                    <a class="btn btn-sm bg-transparent" href="<?= !isset($_SESSION['account']) ? Navigation::sign_in_page() : Navigation::product_feedback_page(2, $product->get_id(), $product->get_seller_account_id()) ?>">
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                    </a>
                    <br />
                    <a class="btn btn-sm bg-transparent" href="<?= !isset($_SESSION['account']) ? Navigation::sign_in_page() : Navigation::product_feedback_page(1, $product->get_id(), $product->get_seller_account_id()) ?>">
                        <i class="fas fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                        <i class="far fa-star" style="color: #ffa41c;"></i>
                    </a>
                    <br />
                </div>

                <div class="col-md-8">
                    <?php foreach ($feedbacks as $fdb) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="text-dark" style="text-decoration: none;"> <?= $account_controller->get_account_name($fdb['author_account_id']) ?></span>
                                <p class="font-weight-bold mt-2">
                                    <?php for ($i = 0; $i < $fdb['rate']; $i++) : ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php endfor; ?>

                                    <?php for ($i = 0; $i < 5 - $fdb['rate']; $i++) : ?>
                                        <i class="far fa-star text-warning"></i>
                                    <?php endfor; ?>


                                    <?= $fdb['headline'] ?>.
                                </p>
                                <p> <?= $fdb['comment'] ?> </p>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-3"></div>
                    <?php endforeach; ?>
                </div>
            </div> <!-- Customer Review ends -->
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>