<?php

class LogModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }
}
