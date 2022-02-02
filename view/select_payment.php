<?php
require_once(__DIR__ . '/../controller/navigation.php');
Navigation::init_navigation();
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
            </div>

            <!-- Progress bar starts -->
            <div class="progress" style="height: 10px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%; background-color: #e47911;"></div>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30.5%; background-color: #e47911;"></div>
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

        <h3>Payment Informations</h3>
        <p class="my-0 py-0">Get Instant refund on cancellations | Zero payment failures </p>
        <div class="dropdown-divider"></div>
        <br>

        <!-- Select payment method -->
        <div class="row">
            <!-- payment method select -->
            <div class="col-md-8">

                <div class="card p-2">
                    <form method="POST" action="<?= Navigation::review_order_page() ?>">
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example1" class="form-control" required />
                                    <label class="form-label" for="form3Example1">Name on card</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example2" class="form-control" required />
                                    <label class="form-label" for="form3Example2">Card number</label>
                                </div>
                            </div>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="date" id="form3Example3" class="form-control" required />
                            <label class="form-label" for="form3Example3"></label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="form3Example4" class="form-control" required />
                            <label class="form-label" for="form3Example4">CVV</label>
                        </div>


                        <!-- Submit button -->
                        <button type="submit" class="btn btn-warning btn-block btn-sm">Continue</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>