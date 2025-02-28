<?php
include_once('config.php');


if (isset($_POST['turma'])) {
    $turma_id = $_POST['turma'];

    
    if (is_numeric($turma_id)) {
        
        $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
        $stmt->bind_param("i", $turma_id);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            while ($aluno = $result->fetch_assoc()) {
                
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
            
            echo '<p>Nenhum aluno encontrado para a turma selecionada.</p>';
        }

        $stmt->close();
    } else {
        
        echo '<p>Erro: ID da turma inválido.</p>';
    }
} else {
    
    echo '<p>Erro: Parâmetro da turma não foi fornecido.</p>';
}
?>
