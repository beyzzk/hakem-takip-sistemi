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

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM referees WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: referees.php");
exit;
