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
include_once '../objects/index.php';
include_once '../objects/article.php';
include_once '../check_auth.php';

$database = new Database();
$db = $database->getConnection();

$index = new Index($db);

$index->id = isset($_GET['id']) ? $_GET['id'] : die();

$index->readOne();

$index_arr = array(
    "id" => $index->id,
    "name" =>  $index->name,
    "parent_id" => $index->parent_id,
    "category_id" => $index->category_id,
);

$article = new Article($db);
$stmtArticle = $article->readByIndex($index->id, getTokenFromHeader());
$num = $stmtArticle->rowCount();
if($num>0){
    $json=array();
    while ($row = $stmtArticle->fetch(PDO::FETCH_ASSOC)){
        $json[] = $row;
    }
    $index_arr["count"] = $num;
    $index_arr["articles"] = $json;
}else{
    $index_arr["count"] = $num;
    $index_arr["articles"] = array();
}

$headers = apache_request_headers();

print_r(json_encode($index_arr));
?>