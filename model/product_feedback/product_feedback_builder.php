<?php

require_once('product_feedback.php');

class ProductFeedbackBuilder
{
    private array $_underlying;

    public function set_item_id(int $product_id): ProductFeedbackBuilder
    {
        $this->_underlying['item_id'] = $product_id;
        return $this;
    }

    public function set_rate(int $rate): ProductFeedbackBuilder
    {
        $this->_underlying['rate'] = $rate;
        return $this;
    }

    public function set_headline(string $headline): ProductFeedbackBuilder
    {
        $this->_underlying['headline'] = $headline;
        return $this;
    }

    public function set_comment(string $comment): ProductFeedbackBuilder
    {
        $this->_underlying['comment'] = $comment;
        return $this;
    }

    public function set_author_account_id(int $author_account_id): ProductFeedbackBuilder
    {
        $this->_underlying['author_account_id'] = $author_account_id;
        return $this;
    }

    public function build(): ProductFeedback
    {
        return new ProductFeedback($this->_underlying);
    }
}
