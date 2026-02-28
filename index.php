<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>
<?php $pagina = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Dashboard</title>
    <link rel="stylesheet" href="cc/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">

        <aside class="sidebar">
    <h2 class="logo">Enterprise</h2>
    <nav>
        <ul>
        <li class="<?= $pagina == 'index.php' ? 'active' : '' ?>">
    <a href="index.php">Dashboard</a>
</li>

            <li>
                <a href="relatorios.php">Relatórios</a>
            </li>

            <li>
                <a href="clientes.php">Clientes</a>
            </li>

            <li>
                <a href="configuracoes.php">Configurações</a>
            </li>
        </ul>
    </nav>
</aside>
        <main class="main-content">
            <header class="header">
                <h1>Dashboard</h1>
                <div class="user">
                    <span>Bem-Vindo, Diego</span>
                
                </div>
            </header>
            <section class="cards">
                <div class="card">
                    <h3>Faturamento</h3>
                    <p>R$ 45.800</p>
                    <span class="positive">+12% este mês</span>
                </div>
                <div class="card">
                    <h3>Novos Clientes</h3>
                    <p>320</p>
                    <span class="positive">+8% este mês</span>
                </div>
                <div class="card">
                    <h3>Pedidos</h3>
                    <p>1.245</p>
                    <span class="negative">-3% este mês</span>
                </div>
                <div class="card">
                    <h3>taxa de Conversão</h3>
                    <p>4.8%</p>
                    <span class="negative">+1.2%</span>

                </div>

            </section>

            <section class="charts">
                <div class="chart-box">
                    <h3>Vendas Mensais</h3>
                    <canvas id="lineChart"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Distribuição de Produtos</h3>
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="chart-box full-width">
                    <h3>Comparativo anual</h3>
                    <canvas id="barChart"></canvas>
                </div>
            </section>
        </main>
    </div>
    <script src="js/script.js"></script>
</body>
</html>