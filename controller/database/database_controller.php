<?php

abstract class DatabaseController
{
    protected PDO $_database;

    protected function __construct()
    {
        $this->_database =
            new PDO('mysql:host=localhost;dbname=yourmarket;charset=utf8', 'root', '');

        $this->_database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    }
}
