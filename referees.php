<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM referees ORDER BY id DESC");
$referees = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hakem Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Hakem Listesi</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Geri Dön</a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referees as $ref): ?>
            <tr>
                <td><?= htmlspecialchars($ref['name']) ?></td>
                <td>
                    <a href="edit_referee.php?id=<?= $ref['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="delete_referee.php?id=<?= $ref['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
