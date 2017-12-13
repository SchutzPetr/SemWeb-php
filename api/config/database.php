<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 11.10.2017
 * Time: 15:19
 */

class Database{

    // specify database credentials
    private $host = "localhost";
    private $port=3307;
    private $db_name = "news2";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=" . $this->port, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>