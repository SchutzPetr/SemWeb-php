<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 17:15
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Auth-Token");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/article.php';

$database = new Database();
$db = $database->getConnection();

$article = new Article($db);

$article->id = isset($_GET['id']) ? $_GET['id'] : die();

$article->readOne();

$article_arr = array(
    "id" => $article->id,
    "title" =>  $article->title,
    "content" => $article->content,
    "language_id" => $article->language_id,
    "source" => $article->source,
    "visibility" => $article->visibility,
    "author" => $article->author

);

$headers = apache_request_headers();

foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}

print_r(json_encode($product_arr));
?>