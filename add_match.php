<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    die("Bu sayfayı görüntüleme yetkiniz yok.");
}
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['match_name'];
    $date = $_POST['match_date'];
    $time = $_POST["match_time"];
    $location = $_POST['location'];

    $stmt = $pdo->prepare("INSERT INTO matches (match_name, match_date, match_time, location) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $date, $time, $location]);
    header("Location: matches.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maç Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Yeni Maç Ekle</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Maç Adı</label>
            <input type="text" name="match_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" name="match_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Maç Saati</label>
            <input type="time" name="match_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Yer</label>
            <input type="text" name="location" class="form-control">
        </div>
        <button class="btn btn-primary">Kaydet</button>
        <a href="dashboard.php" class="btn btn-secondary mt-2">İptal</a>
    </form>
</div>
</body>
</html>
