<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $passwordHash]);

    header("Location: login.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Registrar - Minha Estante</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-5 mx-auto card p-4 shadow">
    <h3 class="mb-3 text-center">Criar conta 🌸</h3>
    <form method="POST">
      <input type="text" name="username" class="form-control mb-3" placeholder="Usuário" required>
      <input type="email" name="email" class="form-control mb-3" placeholder="E-mail" required>
      <input type="password" name="password" class="form-control mb-3" placeholder="Senha" required>
      <button class="btn btn-primary w-100">Registrar</button>
      <p class="mt-3 text-center">Já tem conta? <a href="login.php">Entrar</a></p>
    </form>
  </div>
</div>
</body>
</html>
