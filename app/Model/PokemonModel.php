<?php

require_once "Model.php";

class PokemonModel extends Model{

    public static function getDailyPokemon(): array {
        $db = self::getConnection();
        
        $total = $db->query("SELECT COUNT(*) FROM pokemon")->fetchColumn();

        srand((int)date("Ymd"));
        $dailyId = rand(1, $total);

        $stmt = $db->prepare("SELECT * FROM pokemon WHERE id = ?");
        $stmt->execute([$dailyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public static function findByName(string $name): ?array{
        $sql = "SELECT id, name, type1, type2, generation, height, weight
             FROM pokemon
             WHERE name = ?";

        $db = self::getConnection();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(1, strtolower($name));

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}