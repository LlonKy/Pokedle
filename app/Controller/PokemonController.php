<?php

require_once __DIR__ . "/../Model/PokemonModel.php";

class PokemonController
{
    public function check(): void {
    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    if (!$data || !isset($data["guess"])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON or missing 'guess'"]);
        return;
    }

    $guessName = strtolower(trim($data["guess"]));
    
    $userPokemon = PokemonModel::findByName($guessName);
    if (!$userPokemon) {
        http_response_code(404);
        echo json_encode(["error" => "Pokemon not found"]);
        return;
    }

    $daily = PokemonModel::getDailyPokemon();

    $comparison = [
        "name" => [
            "value" => $userPokemon['name'],
            "correct" => $userPokemon['id'] === $daily['id']
        ],
        "type1" => [
            "value" => $userPokemon['type1'],
            "result" => $this->compareTypes($userPokemon['type1'], $daily['type1'], $daily['type2'])
        ],
        "type2" => [
            "value" => $userPokemon['type2'],
            "result" => $this->compareTypes($userPokemon['type2'], $daily['type1'], $daily['type2'])
        ],
        "generation" => [
            "value" => $userPokemon['generation'],
            "result" => $this->compareNumeric($userPokemon['generation'], $daily['generation'])
        ],
        "height" => [
            "value" => $userPokemon['height'],
            "result" => $this->compareNumeric($userPokemon['height'], $daily['height'])
        ],
        "weight" => [
            "value" => $userPokemon['weight'],
            "result" => $this->compareNumeric($userPokemon['weight'], $daily['weight'])
        ]
    ];

    echo json_encode([
        "success" => true,
        "is_correct" => ($userPokemon['id'] === $daily['id']),
        "comparison" => $comparison
    ]);
}

    private function compareNumeric($userVal, $dailyVal): string {
        if ($userVal == $dailyVal) return "correct";
        return ($userVal < $dailyVal) ? "higher" : "lower";
    }

    private function compareTypes($userType, $dailyType1, $dailyType2): string {
        if ($userType === null) return "incorrect";
        if ($userType === $dailyType1 || $userType === $dailyType2) {
            return ($userType === $dailyType1 || $userType === $dailyType2) && 
                ($userType === $dailyType1 || $userType === $dailyType2) ? "correct" : "partial"; 
        }
        return "incorrect";
    }
}