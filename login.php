<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, senha, tipo FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $tipo);
        $stmt->fetch();

        if (password_verify($senha, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["login"] = $login;
            $_SESSION["tipo"] = $tipo; // Armazena o tipo de usuário

            if ($tipo === "coordenador") {
                header("Location: coordenador.php"); // Redireciona para a página do coordenador
            } else {
                header("Location: dashboard.php"); // Redireciona para o portal dos professores
            }
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php if (isset($erro)) : ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
</body>
</html>