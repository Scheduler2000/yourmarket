<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

</head>

<body>
    <?php include "components/navbar.php" ?>

    <div class="container w-50 mt-5 mb-5">
        <!-- URL Breadcrumb Starts -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent ml-n3">
                <li class="breadcrumb-item"><a href="<?= Navigation::your_account_page() ?>">Your Account</a></li>
                <li class="breadcrumb-item active text-danger" aria-current="page">Change Password</li>
            </ol>
        </nav> <!-- URL Breadcrumb Ends -->
        <br>
        <h3>Change Password</h3>

        <!-- Change Password Form Starts -->
        <form class="needs-validation w-85 mx-auto mt-5 font-weight-bold" method="post" action="<?= Navigation::change_password_handler() ?>">
            <div class="form-group">
                <label for="oldPassword">Old Password: </label>
                <input type="password" class="form-control" placeholder="******" name="old_password" id="oldPassword" required minlength="6">
                <br>
            </div>

            <div class="form-group">
                <label for="newPassword">New Password: </label>
                <input type="password" class="form-control" placeholder="******" name="new_password" id="newPassword" aria-describedby="passwordHelp" required minlength="6">
                <small id="passwordHelp" class="form-text text-muted"><i class="fas text-primary fa-info"></i> Password must be at least 6 characters.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="newPassword2">Re-Type New Password: </label>
                <input type="password" class="form-control" placeholder="******" id="newPassword2" aria-describedby="passwordHelp" required minlength="6">
                <small id="passwordHelp" class="form-text text-muted"><i class="fas text-primary fa-info"></i> Re-Type new password.</small>
            </div>
            <br><br>
            <button type="submit" class="btn btn-warning shadow btn-sm rounded">Update</button>
        </form> <!-- Change Password Form Ends -->
    </div>

    <?php include "components/footer.php" ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</body>