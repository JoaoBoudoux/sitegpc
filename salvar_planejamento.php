<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

$professor_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["faixa_etaria"]) || !isset($_POST["bimestre"]) || !isset($_POST["campo_aprendizado"]) || !isset($_POST["conteudos"])) {
        die(header("Location: planejamento.php?"));
    }

    $faixa_etaria = $_POST["faixa_etaria"];
    $bimestre = intval($_POST["bimestre"]);
    $campo_aprendizado = $_POST["campo_aprendizado"];
    $conteudos = implode(", ", $_POST["conteudos"]); // Converte array para string
    $observacoes = isset($_POST["observacoes"]) ? $_POST["observacoes"] : "";

    // Verifica se já existe um planejamento salvo para esse professor, faixa etária, bimestre e campo de aprendizado
    $stmt = $conn->prepare("
        SELECT id FROM planejamento_anual 
        WHERE users_id = ? AND faixa_etaria = ? AND bimestre = ? AND campo_aprendizado = ?
    ");
    $stmt->bind_param("isii", $professor_id, $faixa_etaria, $bimestre, $campo_aprendizado);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Atualiza os dados existentes
        $stmt = $conn->prepare("
            UPDATE planejamento_anual 
            SET conteudos = ?, observacoes = ?, atualizado_em = CURRENT_TIMESTAMP 
            WHERE users_id = ? AND faixa_etaria = ? AND bimestre = ? AND campo_aprendizado = ?
        ");
        $stmt->bind_param("ssissi", $conteudos, $observacoes, $professor_id, $faixa_etaria, $bimestre, $campo_aprendizado);
    } else {
        // Insere novos dados
        $stmt = $conn->prepare("
            INSERT INTO planejamento_anual (users_id, faixa_etaria, bimestre, campo_aprendizado, conteudos, observacoes) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isisss", $professor_id, $faixa_etaria, $bimestre, $campo_aprendizado, $conteudos, $observacoes);
    }

    if ($stmt->execute()) {
        header("Location: planejamento.php?msg=salvo");
    } else {
        echo "Erro ao salvar o planejamento.";
    }

    $stmt->close();
}

$conn->close();
?>
