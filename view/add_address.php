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

    <div class="container mt-5 mb-5">
        <!-- URL Breadcrumb Starts -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent ml-n3">
                <li class="breadcrumb-item"><a href="<?= Navigation::your_account_page() ?>">Your Account</a></li>
                <li class="breadcrumb-item"><a href="<?= Navigation::your_addresses_page() ?>">Your Addresses</a></li>
                <li class="breadcrumb-item active text-danger" aria-current="page">New Address</li>
            </ol>
        </nav> <!-- URL Breadcrumb Ends -->

        <h3 class="font-weight-bold">Add a new address</h3>
        <br>
        <!-- New Address Form Starts -->
        <form class="mx-auto font-weight-bold needs-validation" autocomplete="off" method="post" action="<?= Navigation::add_address_handler() ?>">
            <div class="form-group">
                <label for="country">Country</label>
                <select class="form-control" id="country" name="country" required>
                    <option value="France">France</option>
                    <option value="United-States">USA</option>
                    <option value="England">England</option>
                    <option value="Algeria">Algeria</option>
                    <option value="Italia">Italia</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="username">Full name</label>
                <input type="text" class="form-control" id="username" name="owner_name" placeholder="owner's name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="mobileNumber">Mobile number</label>
                <input type="text" class="form-control" id="mobileNumber" name="mobile_number" placeholder="10-digit mobile number" required>
                <small>May be used to assist delivery</small>
            </div>
            <br>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" placeholder="state / region" required>
            </div>
            <br>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="city" required>
            </div>
            <br>
            <div class="form-group">
                <label for="zip">Postal Code</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="postal code" required>
            </div>
            <br>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder='full address' required>
            </div>
            <br>
            <button type="submit" class="btn btn-warning shadow rounded">Add address</button>
        </form>

    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>