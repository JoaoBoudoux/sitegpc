<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos necessários estão definidos e não estão vazios
    if (isset($_POST["turma-estudantil"], $_POST["aluno-estudantil"], $_POST["relatorio-aluno"]) 
        && !empty($_POST["turma-estudantil"]) 
        && !empty($_POST["aluno-estudantil"]) 
        && !empty($_POST["relatorio-aluno"])) {
        
        $professor_id = $_SESSION["user_id"];
        $turma_id = $_POST["turma-estudantil"];
        $aluno_id = $_POST["aluno-estudantil"];
        $descricao = $_POST["relatorio-aluno"];
        $data_relatorio = date("Y-m-d");

        // Prepara a query para inserir o relatório na tabela
        $stmt = $conn->prepare("INSERT INTO relatorios_estudantis (professor_id, turma_id, aluno_id, data_relatorio, descricao) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $professor_id, $turma_id, $aluno_id, $data_relatorio, $descricao);

        // Tenta executar a query
        if ($stmt->execute()) {
            $stmt->close(); // Fechamos antes do redirecionamento
            header("Location: dashboard.php?success=1");
            exit();
        } else {
            error_log("Erro ao salvar relatório: " . $stmt->error); // Log do erro para depuração
            $stmt->close(); // Fechamos antes do encerramento com die()
            die("Erro ao salvar relatório. Por favor, tente novamente mais tarde.");
        }
    } else {
        // Redireciona de volta com uma mensagem de erro se os campos não foram preenchidos
        header("Location: dashboard.php?error=Preencha todos os campos.");
        exit();
    }
}
?>