<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabela = $_POST["tabela"];
    $arquivo = $tabela . "_relatorio.html";

    if ($tabela == "relatorios_estudantis") {
        $query = "
            SELECT r.id, 
                   u.login AS Professor, 
                   t.nome AS Turma, 
                   a.nome AS Aluno, 
                   r.ano, 
                   r.bimestre, 
                   r.data_relatorio, 
                   r.descricao
            FROM relatorios_estudantis r
            LEFT JOIN users u ON r.professor_id = u.id
            LEFT JOIN turmas t ON r.turma_id = t.id
            LEFT JOIN alunos a ON r.aluno_id = a.id
        ";
    } elseif ($tabela == "relatorio_anual") {
        $query = "
            SELECT r.id, 
                   u.login AS Professor, 
                   t.nome AS Turma, 
                   a.nome AS Aluno, 
                   r.ano, 
                   r.descricao
            FROM relatorio_anual r
            LEFT JOIN users u ON r.users_id = u.id
            LEFT JOIN turmas t ON r.turma = t.id
            LEFT JOIN alunos a ON r.aluno_id = a.id
        ";
    } else {
        $query = "SELECT * FROM $tabela";
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
                body { font-family: 'Arial', sans-serif; font-size: 12pt; margin: 20px; }
                h2 { text-align: center; font-size: 18pt; font-weight: bold; color: #333; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 30px; font-size: 10pt; text-align: center; color: #666; }
              </style>";
        echo "</head>";
        echo "<body>";
        echo "<h2>Relatório Acadêmico</h2>";
        echo "<table>";

        // Cabeçalho
        echo "<tr>";
        $colunas = $result->fetch_fields();
        foreach ($colunas as $coluna) {
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
        echo "<p class='footer'>Relatório gerado por [Nome do Colégio] em " . date("d/m/Y") . "</p>";
        echo "</body></html>";

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
    <script>
        function carregarProfessoresEAlunos() {
            var tipoRelatorio = document.getElementById("tipo_relatorio").value;
            if (tipoRelatorio) {
                fetch("carregar_professores_alunos.php?tipo=" + tipoRelatorio)
                    .then(response => response.json())
                    .then(data => {
                        let professorSelect = document.getElementById("professor");
                        let alunoSelect = document.getElementById("aluno");

                        professorSelect.innerHTML = '<option value="">Selecione um Professor</option>';
                        alunoSelect.innerHTML = '<option value="">Selecione um Aluno</option>';

                        data.professores.forEach(professor => {
                            let option = document.createElement("option");
                            option.value = professor.id;
                            option.textContent = professor.nome;
                            professorSelect.appendChild(option);
                        });

                        data.alunos.forEach(aluno => {
                            let option = document.createElement("option");
                            option.value = aluno.id;
                            option.textContent = aluno.nome;
                            alunoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Erro ao carregar os dados:", error));
            }
        }
    </script>
</head>
<body>

<header>
    <img src="planetinha.png" alt="Logo do Colégio" class="logo">
    <div class="user-area">
        <span class="user-info">Bem-vindo: <?php echo $_SESSION['login']; ?></span>
        <button onclick="window.location.href='coordenador.php'" class="back-button">Voltar</button>
        <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
    </div>
</header>

<h2>Baixar relatórios</h2>

<!-- Primeira box -->
<form action="baixar_dados.php" method="POST">
    <label for="tabela">Selecione os dados que deseja baixar:</label>
    <select id="tabela" name="tabela" required>
        <option value="users">Usuários</option>
        <option value="turmas">Turmas</option>
        <option value="alunos">Alunos</option>
        <option value="presencas">Presenças</option>
        <option value="avaliacoes_professores">Avaliação dos Professores</option>
    </select>
    <button type="submit" class="botaobaixar">Baixar</button>
</form>

<!-- relatório específico -->
<h2>Baixar relatório Anual / Bimestral</h2>
<form action="baixar_relatorio_especifico.php" method="POST">
    <label for="tipo_relatorio">Selecione o Tipo de Relatório:</label>
    <select id="tipo_relatorio" name="tipo_relatorio" required onchange="exibirCampos()">
        <option value="">Selecione</option>
        <option value="relatorio_anual">Relatório Anual</option>
        <option value="relatorios_estudantis">Relatório Bimestral</option>
    </select>

    <div id="ano_div" style="display: none;">
        <label for="ano">Selecione o Ano:</label>
        <select id="ano" name="ano">
            <option value="">Selecione o Ano</option>
            <?php for ($i = date("Y"); $i <= 2040;$i++ ) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>

    <div id="bimestre_div" style="display: none;">
        <label for="bimestre">Selecione o Bimestre:</label>
        <select id="bimestre" name="bimestre">
            <option value="">Todos</option>
            <option value="1">1º Bimestre</option>
            <option value="2">2º Bimestre</option>
            <option value="3">3º Bimestre</option>
            <option value="4">4º Bimestre</option>
        </select>
    </div>

    <label for="professor">Selecione o Professor:</label>
    <select id="professor" name="professor" required>
        <option value="">Selecione um Professor</option>
    </select>

    <label for="aluno">Selecione o Aluno:</label>
    <select id="aluno" name="aluno" required>
        <option value="">Selecione um Aluno</option>
    </select>

    <button type="submit" class="botaobaixar">Baixar Relatório</button>
</form>

<script>
function exibirCampos() {
    let tipoRelatorio = document.getElementById("tipo_relatorio").value;
    document.getElementById("ano_div").style.display = (tipoRelatorio !== "") ? "block" : "none";
    document.getElementById("bimestre_div").style.display = (tipoRelatorio === "relatorios_estudantis") ? "block" : "none";
}

document.getElementById("tipo_relatorio").addEventListener("change", function () {
    let tipoRelatorio = this.value;
    
    if (tipoRelatorio !== "") {
        fetch(`carregar_professores_alunos.php?tipo=${tipoRelatorio}`)
            .then(response => response.json())
            .then(data => {
                let professorSelect = document.getElementById("professor");
                let alunoSelect = document.getElementById("aluno");

                professorSelect.innerHTML = '<option value="">Selecione um Professor</option>';
                alunoSelect.innerHTML = '<option value="">Selecione um Aluno</option>';

                data.professores.forEach(professor => {
                    professorSelect.innerHTML += `<option value="${professor.id}">${professor.nome}</option>`;
                });

                data.alunos.forEach(aluno => {
                    alunoSelect.innerHTML += `<option value="${aluno.id}">${aluno.nome}</option>`;
                });
            })
            .catch(error => console.error("Erro ao buscar dados:", error));
    }
});
</script>


</body>
</html>


