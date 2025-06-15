<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    die("Bu sayfayı görüntüleme yetkiniz yok.");
}

if (!isset($_GET['id'])) {
    die("Maç ID'si belirtilmedi.");
}

$match_id = $_GET['id'];

// Maç bilgilerini alma
$stmt = $pdo->prepare("SELECT * FROM matches WHERE id = ?");
$stmt->execute([$match_id]);
$match = $stmt->fetch();

if (!$match) {
    die("Maç bulunamadı.");
}

// Güncelleme kısmı
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['match_name'];
    $date = $_POST['match_date'];
    $time = $_POST['match_time'];
    $location = $_POST['location'];
    $update = $pdo->prepare("UPDATE matches SET match_name=?, match_date=?, match_time=?, location=? WHERE id=?");
    $update->execute([$name, $date, $time, $location, $match_id]);
    header("Location: matches.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maç Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Maçı Düzenle</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Maç Adı</label>
            <input type="text" name="match_name" class="form-control" value="<?= htmlspecialchars($match['match_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" name="match_date" class="form-control" value="<?= $match['match_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Saat</label>
            <input type="time" name="match_time" class="form-control" value="<?= $match['match_time'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Yer</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($match['location']) ?>">
        </div>
        <button class="btn btn-primary">Kaydet</button>
        <a href="matches.php" class="btn btn-secondary mt-2">İptal</a>
    </form>
</div>
</body>
</html>
