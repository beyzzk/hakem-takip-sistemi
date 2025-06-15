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
$stmt = $pdo->prepare("DELETE FROM assignments WHERE id = ?");
$stmt->execute([$assignment_id]);
header("Location: view_assignments.php");
exit;
