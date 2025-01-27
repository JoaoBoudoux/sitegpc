<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turma_id = $_POST['turma'] ?? null;
    $data = $_POST['data'] ?? null;
    $presencas = $_POST['presenca'] ?? null; // Array de presenças

    // Verifica se os dados necessários estão presentes
    if (!empty($turma_id) && !empty($data) && !empty($presencas)) {
        // Mapear os valores 'presente' e 'faltou' para 'P' e 'F'
        foreach ($presencas as $aluno_id => $status) {
            if ($status == "presente") {
                $presencas[$aluno_id] = "P"; // Mapeando "presente" para "P"
            } elseif ($status == "falta") {
                $presencas[$aluno_id] = "F"; // Mapeando "faltou" para "F"
            }
        }

        // Consulta para obter IDs de alunos válidos da turma selecionada
        $stmt = $conn->prepare("SELECT id FROM alunos WHERE turma_id = ?");
        $stmt->bind_param("i", $turma_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $valid_aluno_ids = [];
        while ($row = $result->fetch_assoc()) {
            $valid_aluno_ids[] = $row['id'];
        }

        // Processa cada presença enviada
        foreach ($presencas as $aluno_id => $status) {
            // Verifica se o aluno pertence à turma
            if (in_array($aluno_id, $valid_aluno_ids)) {
                // Verifica se já existe um registro para o aluno na mesma data e turma
                $stmt = $conn->prepare("
                    SELECT id 
                    FROM presencas 
                    WHERE user_id = ? AND turma_id = ? AND aluno_id = ? AND data = ?
                ");
                $stmt->bind_param("iiis", $user_id, $turma_id, $aluno_id, $data);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Atualiza o registro existente
                    $row = $result->fetch_assoc();
                    $stmt = $conn->prepare("
                        UPDATE presencas 
                        SET presenca = ? 
                        WHERE id = ?
                    ");
                    $stmt->bind_param("si", $status, $row['id']);
                    $stmt->execute();
                } else {
                    // Insere um novo registro
                    $stmt = $conn->prepare("
                        INSERT INTO presencas (user_id, turma_id, aluno_id, data, presenca) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->bind_param("iiiss", $user_id, $turma_id, $aluno_id, $data, $status);
                    $stmt->execute();
                }
            } else {
                // Log de erro para IDs inválidos
                error_log("Erro: Aluno ID inválido ($aluno_id) para a turma ($turma_id)");
            }
        }

        // Redireciona após o sucesso
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro: Dados do formulário ausentes.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>