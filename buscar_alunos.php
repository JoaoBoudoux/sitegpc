<?php
include_once('config.php');

if (isset($_POST['turma'])) {
    $turma_id = $_POST['turma'];

    if (is_numeric($turma)) {
        $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
        $stmt->bind_param("i", $turma);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="">Escolha um aluno</option>';
        
        if ($result->num_rows > 0) {
            while ($aluno = $result->fetch_assoc()) {
                $nome_aluno = htmlspecialchars($aluno['nome'], ENT_QUOTES, 'UTF-8');
                $aluno_id = (int) $aluno['id'];

                echo '<option value="'.$aluno_id.'">'.$nome_aluno.'</option>';
            }
        } else {
            echo '<option value="">Nenhum aluno encontrado</option>';
        }

        $stmt->close();
    } else {
        echo '<option value="">Erro: ID da turma inválido</option>';
    }
} else {
    echo '<option value="">Erro: Parâmetro da turma não foi fornecido</option>';
}
?>
