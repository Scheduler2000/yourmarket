

<?php

class Navigation
{
    private static string $_root_folder;


    public static function init_navigation()
    {
        self::$_root_folder = 'http://' .  $_SERVER['HTTP_HOST'] . '/yourmarket';
    }

    public static function home_page(): string
    {
        return self::$_root_folder . '/index.php';
    }

    public static function register_page(): string
    {
        return self::$_root_folder . '/view/register.php';
    }

    public static function sign_in_page(): string
    {
        return self::$_root_folder . '/view/sign_in.php';
    }

    public static function product_page(int $id): string
    {
        return self::$_root_folder . '/view/product.php?id=' . $id;
    }

    public static function your_account_page(): string
    {
        return self::$_root_folder . '/view/your_account.php';
    }

    public static function your_orders_page(): string
    {
        return self::$_root_folder . '/view/your_orders.php';
    }

    public static function change_passowrd_page(): string
    {
        return self::$_root_folder . '/view/change_password.php';
    }

    public static function your_addresses_page(): string
    {
        return self::$_root_folder . '/view/your_addresses.php';
    }

    public static function edit_address_page(): string
    {
        return self::$_root_folder . '/view/edit_address.php';
    }

    public static function add_address_page(): string
    {
        return self::$_root_folder . '/view/add_address.php';
    }

    public static function shopping_cart_page(): string
    {
        return self::$_root_folder . '/view/shopping_cart.php';
    }

    public static function select_address_page(): string
    {
        return self::$_root_folder . '/view/select_address.php';
    }

    public static function select_payment_page(): string
    {
        return self::$_root_folder . '/view/select_payment.php';
    }

    public static function review_order_page(): string
    {
        return self::$_root_folder . '/view/review_order.php';
    }

    public static function login_handler(): string
    {
        return self::$_root_folder . '/handler/login_handler.php';
    }

    public static function register_handler(): string
    {
        return self::$_root_folder . '/handler/register_handler.php';
    }

    public static function change_password_handler(): string
    {
        return self::$_root_folder . '/handler/change_password_handler.php';
    }

    public static function add_address_handler(): string
    {
        return self::$_root_folder . '/handler/add_address_handler.php';
    }

    public static function delete_address_handler(int $account_id, string $zip, string $addr, string $owner): string
    {
        return self::$_root_folder . '/handler/delete_address_handler.php
        ?account_id=' . $account_id . '&zip=' . $zip . '&addr=' . $addr . '&owner=' . $owner;
    }

    public static function product_feedback_page(int $rating, int $product_id, int $seller_account_id): string
    {
        return self::$_root_folder . '/view/product_feedback.php?rating=' . $rating . '&pid=' . $product_id . '&aid=' . $seller_account_id;
    }

    public static function your_account_seller_page(): string
    {
        return self::$_root_folder . '/view/your_account_seller.php';
    }

    public static function add_new_product_page(): string
    {
        return self::$_root_folder . '/view/add_new_product.php';
    }

    public static function image_folder(): string
    {
        return self::$_root_folder . '/static/images';
    }

    public static function add_product_handler(): string
    {
        return self::$_root_folder . '/handler/add_product_handler.php';
    }

    public static function add_feedback_handler(): string
    {
        return self::$_root_folder . '/handler/add_feedback_handler.php';
    }

    public static function product_list_page(): string
    {
        return self::$_root_folder . '/view/product_list.php';
    }

    public static function log_off_handler(): string
    {
        return self::$_root_folder . '/handler/log_off_handler.php';
    }

    public static function search_product_page(): string
    {
        return self::$_root_folder . '/view/search_product.php';
    }
}
