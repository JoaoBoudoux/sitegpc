<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// Obtém as turmas do banco de dados
$sql = "SELECT id, nome FROM turmas";
$result = $conn->query($sql);

$turmas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $turmas[] = $row;
    }
}

// Obtém os alunos da turma selecionada (se houver uma seleção)
$alunos = [];
if (isset($_POST['turma'])) {
    $turma_id = $_POST['turma'];

    // Consulta para buscar alunos da turma selecionada
    $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Armazena os alunos na variável $alunos
    while ($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./estilodash.css">

</head>
<body>
    <header>
     <img src="planetinha.png" alt="Logo do Colégio" class="logo">
     <div class="user-area">
         <span class="user-info">Bem-vindo: <?php echo $_SESSION['login']; ?></span>
         <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
     </div>
    </header>
    <div class="container">

        <!-- Seção 1: Relatório Diário -->
        <section class="section diario">
            <h2>Relatório Diário</h2>
            <form action="salvar_relatorio.php" method="POST">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required>

                <label for="turma">Selecione a turma:</label>
                <select id="turma" name="turma" required>
                    <option value="">Selecione uma turma</option>
                    <?php foreach ($turmas as $turma) : ?>
                        <option value="<?php echo $turma['id']; ?>"><?php echo htmlspecialchars($turma['nome']); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o que foi realizado em sala" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>


        <!-- Seção 2: Presença -->
        <section class="section presenca">
            <h2>Presença</h2>
            <form action="salvar_presenca.php" method="POST">
                <label for="data-presenca">Data:</label>
                <input type="date" id="data-presenca" name="data" required>

                <label for="turma-presenca">Selecione a turma:</label>
                <select id="turma-presenca" name="turma" required>
                    <option value="">Selecione a turma</option>
                    <?php foreach ($turmas as $turma) : ?>
                        <option value="<?php echo $turma['id']; ?>"><?php echo htmlspecialchars($turma['nome']); ?></option>
                    <?php endforeach; ?>
                </select>

                <div id="lista-alunos">
                    <!-- Os alunos serão carregados dinamicamente aqui -->
                </div>

                <button type="submit">Confirmar Presença</button>
            </form>
        </section>

        <script>
            document.getElementById("turma-presenca").addEventListener("change", function() {
                var turmaId = this.value;

                if (turmaId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "buscar_alunos.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            document.getElementById("lista-alunos").innerHTML = xhr.responseText;
                        }
                    };

                    xhr.send("turma=" + turmaId);
                } else {
                    document.getElementById("lista-alunos").innerHTML = "";
                }
            });
        </script>


        <script>
        function carregarAlunos() {
            var turmaId = document.getElementById("turma-presenca").value;
            var listaAlunos = document.getElementById("lista-alunos");

            if (turmaId !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "carregar_alunos.php?turma_id=" + turmaId, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        listaAlunos.innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            } else {
                listaAlunos.innerHTML = "";
            }
        }
        </script>

        <!-- Seção 3: Relatório Estudantil -->
        <section class="section estudantil">
            <h2>Relatório Estudantil</h2>
            <form action="salvar_relatorio_estudantil.php" method="POST" id="relatorio-form">
                <label for="turma-estudantil">Selecione a turma:</label>
                <select id="turma-estudantil" name="turma-estudantil" required>
                    <option value="">Selecione uma turma</option>
                    <?php 
                    include_once('config.php');
                    $turmas_query = $conn->query("SELECT id, nome FROM turmas");
                    while ($turma = $turmas_query->fetch_assoc()) :
                    ?>
                        <option value="<?php echo $turma['id']; ?>">
                            <?php echo htmlspecialchars($turma['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="aluno-estudantil">Selecione o aluno:</label>
                <select id="aluno-estudantil" name="aluno-estudantil" required>
                    <option value="">Selecione uma turma primeiro</option>
                </select>

                <label for="relatorio-aluno">Relatório sobre o aluno:</label>
                <textarea id="relatorio-aluno" name="relatorio-aluno" rows="4" placeholder="Descreva o desempenho do aluno" required></textarea>

                <button type="submit">Enviar Relatório</button>
            </form>
        </section>

        <script>
        // Captura mudanças na seleção de turma
        document.getElementById('turma-estudantil').addEventListener('change', function() {
            const turmaId = this.value;
            const alunoSelect = document.getElementById('aluno-estudantil');

            // Reseta o campo de alunos
            alunoSelect.innerHTML = '<option value="">Carregando alunos...</option>';
            alunoSelect.disabled = true;

            if (turmaId) {
                // Faz uma requisição AJAX para buscar os alunos da turma
                fetch(`carregar_alunos_estudantil.php?turma_id=${turmaId}`)
                    .then(response => response.json())
                    .then(data => {
                        alunoSelect.innerHTML = '<option value="">Selecione um aluno</option>';
                        data.forEach(aluno => {
                            const option = document.createElement('option');
                            option.value = aluno.id;
                            option.textContent = aluno.nome;
                            alunoSelect.appendChild(option);
                        });
                        alunoSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar alunos:', error);
                        alunoSelect.innerHTML = '<option value="">Erro ao carregar alunos</option>';
                    });
            } else {
                alunoSelect.innerHTML = '<option value="">Selecione a turma primeiro</option>';
                alunoSelect.disabled = false;
            }
        });
        </script>

    </div>

    <script>
        function mostrarAlunos() {
            let turma = document.getElementById("turma-presenca").value;
            let listaAlunos = document.getElementById("lista-alunos");
            
            listaAlunos.innerHTML = ""; // Limpa a lista anterior

            if (turma === "turma1") {
                listaAlunos.innerHTML = `
                    <label><input type="checkbox" name="aluno" value="aluno1"> Aluno 1</label>
                    <label><input type="checkbox" name="aluno" value="aluno2"> Aluno 2</label>
                `;
            } else if (turma === "turma2") {
                listaAlunos.innerHTML = `
                    <label><input type="checkbox" name="aluno" value="aluno3"> Aluno 3</label>
                    <label><input type="checkbox" name="aluno" value="aluno4"> Aluno 4</label>
                `;
            }
        }

        function mostrarAlunosEstudantil() {
            let turma = document.getElementById("turma-estudantil").value;
            let alunoSelect = document.getElementById("aluno-estudantil");

            alunoSelect.innerHTML = `<option value="">Selecione um aluno</option>`; // Limpa antes de adicionar

            if (turma === "turma1") {
                alunoSelect.innerHTML += `
                    <option value="aluno1">Aluno 1</option>
                    <option value="aluno2">Aluno 2</option>
                `;
            } else if (turma === "turma2") {
                alunoSelect.innerHTML += `
                    <option value="aluno3">Aluno 3</option>
                    <option value="aluno4">Aluno 4</option>
                `;
            }
        }
    </script>

<div class="diario-classe">
    <h2 class="titulodiario">Diário de Classe</h2>
    <form id="diarioForm" action="diario_classe.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Horário</th>
                    <th>Selecionar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "config.php";
                $sql = "SELECT id, nome, horario FROM turmas";
                $resultado = $conn->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['horario']) . "</td>";
                        echo "<td><input type='radio' name='turma' value='" . $row['id'] . "' required></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhuma turma encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button class="botao-diario" type="submit">Continuar</button>
    </form>
</div>


<div class="planejamento-anual">
    <h2>Planejamento Anual</h2>
    <form action="planejamento.php" method="POST">
    <table>
        <thead>
            <tr>
                <th>Faixa Etária</th>
                <th>Selecionar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>0 a 1 ano e 6 meses</td>
                <td><input type="radio" name="faixa_etaria" value="0-1a6m" required></td>
            </tr>
            <tr>
                <td>1 ano e 7 meses a 3 anos e 11 meses</td>
                <td><input type="radio" name="faixa_etaria" value="1a7m-3a11m"></td>
            </tr>
            <tr>
                <td>4 anos a 5 anos e 11 meses</td>
                <td><input type="radio" name="faixa_etaria" value="4a-5a11m"></td>
            </tr>
        </tbody>
    </table>
    <button type="submit" class="btn-planejamento">Prosseguir</button>
</form>
</div>

</body>
<footer>
  <p>Todos os direitos reservados © 2025 Colégio Geração Planeta Criança</p>
</footer>
</html>