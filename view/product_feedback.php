<?php
require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/product_controller.php');
require_once(__DIR__ . '/../controller/database/account_controller.php');

Navigation::init_navigation();
$product_controller = new ProductController();
$account_controller = new AccountController();

$product = $product_controller->get_product($_GET['pid']);
$seller_name = $account_controller->get_account_name($_GET['aid']);
$rating = $_GET['rating'] ?? 5;
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

    <!-- Product Review Starts -->
    <div class="container my-5">
        <h3>Leave seller feedback</h3>
        <p>Product : <strong><?= $product->get_name() ?></strong> sold by <em><?= $seller_name ?></em> </p>
        <div class="dropdown-divider my-3"></div>

        <h4>Overall Rating</h4>
        <!-- Rating Buttons -->

        <?php for ($i = 0; $i < $rating; $i++) : ?>
            <i class="fas fa-star text-warning fa-3x"></i>
        <?php endfor; ?>

        <?php for ($i = 0; $i < 5 - $rating; $i++) : ?>
            <i class="far fa-star text-warning fa-3x"></i>
        <?php endfor; ?>




        <div class="dropdown-divider my-3"></div>

        <form method="POST" class="p-5 bg-light rounded" action="<?= Navigation::add_feedback_handler() ?>">
            <div class="form-group">
                <label for="headline" class="font-weight-bold h5">Add a headline</label>
                <input type="text" placeholder="create a headline for your review" name="headline" class="form-control" id="headline" required>
                <br>
            </div>
            <div class="form-group">
                <label for="review" class="font-weight-bold h5">Comments:</label>
                <textarea class="form-control" id="review" name="comments" rows="5" placeholder="write your comments" required></textarea>
            </div>
            <input type="text" name="pid" value="<?= $_GET['pid'] ?>" hidden>
            <input type="text" name="rating" value="<?= $_GET['rating'] ?>" hidden>
            <input type="text" name="seller_aid" value="<?= $_GET['aid'] ?>" hidden>
            <br>
            <button type="submit" class="btn btn-warning rounded-pill font-weight-bold">Submit feedback</button>
        </form>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>