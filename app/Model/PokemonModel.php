<?php


class PokemonModel extends Model{

    public static function getDailyPokemon() {
    $db = self::getConnection();
    $count = $db->query("SELECT COUNT(*) FROM pokemon")->fetchColumn();

    $seed = (int)date("Ymd");
    srand($seed);
    
    $dailyId = rand(1, $count);

    $stmt = $db->prepare("SELECT * FROM pokemon WHERE id = ?");
    $stmt->execute([$dailyId]);
    $pokemon  = $stmt->fetch(PDO::FETCH_ASSOC);
    return $pokemon;
}
    public static function findByName(string $name): ?array{
        $sql = "SELECT id, name, type1, type2, generation, height, weight
             FROM pokemon
             WHERE name = ?";

        $db = self::getConnection();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(1, strtolower($name), PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}