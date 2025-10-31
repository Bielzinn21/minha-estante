<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $cover = $_POST['cover'];
    $rating = $_POST['rating'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, genre=?, cover_url=?, rating=?, notes=? WHERE id=? AND user_id=?");
    $stmt->execute([$title, $author, $genre, $cover, $rating, $notes, $id, $user_id]);

    echo json_encode(['success' => true]);
}
?>
