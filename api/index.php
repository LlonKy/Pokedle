<?php

header("Content-Type: application/json");

define('ROOT_PATH', dirname(__DIR__) . '/');

require_once ROOT_PATH . "app/Model/Model.php";
require_once ROOT_PATH . "app/Model/PokemonModel.php";
require_once ROOT_PATH . "app/Controller/PokemonController.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
    new PokemonController()->check();
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route not found"]);