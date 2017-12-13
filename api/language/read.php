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
include_once '../objects/language.php';

// instantiate database and article object
$database = new Database();
$db = $database->getConnection();

$lang = new Language($db);

$stmt = $lang->read();
$num = $stmt->rowCount();

if ($num > 0) {

    $languages_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $language_item = array(
            "id" => $id,
            "language" => $language,
            "code" => $code,
            "country" => $country,
        );
        $languages_arr[$id] = $language_item;
    }

    echo json_encode($languages_arr);
} else {
    echo json_encode(
        array("message" => "No articles found.")
    );
}
