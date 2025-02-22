<?php
session_start();
include_once('config.php');


if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turma_id = $_POST['turma'] ?? null;
    $data = $_POST['data'] ?? null;
    $presencas = $_POST['presenca'] ?? null; 

    
    if (!empty($turma_id) && !empty($data) && !empty($presencas)) {
        
        foreach ($presencas as $aluno_id => $status) {
            if ($status == "presente") {
                $presencas[$aluno_id] = "P"; 
            } elseif ($status == "falta") {
                $presencas[$aluno_id] = "F"; 
            }
        }

        
        $stmt = $conn->prepare("SELECT id FROM alunos WHERE turma_id = ?");
        $stmt->bind_param("i", $turma_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $valid_aluno_ids = [];
        while ($row = $result->fetch_assoc()) {
            $valid_aluno_ids[] = $row['id'];
        }

        
        foreach ($presencas as $aluno_id => $status) {
            
            if (in_array($aluno_id, $valid_aluno_ids)) {
                
                $stmt = $conn->prepare("
                    SELECT id 
                    FROM presencas 
                    WHERE user_id = ? AND turma_id = ? AND aluno_id = ? AND data = ?
                ");
                $stmt->bind_param("iiis", $user_id, $turma_id, $aluno_id, $data);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    
                    $row = $result->fetch_assoc();
                    $stmt = $conn->prepare("
                        UPDATE presencas 
                        SET presenca = ? 
                        WHERE id = ?
                    ");
                    $stmt->bind_param("si", $status, $row['id']);
                    $stmt->execute();
                } else {
                    
                    $stmt = $conn->prepare("
                        INSERT INTO presencas (user_id, turma_id, aluno_id, data, presenca) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->bind_param("iiiss", $user_id, $turma_id, $aluno_id, $data, $status);
                    $stmt->execute();
                }
            } else {
                
                error_log("Erro: Aluno ID inválido ($aluno_id) para a turma ($turma_id)");
            }
        }

        
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro: Dados do formulário ausentes.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>