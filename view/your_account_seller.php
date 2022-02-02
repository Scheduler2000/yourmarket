<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../controller/navigation.php');
Navigation::init_navigation();

$account = $_SESSION['account'];

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

    <div class="container mt-5">
        <h2>Welcome <span style="font-style:italic; color:orangered"><?= $account['name'] ?></span> - Seller Account</h2> <br>
        <!-- Account Panel Starts -->
        <div class="row">
            <div class="col-md-4">
                <a href="<?= Navigation::your_account_page() ?>" class="w-100">
                    <div class="card" style="box-shadow: 0 0 10px orangered;">
                        <div class="card-body">
                            <h5 class="card-title fas fa-2x fa-door-open text-body"> &nbsp; Buyer Account</h5> <br>
                            <small class="text-muted">Return to your buyer account page.</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= Navigation::add_new_product_page() ?>" class="w-100">
                    <div class="card" style="box-shadow: 0 0 10px orangered;">
                        <div class="card-body">
                            <h5 class="card-title fas fa-2x fa-cart-plus text-body"> &nbsp; Add New Product</h5> <br>
                            <small class="text-muted">Create a new product to sell.</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= Navigation::product_list_page() ?>" class="w-100">
                    <div class="card" style="box-shadow: 0 0 10px orangered;">
                        <div class="card-body">
                            <h5 class="card-title fas fa-2x fa-list-ol text-body"> &nbsp; Product List</h5> <br>
                            <small class="text-muted">Check your all products.</small>
                        </div>
                    </div>
                </a>
            </div>
        </div> <!-- Account Panel Starts -->
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>