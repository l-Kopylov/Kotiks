<?php
require_once 'db.php'; 
require_once 'CatRepository.php';
require_once 'KittenRepository.php';

$catRepository = new CatRepository($pdo);
$kittenRepository = new KittenRepository($pdo);

// Добавление новой кошки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];

    // Добавляем кошку в базу данных
    $catRepository->addCat((object) ['name' => $name, 'gender' => $gender, 'age' => $age]);

    // Редирект на главную страницу
    header('Location: index.php');
    exit();
}

// Получаем всех котов и котят
$cats = $catRepository->getAllCats();
$kittens = $kittenRepository->getKittensWithParents();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кошачий проект</title>
</head>
<body>
    <h1>Управление кошками и котятами</h1>
    
    <h2>Добавить кошку</h2>
    <form method="POST">
        <input type="text" name="name" required placeholder="Кличка кошки">
        <select name="gender" required>
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
        </select>
        <input type="number" name="age" required placeholder="Возраст (годы)" min="0">
        <button type="submit">Добавить кошку</button>
    </form>

    <h2>Список взрослых кошек</h2>
    <table border="1">
        <tr>
            <th>Имя</th>
            <th>Пол</th>
            <th>Возраст</th>
        </tr>
        <?php foreach ($cats as $cat): ?>
            <tr>
                <td><?= htmlspecialchars($cat->name) ?></td>
                <td><?= htmlspecialchars($cat->gender === 'male' ? 'Кот' : 'Кошка') ?></td>
                <td><?= htmlspecialchars($cat->age) ?> лет</td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>