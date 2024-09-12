<?php
require_once 'db.php'; // Подключение к базе данных
require_once 'CatRepository.php';
require_once 'KittenRepository.php';

$catRepository = new CatRepository($pdo);
$kittenRepository = new KittenRepository($pdo);

// Получение всех котов и котят
$cats = $catRepository->getAllCats();
$kittens = $kittenRepository->getKittensWithParents(); // Получаем котят с родителями
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
    <a href="add_cat.php">Добавить кошку</a> |
    <a href="add_kitten.php">Добавить котенка</a>

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

    <h2>Список котят</h2>
    <table border="1">
        <tr>
            <th>Имя котенка</th>
            <th>Имя матери</th>
            <th>Имена отцов</th>
        </tr>
        <?php foreach ($kittens as $kitten): ?>
        <tr>
            <td><?= htmlspecialchars($kitten->kitten_name) ?></td>
            <td><?= htmlspecialchars($kitten->mother_name ?: 'Нет данных') ?></td>
            <td><?= htmlspecialchars($kitten->fathers_names ?: 'Нет данных') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>