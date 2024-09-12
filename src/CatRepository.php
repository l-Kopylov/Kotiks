<?php
require_once 'db.php';

class CatRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addCat($cat) {
        $stmt = $this->pdo->prepare("INSERT INTO cats (name, gender, age) VALUES (?, ?, ?)");
        $stmt->execute([$cat->name, $cat->gender, $cat->age]);
        return $this->pdo->lastInsertId();
    }

    public function getAllCats() {
        $stmt = $this->pdo->query("SELECT * FROM cats");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
