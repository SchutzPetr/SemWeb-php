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
$article = new Article($db);

$article->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($user->id == null) {
    return;
}

echo $article->id;

if ($user->role < 3) {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

if ($article->delete()) {
    echo '{';
    echo '"message": "Article was deleted."';
    echo '}';
} // if unable to update the product, tell the user
else {
    echo '{';
    echo '"message": "Unable to delete article."';
    echo '}';
}
?>
