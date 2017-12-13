<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 8:43
 */

class Index
{
    private $conn;
    private $table_name = "index";

    public $id;
    public $name;
    public $parent_id;
    public $category_id;

    public function __construct($db){
        $this->conn = $db;
    }

    function readOne(){
        $query = "SELECT * from index_category ic LEFT JOIN `index` i ON ic.id = i.category_id WHERE ic.id = 1 AND i.id = ?";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->parent_id = $row['parent_id'];
        $this->category_id = $row['category_id'];
    }

    function readByCategory($categoryID){
        $query = "SELECT i.*, ic.id as category_id, ic.name as category_name from index_category ic LEFT JOIN `index` i ON ic.id = i.category_id WHERE ic.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $categoryID);
        $stmt->execute();
        return $stmt;
    }

    function read(){
        $query = "SELECT i.*, ic.id as category_id, ic.name as category_name from index_category ic LEFT JOIN `index` i ON ic.id = i.category_id WHERE ic.id = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}