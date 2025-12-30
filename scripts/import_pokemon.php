<?php
set_time_limit(0);
require_once __DIR__ . "/../app/Model/Model.php";


$db = Model::getConnection();

$list = json_decode(
    file_get_contents("https://pokeapi.co/api/v2/pokemon?limit=1025"),
    true
);

foreach ($list["results"] as $entry) {
    $pokemonData = json_decode(
        file_get_contents($entry["url"]),
        true
    );

    $id = $pokemonData["id"];
    $name = $pokemonData["name"];
    $height = $pokemonData["height"];
    $weight = $pokemonData["weight"];
    $type1 = $pokemonData["types"][0]["type"]["name"];
    $type2 = $pokemonData["types"][1]["type"]["name"] ?? null;

    $speciesUrl = $pokemonData["species"]["url"];
    $speciesData = json_decode(file_get_contents($speciesUrl), true);

    $generationUrl = $speciesData["generation"]["url"];
    $generation = (int) basename($generationUrl);

    $stmt = $db->prepare("
        INSERT INTO pokemon (id, name, type1, type2, generation, height, weight)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $id,
        $name,
        $type1,
        $type2,
        $generation,
        $height,
        $weight
    ]);

    echo "Inserted $name\n";
}