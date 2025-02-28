<?php
session_start();
include_once('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["tipo"] !== "coordenador") {
    header("Location: index.html");
    exit();
}

function getDaysInMonth($month, $year) {
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

$turmas = $conn->query("SELECT id, nome FROM turmas");
$alunos = [];
$presencas = [];
$selected_turma = isset($_POST['turma']) ? $_POST['turma'] : null;
$selected_month = isset($_POST['month']) ? $_POST['month'] : date('m');
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');

if ($selected_turma) {
    // Obter alunos da turma selecionada
    $stmt = $conn->prepare("SELECT id, nome FROM alunos WHERE turma_id = ?");
    $stmt->bind_param("i", $selected_turma);
    $stmt->execute();
    $alunos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Obter presenças dos alunos no mês selecionado
    $stmt = $conn->prepare("
        SELECT aluno_id, data, presenca 
        FROM presencas 
        WHERE aluno_id IN (SELECT id FROM alunos WHERE turma_id = ?) 
        AND MONTH(data) = ? AND YEAR(data) = ?
    ");
    $stmt->bind_param("iii", $selected_turma, $selected_month, $selected_year);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Mapeando 'P' para 1 (presente) e 'F' para 0 (faltou), tratando valores inesperados como null
        $presencas[$row['aluno_id']][$row['data']] = ($row['presenca'] === 'P') ? 1 : (($row['presenca'] === 'F') ? 0 : null);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Presenças</title>
    <link rel="stylesheet" href="presenca.css">
</head>
<body>
<header>
    <img src="planetinha.png" alt="Logo" class="logo">
    <div class="user-area">Bem-vindo: <?php echo $_SESSION['login']; ?></div>
    <div class="buttons">

            <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "coordenador") : ?>
                <button class="back-button" onclick="window.location.href='coordenador.php'">Voltar</button>
            <?php endif; ?>

        <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
    </div>
    </header>

    <h2>Controle de Presenças</h2>

    <!-- Formulário para selecionar turma e mês -->
    <form method="POST">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" id="turma" onchange="this.form.submit()">
            <option value="">-- Escolha uma turma --</option>
            <?php while ($turma = $turmas->fetch_assoc()): ?>
                <option value="<?php echo $turma['id']; ?>" <?php echo $selected_turma == $turma['id'] ? 'selected' : ''; ?>>
                    <?php echo $turma['nome']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="month">Mês:</label>
        <select name="month" id="month" onchange="this.form.submit()">
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?php echo $m; ?>" <?php echo $selected_month == $m ? 'selected' : ''; ?>>
                    <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                </option>
            <?php endfor; ?>
        </select>

        <label for="year">Ano:</label>
        <select name="year" id="year" onchange="this.form.submit()">
            <?php for ($y = date('Y') - 1; $y <= date('Y') + 5; $y++): ?>
                <option value="<?php echo $y; ?>" <?php echo $selected_year == $y ? 'selected' : ''; ?>>
                    <?php echo $y; ?>
                </option>
            <?php endfor; ?>
        </select>
    </form>

    <?php if ($selected_turma && !empty($alunos)): ?>
        <h3>Alunos da Turma</h3>
        <?php foreach ($alunos as $aluno): ?>
            <div>
                <h4><?php echo $aluno['nome']; ?></h4>
                <div class="calendar">
                    <?php
                    $days_in_month = getDaysInMonth($selected_month, $selected_year);
                    for ($day = 1; $day <= $days_in_month; $day++):
                        $date = sprintf("%04d-%02d-%02d", $selected_year, $selected_month, $day);
                        $presente = isset($presencas[$aluno['id']][$date]) ? $presencas[$aluno['id']][$date] : null;
                    ?>
                        <div class="day <?php echo $presente === 1 ? 'presente' : ($presente === 0 ? 'faltou' : ''); ?>">
                            <?php echo $day; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>