<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: referees.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM referees WHERE id = ?");
$stmt->execute([$id]);
$referee = $stmt->fetch();

if (!$referee) {
    echo "Hakem bulunamadı.";
    exit;
}

$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $update = $pdo->prepare("UPDATE referees SET name = ? WHERE id = ?");
    $update->execute([$name, $id]);
    $mesaj = "Güncelleme başarılı.";
    header("Location: referees.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hakem Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Hakem Düzenle</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Ad Soyad</label>
            <input type="text" name="name" value="<?= htmlspecialchars($referee['name']) ?>" class="form-control" required>
        </div>
        <button class="btn btn-success">Güncelle</button>
        <a href="referees.php" class="btn btn-secondary mt-2">İptal</a>
    </form>
</div>
</body>
</html>
