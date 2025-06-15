<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$isAdmin = ($_SESSION["role"] === 'admin');
$stmt = $pdo->query("
    SELECT a.id, a.match_id, a.referee_id, m.match_name, u.username, a.assigned_at
    FROM assignments a
    JOIN matches m ON a.match_id = m.id
    JOIN users u ON a.referee_id = u.id
    ORDER BY a.assigned_at DESC
");

$assignments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maç Atamaları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Maç Atamaları</h3>
    <?php if ($isAdmin): ?>
        <a href="assign_match.php" class="btn btn-primary mb-3">Yeni Atama Yap</a>
    <?php endif; ?>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Geri Dön</a>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Maç</th>
                <th>Hakem</th>
                <th>Atama Tarihi</th>
                <?php if ($isAdmin): ?>
                    <th>İşlemler</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['match_name']) ?></td>
                <td><?= htmlspecialchars($a['username']) ?></td>
                <td><?= htmlspecialchars($a['assigned_at']) ?></td>
                <?php if ($isAdmin): ?>
                <td>
                    <a href="edit_assignment.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                    <a href="delete_assignment.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu atamayı silmek istediğinize emin misiniz?')">Sil</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
