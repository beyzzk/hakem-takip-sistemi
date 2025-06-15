<?php
session_start();
require_once 'db.php';

$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {
        $hata = "Lütfen tüm alanları doldurun.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        try {
            $stmt->execute([$username, $email, $hashedPassword]);

            // Kullanıcı kaydedildiyse, ID'sini al
            $userId = $pdo->lastInsertId();

            // Varsayılan olarak kayıt olan herkesi(admin degilse) referees tablosuna ekliyoruz
            $stmt2 = $pdo->prepare("INSERT INTO referees (user_id, name) VALUES (?, ?)");
            $stmt2->execute([$userId, $username]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $hata = "Bu e-posta veya kullanıcı adı zaten kayıtlı olabilir.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Kayıt Ol</h2>
    <?php if ($hata): ?>
        <div class="alert alert-danger"><?= $hata ?></div>
    <?php endif; ?>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Şifre</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Kayıt Ol</button>
        <a href="login.php" class="btn btn-link">Zaten hesabınız var mı?</a>
    </form>
</div>
</body>
</html>
