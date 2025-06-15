<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Sadece hakem rolünde olanlar bu sayfaya erişebilsin diye (admin erişemesin)
if ($_SESSION["role"] === 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Kullanıcıya atanmış maçları çekiyoruz
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT m.match_name, m.match_date, m.match_time
    FROM assignments a
    JOIN matches m ON a.match_id = m.id
    WHERE a.referee_id = ?
    ORDER BY m.match_date DESC
");
$stmt->execute([$user_id]);
$assigned_matches = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Atandığım Maçlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Atandığınız Maçlar</h3>
    <?php if (count($assigned_matches) > 0): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Maç Adı</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assigned_matches as $match): ?>
                    <tr>
                        <td><?= htmlspecialchars($match["match_name"]) ?></td>
                        <td><?= htmlspecialchars($match["match_date"]) ?></td>
                        <td><?= htmlspecialchars($match["match_time"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info mt-3">Henüz atandığınız bir maç yok.</div>
    <?php endif; ?>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Geri Dön</a>
</div>
</body>
</html>
