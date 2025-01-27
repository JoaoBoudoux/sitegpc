<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabela = $_POST["tabela"];
    $arquivo = $tabela . "_dados.csv";

    // Query para buscar os dados da tabela selecionada
    $query = "SELECT * FROM $tabela";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $fp = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$arquivo\"");

        // Pegando os nomes das colunas
        $colunas = $result->fetch_fields();
        $cabecalho = [];
        foreach ($colunas as $coluna) {
            $cabecalho[] = $coluna->name;
        }
        fputcsv($fp, $cabecalho);

        // Pegando os dados da tabela
        while ($row = $result->fetch_assoc()) {
            fputcsv($fp, $row);
        }

        fclose($fp);
        exit();
    } else {
        echo "<script>alert('Nenhum dado encontrado para esta opção.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Baixar Dados</title>
    <link rel="stylesheet" href="baixar_dados.css">
</head>
<body>

    <header>
     <img src="planetinha.png" alt="Logo do Colégio" class="logo">
     <div class="user-area">
         <span class="user-info">Bem-vindo: <?php echo $_SESSION['login']; ?></span>
         <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
     </div>
    </header>

    <h2>Baixar Relatório</h2>
    <form action="baixar_dados.php" method="POST">
        <label for="tabela">Selecione os dados que deseja baixar:</label>
        <select id="tabela" name="tabela" required>
            <option value="users">Usuários</option>
            <option value="turmas">Turmas</option>
            <option value="alunos">Alunos</option>
            <option value="presencas">Presenças</option>
            <option value="relatorios_estudantis">Relatórios</option>
            <option value="avaliacoes_professores">Avaliação dos Professores</option>
            <option value="relatorio_diario">Relatório Diario</option>
        </select>
        <button type="submit" class="botaobaixar">Baixar</button>
    </form>
</body>
</html>