<?php
session_start();
include_once("config.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST["usuario"];
    $nova_senha = $_POST["nova_senha"];
    $confirmar_senha = $_POST["confirmar_senha"];


    if ($nova_senha !== $confirmar_senha) {
        echo "<script>alert('Erro: As senhas não coincidem!'); window.location.href='alterar_senha.php';</script>";
        exit();
    }

  
    $senha_hashed = password_hash($nova_senha, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET senha = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $senha_hashed, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='alterar_senha.php';</script>";
    } else {
        echo "<script>alert('Erro ao alterar senha!'); window.location.href='alterar_senha.php';</script>";
    }
}
?>
