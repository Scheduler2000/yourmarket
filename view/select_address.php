<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');
require_once(__DIR__ . '/../controller/database/delivery_informations_controller.php');

Navigation::init_navigation();

$controller = new DeliveryInformationsController();
$addresses = $controller->get_delivery_informations($_SESSION['account']['id']);

if (!empty($_POST)) {
    $selected_address_index =  array_key_first($_POST);
    $_SESSION['selected_address_index'] = $selected_address_index;

    $payment_page = Navigation::select_payment_page();
    echo "<script>window.location = '{$payment_page}';</script>";
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
                <p class="mb-0 pb-0"><i class="fas fa-cart-arrow-down fa-3x text-success"></i></p>
                <p></p>
                <p></p>
            </div>

            <!-- Progress bar starts -->
            <div class="progress" style="height: 10px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 12.5%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%; background-color: #e47911;"></div>
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

        <h3>Select a delivery address</h3>
        <p>Is the address you'd like to use displayed below? If so, click the corresponding "Deliver to this address"
            button.</p> <br>
        <p>If you don't have an address, please register your address in your account panel.
        </p>

        <div class="dropdown-divider"></div>


        <?php foreach ($addresses as $key => $addr) : ?>
            <div class="card my-3" style="width: 18rem;">
                <div class="card-body">
                    <p class="font-weight-bold my-0 py-0"><?= $addr['owner_name'] ?></p>
                    <p class="my-0 py-0"><?= $addr['city'] ?></p>
                    <p class="my-0 py-0"><?= $addr['address'] ?>, <?= $addr['postal_code'] ?></p>
                    <p class="my-0 py-0" <?= $addr['state'] ?></p>
                    <p class="my-0 py-0">Phone Number: <?= $addr['mobile_number'] ?></p>
                    <p class="my-0 py-0"><?= $addr['country'] ?></p>
                    <form method="POST">
                        <button name=<?= $key ?> class="btn btn-warning btn-block mt-3 btn-sm">Deliver to this address</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>