<?php

$conexao = mysqli_connect('paparella.com.br', 'paparell_codigomorse', '@Senai2025', 'paparell_codigomorse');
if (!$conexao) {
    die('Erro ao conectar: ' . mysqli_connect_error());
}

$query = $conexao->prepare("SELECT morse FROM morse_iot");
$result = mysqli_query($con, $sql);

$dados  = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dados[] = $row['morse'];
}

echo json_encode($dados);

mysqli_close($conexao);

