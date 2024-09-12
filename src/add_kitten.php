<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'CatRepository.php';
require_once 'KittenRepository.php';

$catRepository = new CatRepository($pdo);
$kittenRepository = new KittenRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['kitten_name'];
    $gender = $_POST['kitten_gender'];
    $age = $_POST['kitten_age'];
    $motherId = $_POST['mother_id'] ?: null;

    $kittenId = $kittenRepository->addKitten((object) ['name' => $name, 'gender' => $gender, 'age' => $age, 'motherId' => $motherId]);

    if (isset($_POST['father_ids'])) {
        foreach ($_POST['father_ids'] as $fatherId) {
            $kittenRepository->addKittenFather($kittenId, $fatherId);
        }
    }

    header('Location: index.php');
    exit(); // Добавьте exit, чтобы прекратить выполнение кода после редиректа
}

// Получаем всех котов
$cats = $catRepository->getAllCats();

$kittens = $kittenRepository->getKittensWithParents();
?>

<h2>Добавить котенка</h2>
<form method="POST">
    <input type="text" name="kitten_name" required placeholder="Кличка котенка">
    
    <select name="kitten_gender" required>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select>
    
    <input type="number" name="kitten_age" required placeholder="Возраст (годы)" min="0">
    
    <label for="mother_id">Мать:</label>
    <select name="mother_id" required>
        <option value="">Выберите мать</option>
        <?php foreach ($cats as $cat): ?>
            <?php if ($cat->gender === 'female'): ?>
                <option value="<?= $cat->id ?>" <?= (isset($_POST['mother_id']) && $_POST['mother_id'] == $cat->id) ? 'selected' : '' ?>><?= $cat->name ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    
    <label for="father_ids">Отцы:</label>
        <select name="father_ids[]" multiple required>
            <option value="" disabled selected>Выберите отцов</option>
            <?php foreach ($cats as $cat): ?>
                <?php if ($cat->gender === 'male'): ?>
                    <option value="<?= $cat->id ?>" <?= (isset($_POST['father_ids']) && in_array($cat->id, $_POST['father_ids'])) ? 'selected' : '' ?>><?= htmlspecialchars($cat->name) ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    
    <button type="submit">Добавить котенка</button>
</form>

<style>
    select[multiple] {
        height: 150px; /* Увеличьте высоту, чтобы было видно больше вариантов */
        width: 200px; /* Уберите фиксированную ширину, если необходимо */
    }
</style>


    <h1>Список котят</h1>
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