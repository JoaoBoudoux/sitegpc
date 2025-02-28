<?php
session_start();
include_once("config.php");

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

// Buscar os usuários no banco de dados :)
$sql = "SELECT id, login FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="alterar_senha.css">
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

    <h2>Alterar Senha</h2>

    <form action="processar_alteracao_senha.php" method="post">
        <label for="usuario">Selecionar Usuário:</label>
        <select id="usuario" name="usuario" required>
            <option value="">Selecione um usuário</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['login']; ?></option>
            <?php } ?>
        </select>

        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>

        <label for="confirmar_senha">Confirmar Nova Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>

        <button type="submit">Alterar Senha</button>
    </form>
</body>
</html>

