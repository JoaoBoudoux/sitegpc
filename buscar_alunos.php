<?php
include_once('config.php');

// Verifica se o parâmetro 'turma' foi enviado pelo POST
if (isset($_POST['turma'])) {
    $turma_id = $_POST['turma'];

    // Verifica se o parâmetro 'turma' é um número válido
    if (is_numeric($turma_id)) {
        // Prepara a consulta para buscar os alunos da turma
        $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
        $stmt->bind_param("i", $turma_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há alunos na turma
        if ($result->num_rows > 0) {
            while ($aluno = $result->fetch_assoc()) {
                // Escapa o nome do aluno para evitar XSS
                $nome_aluno = htmlspecialchars($aluno['nome'], ENT_QUOTES, 'UTF-8');
                $aluno_id = (int) $aluno['id'];

                echo '<div class="aluno-item">';
                echo '<span class="aluno-nome">' . $nome_aluno . '</span>';
                echo '<div class="presenca-opcoes">';
                echo '<label><input type="radio" name="presenca[' . $aluno_id . ']" value="presente" required> Presente</label>';
                echo '<label><input type="radio" name="presenca[' . $aluno_id . ']" value="falta" required> Falta</label>';
                echo '</div></div>';
            }
        } else {
            // Retorna uma mensagem se não houver alunos na turma
            echo '<p>Nenhum aluno encontrado para a turma selecionada.</p>';
        }

        $stmt->close();
    } else {
        // Mensagem de erro se o 'turma_id' for inválido
        echo '<p>Erro: ID da turma inválido.</p>';
    }
} else {
    // Mensagem de erro se o parâmetro 'turma' não foi enviado
    echo '<p>Erro: Parâmetro da turma não foi fornecido.</p>';
}
?>
