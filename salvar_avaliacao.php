<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION["user_id"];
$turma_id = $_POST["turma"];
$objetivos = $_POST["objetivo_aprendizagem"];
$bimestre_1 = $_POST["bimestre_1"];
$bimestre_2 = $_POST["bimestre_2"];
$bimestre_3 = $_POST["bimestre_3"];
$bimestre_4 = $_POST["bimestre_4"];

if (empty($turma_id) || empty($objetivos)) {
    die("Erro: Dados do formulário ausentes.");
}


$stmt = $conn->prepare("
    INSERT INTO avaliacoes_professores (users_id, turma_id, objetivo_aprendizagem, bimestre_1, bimestre_2, bimestre_3, bimestre_4)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        bimestre_1 = VALUES(bimestre_1), 
        bimestre_2 = VALUES(bimestre_2), 
        bimestre_3 = VALUES(bimestre_3), 
        bimestre_4 = VALUES(bimestre_4)
");

for ($i = 0; $i < count($objetivos); $i++) {
    $stmt->bind_param(
        "iisssss", 
        $user_id, 
        $turma_id, 
        $objetivos[$i], 
        $bimestre_1[$i], 
        $bimestre_2[$i], 
        $bimestre_3[$i], 
        $bimestre_4[$i]
    );
    $stmt->execute();
}

$stmt->close();
$conn->close();

header("Location: dashboard.php?turma=" . $turma_id);
exit();
?>