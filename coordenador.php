<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página do Coordenador</title>
    <link rel="stylesheet" href="coordenador.css">
</head>
<body>
    
    <header>
     <img src="planetinha.png" alt="Logo do Colégio" class="logo">
     <div class="user-area">
         <span class="user-info">Bem-vindo: <?php echo $_SESSION['login']; ?></span>
         <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
     </div>
    </header>

    <ul>
        <li><a href="baixar_dados.php">📥 Baixar Dados do Banco</a></li>
        <li><a href="dashboard.php">📌 Ir para o Portal dos Professores</a></li>
        <li><a href="register.php">📝 Registrar Novo Usuário</a></li>
    </ul>

</body>
</html>