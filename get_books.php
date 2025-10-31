<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($books);
?>
