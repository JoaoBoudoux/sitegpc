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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Página do Coordenador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="coordenador.css">
</head>
<body>
    <header class="bg-dark text-white py-2 w-100">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="planetinha.png" alt="Logo" class="logo">
                </div>
                <div class="user-area">
                    Bem-vindo: <?php echo $_SESSION['login']; ?>
                </div>
                <div class="buttons d-flex">
                    <button class="btn btn-outline-light me-2 back-button" onclick="window.location.href='coordenador.php'">Voltar</button>
                    <button class="btn btn-outline-light logout-button" onclick="window.location.href='logout.php'">Sair</button>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <a href="baixar_dados.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-download fs-2 text-primary"></i>
                        <h5 class="card-title mt-2">Baixar Dados do Banco</h5>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="dashboard.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-person-workspace fs-2 text-danger"></i> 
                        <h5 class="card-title mt-2">Ir para o Portal dos Professores</h5>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="alterar_senha.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-lock fs-2 text-warning"></i> 
                        <h5 class="card-title mt-2">Alterar Senha</h5>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="register.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-person-plus fs-2 text-primary"></i>
                        <h5 class="card-title mt-2">Registrar Novo Usuário</h5>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="cadastrar_aluno.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-person fs-2 text-primary"></i>
                        <h5 class="card-title mt-2">Cadastrar Aluno</h5>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="presenca.php" class="card text-decoration-none text-dark">
                    <div class="card-body text-center">
                        <i class="bi bi-check2-square fs-2 text-info"></i> 
                        <h5 class="card-title mt-2">Presenças</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>