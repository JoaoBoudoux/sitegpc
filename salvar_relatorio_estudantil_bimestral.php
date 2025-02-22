<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["turma-estudantil"], $_POST["aluno-estudantil"], $_POST["relatorio-aluno"], $_POST["ano"], $_POST["bimestre"]) 
        && !empty($_POST["turma-estudantil"]) 
        && !empty($_POST["aluno-estudantil"]) 
        && !empty($_POST["relatorio-aluno"])
        && !empty($_POST["ano"])
        && !empty($_POST["bimestre"])) {
        
        $professor_id = $_SESSION["user_id"];
        $turma_id = $_POST["turma-estudantil"];
        $aluno_id = $_POST["aluno-estudantil"];
        $ano = $_POST["ano"];
        $bimestre = $_POST["bimestre"];
        $descricao = $_POST["relatorio-aluno"];
        $data_relatorio = date("Y-m-d");

        
        if (!is_numeric($turma_id) || !is_numeric($aluno_id) || !is_numeric($ano) || !is_numeric($bimestre)) {
            die("Erro: ID da turma, aluno, ano e bimestre devem ser números.");
        }

        $stmt = $conn->prepare("INSERT INTO relatorios_estudantis (professor_id, turma_id, aluno_id, ano, bimestre, data_relatorio, descricao) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiisss", $professor_id, $turma_id, $aluno_id, $ano, $bimestre, $data_relatorio, $descricao);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: dashboard.php?success=1");
            exit();
        } else {
            error_log("Erro ao salvar relatório: " . $stmt->error);
            $stmt->close();
            die("Erro ao salvar relatório. Por favor, tente novamente mais tarde.");
        }
    } else {
        header("Location: dashboard.php?error=Preencha todos os campos.");
        exit();
    }
}
?>
