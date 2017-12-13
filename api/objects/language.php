<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 8:45
 */

class Language
{
    private $conn;
    private $table_name = "language";

    public $id;
    public $language;
    public $code;
    public $country;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * FROM language ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}