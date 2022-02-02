<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../controller/navigation.php');
require_once(__DIR__ . '/../../model/product/product.php');
Navigation::init_navigation();

if (isset($_SESSION['shopping_cart'])) {
    $shopping_cart_size = 0;


    foreach ($_SESSION['shopping_cart'] as $item) {
        $product = unserialize($item);
        $shopping_cart_size += $product->get_quantity();
    }
}
?>

<nav class="navbar navbar-expand-md" style="background-color: #424242;">
    <!-- Drawer Start -->
    <a class="navbar-brand" href="<?= Navigation::home_page() ?>" style="color: orangered"><em> &nbsp; Your Market</em></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search Bar Starts -->
        <form class="form-inline px-lg-5" novalidate method="get">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown_categories" data-mdb-toggle="dropdown" aria-expanded="false">
                            All
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" id="all">All</a></li>
                            <li><a class="dropdown-item" id="suits">Suits</a></li>
                            <li><a class="dropdown-item" id="sneakers">Sneakers</a></li>
                        </ul>
                    </div>
                </div>
                <input type="text" placeholder="Search bar" id="search_bar" class="form-control" size="50>
                <div class=" input-group-append">
                <a href="" id="search_btn" type="submit" class="btn btn-warning" onclick="">
                    <i class="fas fa-search"></i>
                </a>
            </div>
    </div>
    </form> <!-- Search Bar Ends -->
    <ul class="navbar-nav">
        <!-- User Account Starts -->
        <?php if (isset($_SESSION['account'])) : ?>
            <li class="nav-item dropdown px-2">
                <a class="nav-link" href="<?= Navigation::your_account_page() ?>" id="userAccount" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-2x fa-user-circle"></i>
                </a>
            </li>
        <?php else : ?>
            <li class="nav-item dropdown px-2">
                <a class="nav-link" href="#" id="userAccount" role="button" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-2x fa-user-circle"></i>
                </a>
                <div class="dropdown-menu px-3" aria-labelledby="userAccount">
                    <br>
                    <a href="<?= Navigation::sign_in_page() ?>" class="dropdown-item btn btn-warning w-75 btn-sm font-weight-bold">Sign In</a>
                    <br> <small>New customer ?<a href="<?= Navigation::register_page() ?>"> <br> Start here.</a></small>
                </div>
            </li>
        <?php endif; ?>
        <!-- User Account Ends -->
        <!-- Shopping Cart Starts -->
        <li class="nav-item px-2">
            <a class="nav-link" href="<?= isset($_SESSION['shopping_cart']) ? Navigation::shopping_cart_page() : Navigation::sign_in_page() ?>"" aria-disabled=" true">
                <i class="fas fa-2x text-light fa-shopping-cart"></i>
                <?php if (isset($_SESSION['shopping_cart']) && $shopping_cart_size > 0) : ?>
                    <span class="badge bg-danger ms-2"><?= $shopping_cart_size ?></span>
                <?php endif; ?>
            </a>
        </li> <!-- Shopping Cart Starts -->
    </ul>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<script>
    let selected = 'all';

    $(document).keypress(
        function(event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });

    $('ul li').click(function(event) {
        $('#dropdown_categories').html(event.target.id);
        selected = event.target.id;
    })
    $('#search_btn').click(function(event) {
        $('#search_btn').attr('href', '<?= Navigation::search_product_page() ?>?category=' + selected + '&filter=' + $('#search_bar').val())
    });
</script>