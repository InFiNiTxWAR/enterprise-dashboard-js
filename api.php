<?php
require 'config.php';

header('Content-Type: application/json');



$vendasMensais = [];
$meses = [];

$result = $conn->query("SELECT mes, valor FROM vendas");

while ($row = $result->fetch_assoc()) {
    $meses[] = $row['mes'];
    $vendasMensais[] = $row['valor'];
}



$data = [
    "labels" => $meses,
    "vendasMensais" => $vendasMensais,
    "produtos" => [
        "Produto A" => 35,
        "Produto B" => 25,
        "Produto C" => 20,
        "Produto D" => 20
    ],
    "comparativoAnual" => [150000, 210000, 280000, 340000]
];

echo json_encode($data);