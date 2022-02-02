<?php


class ProductFeedback
{
    private ?int $_id;
    private int $_item_id;
    private int $_rate;
    private string $_headline;
    private string $_comment;
    private int $_author_account_id;


    public function get_id(): int
    {
        return $this->_id;
    }

    public function get_item_id(): int
    {
        return $this->_item_id;
    }

    public function get_rate(): int
    {
        return $this->_rate;
    }

    public function get_headline(): string
    {
        return $this->_headline;;
    }

    public function get_comment(): string
    {
        return $this->_comment;;
    }

    public function get_author_account_id(): int
    {
        return $this->_author_account_id;
    }


    public function __construct(array $data)
    {
        $this->_id = $data['id'] ?? null;
        $this->_item_id = $data['item_id'];
        $this->_rate = $data['rate'];
        $this->_headline = $data['headline'];
        $this->_comment = $data['comment'];
        $this->_author_account_id = $data['author_account_id'];
    }
}
