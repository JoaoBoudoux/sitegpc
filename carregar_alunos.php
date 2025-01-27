<?php
include_once('config.php');

if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];

    // Consulta os alunos da turma selecionada
    $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Gerar a lista de alunos com opções de presença
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<label>";
            // Inputs de presença (radio buttons)
            echo "<input type='radio' name='presenca[" . $row['id'] . "]' value='P' required> Presente";
            echo "<input type='radio' name='presenca[" . $row['id'] . "]' value='F' required> Faltou";
            echo " " . htmlspecialchars($row['nome']);
            echo "</label>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum aluno encontrado para esta turma.</p>";
    }
}
?>