<?php
$host = "sql211.infinityfree.com"; // Exemplo: sql212.infinityfree.com
$dbname = "if0_40297561_minha_estante";
$username = "if0_40297561";
$password = "Gasj0102";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
