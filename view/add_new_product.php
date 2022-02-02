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
        <!-- URL Breadcrumb Starts -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent ml-n3">
                <li class="breadcrumb-item"><a href="<?= Navigation::your_account_seller_page() ?>">Your Seller Account</a></li>
                <li class="breadcrumb-item active text-danger" aria-current="page">Add New Product</li>
            </ol>
        </nav> <!-- URL Breadcrumb Ends -->

        <h3>Add New Product</h3>


        <!-- Product Form Starts -->
        <form action="<?= Navigation::add_product_handler() ?>" method="POST" class="my-3" enctype="multipart/form-data">

            <!-- Select Category Starts -->
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <label for="productCategory" class="font-weight-bold mt-1">Type of sale :&nbsp; </label>
                    <select class="form-control d-inline ml-3" style="width: 150px;" id="type_of_sale" name="type_of_sale">
                        <option value="0">Best offer</option>
                        <option value="1">Auction</option>
                        <option value="2">Buy it now</option>
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <label for="productCategory" class="font-weight-bold mt-1">Category :&nbsp; </label>
                    <select class="form-control d-inline ml-3" style="width: 150px;" id="product_category" name="product_category">
                        <option value="1">Suit</option>
                        <option value="2">Sneaker</option>
                    </select>
                </div>
            </div>

            <!-- Select Category Ends -->

            <br>

            <!-- Product General Info Card Starts -->
            <div class="card mx-auto" style="width: 50rem;">
                <div class="card-header bg-warning">
                    <p class="font-weight-bold mb-0">Product General Information</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="productTitle">Product Title :</label>
                        <input type="text" placeholder="ABC Product" class="form-control" id="productTitle" name="product_title" required>
                    </div>

                    <div class="form-group">
                        <label for="productDescription">Description :</label>
                        <textarea class="form-control" id="productDescription" rows="3" name='product_description' required></textarea>
                        <small class="text-muted font-weight-bold">Write description of your product.</small>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Product Price :</label>
                        <input type="text" placeholder="150.00 $" class="form-control" id="productPrice" name="product_price" required>
                    </div>

                    <div id="auction_form" class="form-group" hidden>
                        <label for="productPrice">End of auction :</label>
                        <input type="date" class="form-control" id="end_of_auction" name="end_of_auction">
                    </div>

                </div>
            </div> <!-- Product General Info Card Ends -->

            <!-- Search Page Image Card Starts -->
            <div class="card mx-auto mt-3" style="width: 50rem;">
                <div class="card-header bg-warning">
                    <p class="font-weight-bold mb-0">Search Image Upload</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchPageImage">Search Page Image:</label>
                                <input type="file" class="form-control-file" id="searchPageImage" name='thumbnail_picture' required>
                                <small class="text-muted font-weight-bold">(width -> [130px; 170px] && height -> [218px; 300px])</small>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <img src="<?= Navigation::image_folder() ?>/search_page_image.png" class="img-fluid" alt="search page image">
                        </div>
                    </div>
                </div>
            </div> <!-- Search Page Image Card Ends -->

            <!-- Product Main Page Image Card Starts -->
            <div class="card mx-auto mt-3" style="width: 50rem;">
                <div class="card-header bg-warning">
                    <p class="font-weight-bold mb-0">Product Main Page Image Upload</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="searchPageImage1">Product Main Page Image 01:</label>
                                <input type="file" class="form-control-file" id="searchPageImage1" name="image_1" required>
                            </div>
                            <div class="form-group">
                                <label for="searchPageImage2">Product Main Page Image 02:</label>
                                <input type="file" class="form-control-file" id="searchPageImage2" name="image_2" required>
                            </div>
                            <div class="form-group">
                                <label for="searchPageImage3">Product Main Page Image 03:</label>
                                <input type="file" class="form-control-file" id="searchPageImage3" name="image_3" required>
                            </div>
                            <div class="form-group">
                                <label for="searchPageImage4">Product Main Page Image 04:</label>
                                <input type="file" class="form-control-file" id="searchPageImage4" name="image_4" required>
                            </div>
                            <small class="text-muted font-weight-bold">(width -> [500px; 650px] && height -> [618px; 700px])</small>
                        </div>

                        <div class="col-md-8">
                            <img src="<?= Navigation::image_folder() ?>/product_main_page_image.png" class="img-fluid" alt="search page image">
                        </div>
                    </div>
                </div>
            </div> <!-- Product Main Page Image Card Ends -->

            <div class="card mt-3 mx-auto" style="width: 50rem;">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <div class="card-body py-0">
                        <i class="fas fa-cart-plus fa-3x"> Create</i>
                    </div>
                </button>
            </div>
        </form>

    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

    <script>
        $('#type_of_sale').on('change', function(event) {
            if (this.value == 1 && $('#auction_form').is(':hidden')) {
                $('#auction_form').removeAttr('hidden');
            } else if (this.value != 1 && !$('#auction_form').is(':hidden')) {
                $('#auction_form').attr('hidden', true);
            }
        })
    </script>

</body>