<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.html");
        exit;
    } else {
        $error = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login - Minha Estante</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-5 mx-auto card p-4 shadow">
    <h3 class="mb-3 text-center">Entrar 🌸</h3>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
      <input type="email" name="email" class="form-control mb-3" placeholder="E-mail" required>
      <input type="password" name="password" class="form-control mb-3" placeholder="Senha" required>
      <button class="btn btn-primary w-100">Entrar</button>
      <p class="mt-3 text-center">Não tem conta? <a href="register.php">Cadastre-se</a></p>
    </form>
  </div>
</div>
</body>
</html>
