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

include_once '../config/database.php';
include_once '../objects/article.php';
include_once '../objects/user.php';
include_once '../check_auth.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$token = getTokenFromHeader();
$user->token = $token;

$user->readByToken();

$indexId = $_POST['indexId'];
$title = $_POST['title'];
$body = $_POST['body'];
$source = $_POST['source'];

if($indexId == null || $title == null || $body == null || $source == null || $user == null){
    return;
}

if($user->role < 3){
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

$article = new Article($db);

if($article->insert($title, $body, $source, 1, $user, 1, $indexId)){
    echo '{';
    echo '"message": "Article was inserted."';
    echo '}';
}

else{
    echo '{';
    echo '"message": "Unable to insert article."';
    echo '}';
}
?>
