<?php

class FeedbackInformations
{
    private int $_count;
    private int $_average;


    public function get_count_reviews(): int
    {
        return $this->_count;
    }

    public function get_average(): int
    {
        return $this->_average;
    }


    public function __construct(int $count, int $average)
    {
        $this->_count = $count;
        $this->_average = $average;
    }
}
