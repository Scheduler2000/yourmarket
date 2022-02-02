<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/delivery_informations_controller.php');
Navigation::init_navigation();

if (!isset($_SESSION['account_id'])) {
    new Exception('SESSION ERROR');
}

$controller = new DeliveryInformationsController();
$addresses = $controller->get_delivery_informations($_SESSION['account']['id']);
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
    <div class="container mt-5 mb-5">
        <!-- URL Breadcrumb Starts -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent ml-n3">
                <li class="breadcrumb-item"><a href="<?= Navigation::your_account_page() ?>">Your Account</a></li>
                <li class="breadcrumb-item active text-danger" aria-current="page">Your Addresses</li>
            </ol>
        </nav> <!-- URL Breadcrumb Ends -->

        <h3>Your Addresses</h3>

        <!-- Address Card -->
        <div class="row">
            <div class="col-md-4 my-md-0 my-2">
                <a href="<?= Navigation::add_address_page() ?>" class="btn bg-transparent m-0 p-0">
                    <div class="card" style="width: 320px; height: 266px;border: 2px dashed #C7C7C7; ">
                        <div class="card-body mt-5">
                            <i class="fas fa-plus fa-3x" style="color: #C7C7C7;"></i>
                            <h5 class="card-title">Add address</h5>
                        </div>
                    </div>
                </a>
            </div>
            <?php foreach ($addresses as $addr) : ?>
                <div class="col-md-4 my-md-0 my-2">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <p class="text-muted p-0 m-0">Address: <i class="fas fa-home"></i></p>
                        </div>
                        <div class="card-body m-0 pt-1">
                            <p class="font-weight-bold my-0 py-0"><?= $addr['owner_name'] ?></p>
                            <p class="my-0 py-0"><?= $addr['city'] ?></p>
                            <p class="my-0 py-0"><?= $addr['address'] ?>, <?= $addr['postal_code'] ?></p>
                            <p class="my-0 py-0" <?= $addr['state'] ?></p>
                            <p class="my-0 py-0">Phone Number: <?= $addr['mobile_number'] ?></p>
                            <p class="my-0 py-0"><?= $addr['country'] ?></p>

                        </div>
                        <div class="card-footer bg-transparent">
                            <!-- <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
                            <a href="<?= Navigation::delete_address_handler($_SESSION['account']['id'], $addr['postal_code'], $addr['address'], $addr['owner_name']) ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>