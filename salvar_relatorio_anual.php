<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $professor_id = $_SESSION["user_id"];
    $ano = $_POST["ano"] ?? null;
    $turma = $_POST["turma"] ?? null;
    $aluno = $_POST["aluno"] ?? null;
    $descricao = $_POST["relatorio-anual"] ?? null;

    if (!$ano || !$turma || !$aluno || !$descricao) {
        die("Erro: Todos os campos devem ser preenchidos.");
    }

    $stmt = $conn->prepare("INSERT INTO relatorio_anual (users_id, ano, turma, aluno_id, descricao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisis", $professor_id, $ano, $turma, $aluno, $descricao);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=relatorio_anual_salvo");
    } else {
        echo "Erro ao salvar o relatório anual.";
    }

    $stmt->close();
    $conn->close();
}

?>

