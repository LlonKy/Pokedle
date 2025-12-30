<?php
header("Content-Type: application/json");

require_once "../app/Controller/PokemonController.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
    new PokemonController()->check();
    exit;
}

http_response_code(404);
echo json_encode(["error" => "Route not found"]);