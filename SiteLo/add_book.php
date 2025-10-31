<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $cover = $_POST['cover'];
    $rating = $_POST['rating'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO books (user_id, title, author, genre, cover_url, rating, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $author, $genre, $cover, $rating, $notes]);

    echo json_encode(['success' => true]);
}
?>
