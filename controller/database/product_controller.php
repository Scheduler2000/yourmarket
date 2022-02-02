<?php
require_once('database_controller.php');
require_once(__DIR__ . '/../../model/product/product.php');

class ProductController extends DatabaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_product(Product $product): int /* 0 => success / 2 => error on query */
    {
        $sql = "INSERT INTO product (seller_account_id, name, description, price, category, type_of_sale, thumbnail, image_1, image_2, image_3, image_4, end_of_auction, account_id_last_proposal_auction) VALUES (:seller_account_id,:name,:description,:price,:category,:type_of_sale,:thumbnail,:image_1,:image_2,:image_3,:image_4,:eoa,:author_auction)";


        $query = $this->_database->prepare($sql);
        $res = $query->execute(array(
            'seller_account_id' => $product->get_seller_account_id(),
            'name' => $product->get_name(),
            'description' => $product->get_description(),
            'price' => $product->get_price(),
            'category' => $product->get_category(),
            'type_of_sale' => $product->get_type_of_sale(),
            'thumbnail' => $product->get_thumbnail(),
            'image_1' => $product->get_image1(),
            'image_2' => $product->get_image2(),
            'image_3' => $product->get_image3(),
            'image_4' => $product->get_image4(),
            'eoa' => $product->get_end_of_auction(),
            'author_auction' => $product->get_account_id_last_proposal_auction()
        ));

        return $res ? 0 : 2;
    }

    public function delete_product(int $product_id): bool
    {
        $sql = 'DELETE FROM product WHERE id = :pid';

        $query = $this->_database->prepare($sql);

        return $query->execute(array('pid' => $product_id));
    }

    public function get_last_produces(int $count): ?array
    {
        $sql = 'SELECT * from product ORDER BY id ASC LIMIT :count';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('count' => $count)))
            return null;

        return $query->fetchAll();
    }

    public function get_product(int $id): ?Product
    {
        $sql = 'SELECT * from product WHERE id = :id';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('id' => $id)))
            return null;
        $data = $query->fetch();

        return $data == null ? null : new Product($data);
    }

    public function get_all_products(int $seller_account_id): ?array
    {
        $sql = 'SELECT * FROM product WHERE seller_account_id = :id';

        $query = $this->_database->prepare($sql);

        if (!$query->execute(array('id' => $seller_account_id)))
            return null;

        return $query->fetchAll();
    }

    public function update_price(int $product_id, float $new_price, int $author_auction): bool
    {
        $sql = 'UPDATE product SET price = :new_price, account_id_last_proposal_auction = :aid WHERE id = :pid';

        $query = $this->_database->prepare($sql);

        return $query->execute(array(
            'new_price' => $new_price,
            'pid' => $product_id,
            'aid' => $author_auction
        ));
    }

    public function get_products(string $category, string $filter): ?array
    {
        if ($category == 'all' && $filter == '') {
            $sql = 'SELECT * FROM product';

            $query = $this->_database->prepare($sql);

            if (!$query->execute())
                return null;

            return $query->fetchAll();
        } elseif ($filter == '' && $category != 'all') {
            $sql = 'SELECT * FROM product WHERE category = :category';

            $query = $this->_database->prepare($sql);

            if (!$query->execute(array('category' => $category == 'suits' ? 1 : 2)))
                return null;

            return $query->fetchAll();
        } elseif ($category == 'all' && $filter != '') {
            $sql = "SELECT * FROM product WHERE name LIKE '%$filter%'";

            $query = $this->_database->prepare($sql);

            if (!$query->execute())
                return null;

            return $query->fetchAll();
        } else {
            $sql = "SELECT * FROM product WHERE name LIKE '%$filter%' AND category = :category";

            $query = $this->_database->prepare($sql);

            if (!$query->execute(array('category' => $category == 'suits' ? 1 : 2)))
                return null;

            return $query->fetchAll();
        }
    }
}
