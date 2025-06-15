<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kontrol Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Hoş geldin, <?= htmlspecialchars($_SESSION["username"]) ?>!</h3>

    <div class="mt-3">
        <?php if ($_SESSION["role"] === 'admin'): ?>
            <a href="referees.php" class="btn btn-danger">Hakemleri Listele</a>
            <a href="add_match.php" class="btn btn-primary">Maç Ekle</a>
            <a href="matches.php" class="btn btn-secondary">Maçları Listele</a>
            <a href="assign_match.php" class="btn btn-warning">Maç Atama Ekranı</a>
            <a href="view_assignments.php" class="btn btn-secondary">Atamaları Listele</a>
        <?php else: ?>
            <a href="referees.php" class="btn btn-danger">Hakemleri Listele</a>
            <a href="matches.php" class="btn btn-secondary">Maçları Listele</a>
            <a href="view_assignments.php" class="btn btn-secondary">Atamaları Listele</a>
            <a href="my_matches.php" class="btn btn-primary">Atandığım Maçlar</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger float-end">Çıkış Yap</a>
    </div>
</div>
</body>
</html>
