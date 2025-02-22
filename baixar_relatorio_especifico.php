<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_relatorio = $_POST["tipo_relatorio"];
    $professor_id = $_POST["professor"];
    $aluno_id = $_POST["aluno"];
    $ano = $_POST["ano"] ?? "";
    $bimestre = $_POST["bimestre"] ?? "";
    $arquivo = $tipo_relatorio . "_relatorio.doc";

    $query = "";

    if ($tipo_relatorio == "relatorios_estudantis") {
        $query = "
            SELECT u.login AS Professor, t.nome AS Turma, a.nome AS Aluno, 
                   r.ano, r.bimestre, r.data_relatorio AS Data, r.descricao AS Descrição
            FROM relatorios_estudantis r
            LEFT JOIN users u ON r.professor_id = u.id
            LEFT JOIN turmas t ON r.turma_id = t.id
            LEFT JOIN alunos a ON r.aluno_id = a.id
            WHERE r.professor_id = '$professor_id' 
              AND r.aluno_id = '$aluno_id'
              AND ('$ano' = '' OR r.ano = '$ano')
              AND ('$bimestre' = '' OR r.bimestre = '$bimestre')
        ";
    } elseif ($tipo_relatorio == "relatorio_anual") {
        $query = "
            SELECT u.login AS Professor, t.nome AS Turma, a.nome AS Aluno, r.ano, r.descricao AS Descrição
            FROM relatorio_anual r
            LEFT JOIN users u ON r.users_id = u.id
            LEFT JOIN turmas t ON r.turma = t.id
            LEFT JOIN alunos a ON r.aluno_id = a.id
            WHERE r.users_id = '$professor_id' 
              AND r.aluno_id = '$aluno_id'
              AND ('$ano' = '' OR r.ano = '$ano')
        ";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=\"$arquivo\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<html>";
        echo "<head><meta charset='UTF-8'>";
        echo "<style>
                @page { size: A4; margin: 2cm; }
                body { font-family: 'Arial', sans-serif; font-size: 12pt; }
                h2 { text-align: center; font-size: 18pt; font-weight: bold; color: #333; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; page-break-inside: avoid; }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; font-size: 10pt; text-align: center; color: #666; }
              </style>";
        echo "</head>";
        echo "<body>";
        echo "<h2>Relatório Acadêmico</h2>";
        echo "<table>";

        // Cabeçalhos 
        echo "<tr>";
        foreach ($result->fetch_fields() as $coluna) {
            echo "<th>" . ucfirst($coluna->name) . "</th>";
        }
        echo "</tr>";

        // Dados da tabela
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $valor) {
                echo "<td>" . nl2br(htmlspecialchars($valor)) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

        // Rodape
        echo "<p class='footer'>Relatório gerado por Geração Planeta Criança em " . date("d/m/Y") . "</p>";
        echo "</body></html>";
        exit();
    } else {
        echo "<script>window.location.replace('coordenador.php'); alert('Nenhum dado encontrado!');</script>";
    }
}

$conn->close();
?>
