<?php
require_once 'db.php';

class KittenRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addKitten($kitten) {
        $stmt = $this->pdo->prepare("INSERT INTO kittens (name, gender, age, mother_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kitten->name, $kitten->gender, $kitten->age, $kitten->motherId]);
        return $this->pdo->lastInsertId();
    }

    public function addKittenFather($kittenId, $fatherId) {
        $stmt = $this->pdo->prepare("INSERT INTO kitten_fathers (kitten_id, father_id) VALUES (?, ?)");
        $stmt->execute([$kittenId, $fatherId]);
    }

    public function getAllKittens() {
        $stmt = $this->pdo->query("SELECT * FROM kittens");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getKittensWithParents() {
        $stmt = $this->pdo->query("
            SELECT 
                k.id AS kitten_id,
                k.name AS kitten_name,
                k.gender AS kitten_gender,
                k.age AS kitten_age,
                m.name AS mother_name,
                GROUP_CONCAT(f.name SEPARATOR ', ') AS fathers_names
            FROM 
                kittens k
            LEFT JOIN 
                cats m ON k.mother_id = m.id
            LEFT JOIN 
                kitten_fathers kf ON k.id = kf.kitten_id
            LEFT JOIN 
                cats f ON kf.father_id = f.id
            GROUP BY 
                k.id
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }    
}



