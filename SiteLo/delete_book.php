<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM books WHERE id=? AND user_id=?");
    $stmt->execute([$id, $user_id]);

    echo json_encode(['success' => true]);
}
?>
