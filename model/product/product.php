<?php


class Product
{
    private ?int $_id;
    private int $_quantity; /* in shopping_cart*/
    private int $_seller_account_id;
    private string $_name;
    private string $_description;
    private float $_price;
    private string $_thumbnail;
    private string $_image1;
    private string $_image2;
    private string $_image3;
    private string $_image4;
    private ?string $_end_of_auction;
    private ?int $_account_id_last_proposal_auction;
    private int $_category;
    private int $_type_of_sale;
    private array $_data;

    public function get_id(): int
    {
        return $this->_id;
    }

    public function get_seller_account_id(): int
    {
        return $this->_seller_account_id;
    }

    public function get_name(): string
    {
        return $this->_name;
    }

    public function get_description(): string
    {
        return $this->_description;
    }

    public function get_price(): float
    {
        return $this->_price;
    }

    public function get_thumbnail(): string
    {
        return $this->_thumbnail;
    }

    public function get_image1(): string
    {
        return $this->_image1;
    }

    public function get_image2(): string
    {
        return $this->_image2;
    }

    public function get_image3(): string
    {
        return $this->_image3;
    }

    public function get_image4(): string
    {
        return $this->_image4;
    }

    public function get_category(): int
    {
        return $this->_category;
    }

    public function get_type_of_sale(): int
    {
        return $this->_type_of_sale;
    }

    public function get_data(): array
    {
        return $this->_data;
    }

    public function get_quantity(): int
    {
        return $this->_quantity;
    }

    public function get_account_id_last_proposal_auction(): ?int
    {
        return $this->_account_id_last_proposal_auction;
    }

    public function get_end_of_auction(): ?string
    {
        return $this->_end_of_auction;
    }

    public function increment_quantity(): void
    {
        $this->_quantity += 1;
    }

    public function decrement_quantity(): void
    {
        $this->_quantity -= 1;
    }

    public function is_auction(): bool
    {
        return $this->_type_of_sale == 1;
    }

    public function is_best_offer(): bool
    {
        return $this->_type_of_sale == 0;
    }

    public function is_buy_it_now(): bool
    {
        return $this->_type_of_sale == 2;
    }


    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->_id = $data['id'] ?? null;
        $this->_seller_account_id = $data['seller_account_id'];
        $this->_name = $data['name'];
        $this->_description = $data['description'];
        $this->_price = $data['price'];
        $this->_thumbnail = $data['thumbnail'];
        $this->_image1 = $data['image_1'];
        $this->_image2 = $data['image_2'];
        $this->_image3 = $data['image_3'];
        $this->_image4 = $data['image_4'];
        $this->_category = $data['category'];
        $this->_type_of_sale = $data['type_of_sale'];
        $this->_end_of_auction = $data['end_of_auction'] ?? null;
        $this->_account_id_last_proposal_auction = $data['account_id_last_proposal_auction'] ?? null;
        $this->_quantity = 1;
    }
}
