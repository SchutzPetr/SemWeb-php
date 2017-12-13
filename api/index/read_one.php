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

$headers = apache_request_headers();

/*foreach ($headers as $header => $value) {
    //echo "$header: $value <br />\n";
}*/

echo json_encode($index_arr);
?>