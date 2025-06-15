<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM matches ORDER BY match_date DESC");
$matches = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maç Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Maç Listesi</h3>
    
    <?php if ($_SESSION["role"] === 'admin'): ?>
        <a href="add_match.php" class="btn btn-primary mb-3">Yeni Maç Ekle</a>
    <?php endif; ?>
    
    <a href="dashboard.php" class="btn btn-secondary mb-3">Geri Dön</a>

    <?php if ($_SESSION["role"] !== 'admin'): ?>
        <a href="my_matches.php" class="btn btn-secondary mb-3">Atandığım Maçlar</a>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Adı</th>
                <th>Tarih</th>
                <th>Saat</th>
                <th>Yer</th>
                <?php if ($_SESSION["role"] === 'admin'): ?>
                    <th>İşlemler</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= htmlspecialchars($match['match_name']) ?></td>
                <td><?= htmlspecialchars($match['match_date']) ?></td>
                <td><?= htmlspecialchars($match['match_time']) ?></td> 
                <td><?= htmlspecialchars($match['location']) ?></td>

                <?php if ($_SESSION["role"] === 'admin'): ?>
                <td>
                    <a href="edit_match.php?id=<?= $match['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="delete_match.php?id=<?= $match['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Maçı silmek istediğinize emin misiniz?')">Sil</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
