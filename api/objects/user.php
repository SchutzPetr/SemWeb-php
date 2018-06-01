<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 05.12.2017
 * Time: 19:30
 */

class User
{
    private $conn;
    private $table_name = "user";

    public $id;
    public $email;
    public $name;
    public $surname;
    public $password;
    public $registered;
    public $language_id;
    public $role;
    public $token;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function readByToken(){
        $query = "SELECT * from user u WHERE u.token = ?";
        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->token);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->surname = $row['surname'];
        $this->password = $row['password'];
        $this->registered = $row['registered'];
        $this->language_id = $row['language_id'];
        $this->role = $row['role'];
    }

    function readOne(){
        $query = "SELECT * from user u WHERE u.email = ?";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!password_verify($this->password, $row['password'])){
            return;
        }
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->surname = $row['surname'];
        $this->registered = $row['registered'];
        $this->language_id = $row['language_id'];
        $this->role = $row['role'];
        $this->token = $row['token'];
    }
}