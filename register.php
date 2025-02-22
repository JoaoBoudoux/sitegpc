<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    $tipo = $_POST["tipo"]; 

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Usuário já cadastrado!";
    } else {
        
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO users (login, senha, tipo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $login, $hashed_password, $tipo);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="register.css">
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

    <h2>Cadastro de Usuário</h2>
    <form action="register.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <label for="tipo">Tipo de usuário:</label>
        <select id="tipo" name="tipo" required>
            <option value="professor">Professor</option>
            <option value="coordenador">Coordenador</option>
        </select><br>

        <button type="submit" class="botaor">Cadastrar</button>
    </form>
</body>
</html>

