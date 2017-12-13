<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 7:54
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Auth-Token");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/article.php';

// instantiate database and article object
$database = new Database();
$db = $database->getConnection();

$article = new Article($db);

$stmt = $article->read();
$num = $stmt->rowCount();

if ($num > 0) {

    $articles_arr = array();
    $articles_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $article_item = array(
            "id" => $id,
            "title" => $title,
            "content" => $content,
            "language_id" => $language_id,
            "source" => $source,
            "visibility" => $visibility,
            "author" => $author
        );

        array_push($articles_arr["records"], $article_item);
    }

    echo json_encode($articles_arr);
} else {
    echo json_encode(
        array("message" => "No articles found.")
    );
}
?>