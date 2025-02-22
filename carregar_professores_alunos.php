<?php
include_once('config.php');

$tipo = $_GET["tipo"];
$professores = [];
$alunos = [];

if ($tipo == "relatorio_anual" || $tipo == "relatorios_estudantis") {
    // Buscar professores
    $queryProfessores = "SELECT id, login AS nome FROM users";
    $resultProfessores = $conn->query($queryProfessores);
    while ($row = $resultProfessores->fetch_assoc()) {
        $professores[] = $row;
    }

    // Buscar alunos
    $queryAlunos = "SELECT id, nome FROM alunos";
    $resultAlunos = $conn->query($queryAlunos);
    while ($row = $resultAlunos->fetch_assoc()) {
        $alunos[] = $row;
    }
}

echo json_encode(["professores" => $professores, "alunos" => $alunos]);
?>
