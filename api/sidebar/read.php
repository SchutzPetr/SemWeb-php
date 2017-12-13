<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 06.12.2017
 * Time: 7:54
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Auth-Token");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("X-Auth-Token: *");

include_once '../config/database.php';
include_once '../objects/index.php';

$database = new Database();
$db = $database->getConnection();

$index = new Index($db);

$stmt = $index->readByCategory(1);
$num = $stmt->rowCount();

if ($num > 0) {

    $index_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $index_item = array(
            "id" => $id,
            "name" =>  $name,
            "parent_id" => $parent_id,
            "category_id" => $category_id,
        );
        $index_arr[] = $index_item;
    }
    echo json_encode($index_arr);
} else {
    echo json_encode(
        array("message" => "No articles found.")
    );
}
?>