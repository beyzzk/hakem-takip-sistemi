<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    die("Bu sayfayı görüntüleme yetkiniz yok.");
}

if (!isset($_GET['id'])) {
    die("Silinecek maç belirtilmedi.");
}

$match_id = $_GET['id'];

// Maçı silmeden önce varsa atamaları da siliyoruz
$pdo->prepare("DELETE FROM assignments WHERE match_id = ?")->execute([$match_id]);
// Maçı sil
$pdo->prepare("DELETE FROM matches WHERE id = ?")->execute([$match_id]);
header("Location: matches.php");
exit;
?>
