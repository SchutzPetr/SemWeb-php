<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 05.12.2017
 * Time: 19:30
 */

class Article
{
    private $conn;
    private $table_name = "article";

    public $id;
    public $title;
    public $content;
    public $language_id;
    public $source;
    public $visibility;
    public $author;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function readByIndex($indexID, $token)
    {
        $query = "SELECT a.*, ai.index_id FROM article a JOIN article_index ai ON a.id = ai.article_id WHERE ai.index_id = ? AND a.visibility <= (SELECT u.role FROM user u WHERE u.token = ?) ORDER BY publish DESC;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $indexID);
        $stmt->bindParam(2, $token);
        $stmt->execute();
        return $stmt;
    }

    function readOne()
    {
        $query = "SELECT * FROM article a WHERE a.id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->language_id = $row['language_id'];
        $this->source = $row['source'];
        $this->visibility = $row['visibility'];
        $this->author = $row['author'];
    }

    function update($id, $title, $body, $source){
        $query = "UPDATE article SET title = ?, content = ?, source  = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $body);
        $stmt->bindParam(3, $source);
        $stmt->bindParam(4, $id);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function read()
    {
        $query = "SELECT * FROM article";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readLastNews($token)
    {
        $query = "SELECT a.*, ai.index_id FROM article a JOIN article_index ai ON a.id = ai.article_id WHERE a.visibility <= (SELECT u.role FROM user u WHERE u.token = ?) GROUP BY id ORDER BY publish DESC LIMIT 24;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $token);
        $stmt->execute();
        return $stmt;

    }
}