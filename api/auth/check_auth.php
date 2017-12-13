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
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = isset($_GET['login']) ? $_GET['login'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();

$user->readOne();

$result = array();

$user_arr = array(
    "id" => $user->id,
    "email" =>  $user->email,
    "name" => $user->name,
    "surname" => $user->surname,
    "registered" => $user->registered,
    "language_id" =>  $user->language_id,
    "role" => $user->role,
    "token" => $user->token
);

$result["status"] = $user->id != null ? "OK" : "ERROR";
$result["identity"] = $user_arr;


echo json_encode($result);
?>