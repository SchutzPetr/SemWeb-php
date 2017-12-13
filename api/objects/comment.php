<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 8:38
 */

class Comment
{
    private $conn;
    private $table_name = "comment";

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $article_id;
    public $posted;
    public $order;

    public function __construct($db){
        $this->conn = $db;
    }
}