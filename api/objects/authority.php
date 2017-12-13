<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 8:37
 */

class Authority
{
    private $conn;
    private $table_name = "authority";

    public $id;
    public $name;

    public function __construct($db){
        $this->conn = $db;
    }
}