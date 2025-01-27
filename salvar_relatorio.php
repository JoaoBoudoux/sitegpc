<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $professor_id = $_SESSION["user_id"];
    $data = $_POST["data"];
    $turma = $_POST["turma"];
    $descricao = $_POST["descricao"];

    $stmt = $conn->prepare("INSERT INTO relatorio_diario (users_id, turma, data, descricao) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $professor_id, $turma, $data, $descricao);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=relatorio_salvo");
    } else {
        echo "Erro ao salvar o relatório.";
    }

    $stmt->close();
    $conn->close();
}
?>
