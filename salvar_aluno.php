<?php
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["nome"]) && !empty($_POST["data_nascimento"]) && !empty($_POST["turma"])) {
        
        $nome = $_POST["nome"];
        $data_nascimento = $_POST["data_nascimento"];
        $turma_id = $_POST["turma"];

        $stmt = $conn->prepare("INSERT INTO alunos (nome, data_nascimento, turma_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nome, $data_nascimento, $turma_id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: cadastrar_aluno.php?success=1");
            exit();
        } else {
            error_log("Erro ao cadastrar aluno: " . $stmt->error);
            $stmt->close();
            die("Erro ao cadastrar aluno. Tente novamente mais tarde.");
        }
    } else {
        header("Location: cadastrar_aluno.php?error=Preencha todos os campos.");
        exit();
    }
}
?>

