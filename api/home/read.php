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
include_once '../objects/index.php';
include_once '../objects/article.php';
include_once '../check_auth.php';

// instantiate database and article object
$database = new Database();
$db = $database->getConnection();

$index = new Index($db);

$stmt = $index->read();
$num = $stmt->rowCount();

$token = getTokenFromHeader();

if ($num > 0) {

    $index_arr = array();
    $index_arr["homeboxes"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $index_item = array(
            "id" => $id,
            "name" =>  $name,
            "parent_id" => $parent_id,
            "category_id" => $category_id,
        );
        $article = new Article($db);
        $stmtArticle = $article->readByIndex($id, $token);
        $num = $stmtArticle->rowCount();
        if($num>0){
            $json=array();
            while ($row = $stmtArticle->fetch(PDO::FETCH_ASSOC)){
                $json[] = $row;
            }
            $index_item["articles"] = $json;
        }else{
            $index_item["articles"] = array();
        }
        array_push($index_arr["homeboxes"], $index_item);
        $index_arr["timeline"] = array();
        $stmtArticleTimeline = $article->readLastNews($token);
        $num = $stmtArticleTimeline->rowCount();
        if($num>0){
            $json=array();
            while ($row = $stmtArticleTimeline->fetch(PDO::FETCH_ASSOC)){
                $json[] = $row;
            }
            $index_arr["timeline"] = $json;
        }else{
            $index_item["timeline"] = array();
        }

    }

    echo json_encode($index_arr);
} else {
    echo json_encode(
        array("message" => "No articles found.")
    );
}
