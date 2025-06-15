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

// Maçları ve hakemleri çekiyoruz
$matches = $pdo->query("SELECT id, match_name FROM matches ORDER BY match_date DESC")->fetchAll();
$referees = $pdo->query("SELECT r.user_id, r.name FROM referees r")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $match_id = $_POST['match_id'];
    $referee_id = $_POST['referee_id'];

    $stmt = $pdo->prepare("INSERT INTO assignments (match_id, referee_id) VALUES (?, ?)");
    $stmt->execute([$match_id, $referee_id]);
    header("Location: view_assignments.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Maç Atama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Hakeme Maç Ata</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Maç Seçin</label>
            <select name="match_id" class="form-select" required>
                <?php foreach ($matches as $match): ?>
                    <option value="<?= $match['id'] ?>"><?= htmlspecialchars($match['match_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hakem Seçin</label>
                <select name="referee_id" class="form-select" required>
                    <?php foreach ($referees as $ref): ?>
                        <option value="<?= $ref['user_id'] ?>"><?= htmlspecialchars($ref['name']) ?></option>
                    <?php endforeach; ?>
                </select>
        </div>
        <button class="btn btn-primary">Ata</button>
        <a href="dashboard.php" class="btn btn-secondary mt-2">Geri</a>
    </form>
</div>
</body>
</html>
