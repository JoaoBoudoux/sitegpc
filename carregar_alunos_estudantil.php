<?php
include_once('config.php');

if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];

    $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $alunos = [];
    while ($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }

    echo json_encode($alunos);
}
?>