<?php
session_start();
require 'config.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Enterprise Dashboard</title>
    <link rel="stylesheet" href="cc/login.css">
</head>
<body>

<div class="login-box">
    <h2>Enterprise Login</h2>

    <?php if($erro): ?>
        <p style="color:red; margin-bottom:15px;">
            <?php echo $erro; ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>