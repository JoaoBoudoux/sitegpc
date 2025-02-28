<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

include_once('config.php');

// Buscar as turmas 
$turmas_query = $conn->query("SELECT id, nome FROM turmas");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" href="cadastrar_aluno.css">
</head>
<body>

    <header>
    <img src="planetinha.png" alt="Logo" class="logo">
    <div class="user-area">Bem-vindo: <?php echo $_SESSION['login']; ?></div>
    <div class="buttons">
        <button onclick="window.location.href='coordenador.php'" class="back-button">Voltar</button>
        <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
    </div>
    </header>

<h2>Cadastrar Novo Aluno</h2>

<form action="salvar_aluno.php" method="POST">
    <label for="nome">Nome do Aluno:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" required>

    <label for="turma">Turma:</label>
    <select id="turma" name="turma" required>
        <option value="">Selecione a turma</option>
        <?php
        include_once('config.php');
        $turmas_query = $conn->query("SELECT id, nome FROM turmas");
        while ($turma = $turmas_query->fetch_assoc()) :
        ?>
            <option value="<?php echo $turma['id']; ?>"><?php echo htmlspecialchars($turma['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Cadastrar Aluno</button>
</form>

</body>
</html>
