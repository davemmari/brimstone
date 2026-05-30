<?php
require_once 'database/Database.php';

class Hero {
    private mysqli $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connection;
    }

    public function validateName(string $name): string {
        $name = trim($name);
        if (empty($name)) {
            return "pft, Okay Mr./Ms. Mysterious!";
        }

        $badwords = [
            // b.indo
            'anjing', 'babi', 'bangsat', 'tolol', 'kontol', 'memek', 'tai', 'bangsat', 'goblok', 'jancok', 'jancuk', 'bajingan', 'brengsek', 'bacot', 'meki', 'pepek', 'titit', 'titid', 'ngewe', 'ngentot', 'babi',
            // b.inggris
            'shit', 'fuck', 'ass', 'dick', 'bitch', 'cunt', 'retard', 'retarded', 'nigga', 'nigger', 'pajet', 'pussy', 'biatch'
            ];
        foreach ($badwords as $word) {
            if (stripos($name, $word) !== false) {
                return "NO NO YA! GAK BOLEH NGOMONG KOTOR. SIAPA YANG AJARIN?!";
            }
        }
        return "VALID"; 
    }

    public function createHero(string $name, string $role) {
        $hp = 80; $atk = 25; $spd = 12; $def = 12; 

        if ($role == 'Warrior') {$def += 2;} 
        elseif ($role == 'Mage') {$hp -= 20; $atk += 10; $def -= 2;} 
        elseif ($role == 'Tank') {$hp += 40; $atk -= 10; $spd -= 4; $def += 4;} 
        elseif ($role == 'Marksman') {$hp -= 40; $atk += 5; $spd += 8; $def -= 2;}

        $max_hp = $hp;

        $clean_name = $this->db->real_escape_string($name);

        $query = "INSERT INTO heroes (name, role, hp, max_hp, atk, spd, def, gold) 
                  VALUES ('$clean_name', '$role', $hp, $max_hp, $atk, $spd, $def, 0)";
        return $this->db->query($query);
    }

    public function getAllHeroes() {
        $query = "SELECT * FROM heroes ORDER BY id DESC";
        return $this->db->query($query);
    }

    public function getHeroById(int $id) {
        $id = (int)$id;
        $query = "SELECT * FROM heroes WHERE id = $id";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    public function updateStats(int $id, int $hp, int $gold) {
        $id = (int)$id; $hp = (int)$hp; $gold = (int)$gold;
        $query = "UPDATE heroes SET hp = $hp, gold = $gold WHERE id = $id";
        return $this->db->query($query);
    }

    public function deleteHero(int $id) {
        $id = (int)$id;
        $query = "DELETE FROM heroes WHERE id = $id";
        return $this->db->query($query);
    }
}
?>