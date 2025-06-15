<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    die("Bu sayfayı görüntüleme yetkiniz yok.");
}

if (!isset($_GET['id'])) {
    die("Geçersiz istek.");
}

$assignment_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM assignments WHERE id = ?");
$stmt->execute([$assignment_id]);
$assignment = $stmt->fetch();

if (!$assignment) {
    die("Atama bulunamadı.");
}

$matches = $pdo->query("SELECT id, match_name FROM matches ORDER BY match_date DESC")->fetchAll();
$referees = $pdo->query("SELECT r.user_id, r.name FROM referees r")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $match_id = $_POST['match_id'];
    $referee_id = $_POST['referee_id'];

    $update = $pdo->prepare("UPDATE assignments SET match_id = ?, referee_id = ? WHERE id = ?");
    $update->execute([$match_id, $referee_id, $assignment_id]);

    header("Location: view_assignments.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Atamayı Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Atamayı Düzenle</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Maç</label>
            <select name="match_id" class="form-select">
                <?php foreach ($matches as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= $m['id'] == $assignment['match_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['match_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hakem</label>
            <select name="referee_id" class="form-select">
                <?php foreach ($referees as $r): ?>
                    <option value="<?= $r['user_id'] ?>" <?= $r['user_id'] == $assignment['referee_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-success">Güncelle</button>
        <a href="view_assignments.php" class="btn btn-secondary mt-2">İptal</a>
    </form>
</div>
</body>
</html>
