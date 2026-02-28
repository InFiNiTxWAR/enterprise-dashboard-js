<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$dataInicio = $_GET['inicio'] ?? '';
$dataFim    = $_GET['fim'] ?? '';

$query = "
    SELECT 
        vendas.id,
        vendas.data_venda,
        vendas.valor,
        vendas.status,
        clientes.nome,
        clientes.email,
        clientes.cidade
    FROM vendas
    INNER JOIN clientes 
        ON vendas.cliente_id = clientes.id
";

$params = [];
$types = "";

if ($dataInicio && $dataFim) {
    $query .= " WHERE vendas.data_venda BETWEEN ? AND ?";
    $params[] = $dataInicio;
    $params[] = $dataFim;
    $types = "ss";
}

$query .= " ORDER BY vendas.data_venda ASC";

$stmt = $conn->prepare($query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$vendas = [];
$totalFaturamento = 0;

while ($row = $result->fetch_assoc()) {
    $vendas[] = $row;

    if ($row['status'] === 'Pago') {
        $totalFaturamento += $row['valor'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <link rel="stylesheet" href="cc/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

    <aside class="sidebar">
        <h2 class="logo">Enterprise</h2>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li class="active"><a href="relatorios.php">Relatórios</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="configuracoes.php">Configurações</a></li>
        </ul>
    </aside>

    <main class="main-content">

        <header class="header">
            <h1>Relatórios</h1>
            <div class="user">
                Bem-vindo, <?= $_SESSION['user']; ?>
            </div>
        </header>

        <!-- TOTAL FATURAMENTO -->
        <div class="card">
            <h3>Faturamento Total (Vendas Pagas)</h3>
            <p style="font-size:24px; font-weight:bold;">
                R$ <?= number_format($totalFaturamento, 2, ',', '.'); ?>
            </p>
        </div>

        <!-- FILTRO -->
        <div class="card">
            <h3>Filtrar por período</h3>
            <form method="GET" style="margin-top:15px; display:flex; gap:10px; flex-wrap:wrap;">
                <input type="date" name="inicio" value="<?= $dataInicio ?>">
                <input type="date" name="fim" value="<?= $dataFim ?>">
                <button type="submit">Filtrar</button>
            </form>
        </div>

        <!-- GRÁFICO -->
        <div class="chart-box" style="margin-top:20px;">
            <h3>Faturamento</h3>
            <canvas id="grafico"></canvas>
        </div>

        <!-- TABELA -->
        <div style="margin-top:20px;">
            <h3>Detalhamento</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Cidade</th>
                        <th>Status</th>
                        <th>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendas as $v): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($v['data_venda'])) ?></td>
                            <td><?= $v['nome']; ?></td>
                            <td><?= $v['email']; ?></td>
                            <td><?= $v['cidade']; ?></td>
                            <td><?= $v['status']; ?></td>
                            <td>R$ <?= number_format($v['valor'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<script>
const dados = <?= json_encode($vendas); ?>;

const labels = dados.map(v => {
    const data = new Date(v.data_venda);
    return data.toLocaleDateString('pt-BR');
});

const valores = dados.map(v => v.valor);

new Chart(document.getElementById('grafico'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Faturamento (R$)',
            data: valores,
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
</html>