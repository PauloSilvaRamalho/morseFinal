<?php
header('Content-Type: text/plain; charset=utf-8');

$conexao = mysqli_connect('paparella.com.br', 'paparell_codigomorse', '@Senai2025', 'paparell_codigomorse');

header('Content-Type: application/json; charset=utf-8');

if (!$conexao) {
    die(json_encode(['erro' => mysqli_connect_error()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // valores enviados do JS
    $nome = $_POST['nome'] ?? '';
    $traducao = isset($_POST['traducao']) ? intval($_POST['traducao']) : null;

    // busca registro pelo nome/id
    $query = $conexao->prepare("SELECT id_morse, morse, traducao FROM morse_iot WHERE id_morse = ?");
    $query->bind_param("s", $nome);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(['erro' => 'Registro não encontrado']);
        exit;
    }

    // se tradução ainda é NULL, atualiza
    if ($row['traducao'] === null) {

        $update = $conexao->prepare("UPDATE morse_iot SET traducao = ? WHERE id_morse = ?");
        $update->bind_param("is", $traducao, $nome);
        $update->execute();

        echo json_encode([
            'status' => 'sucesso',
            'id_morse' => $nome,
            'traducao' => $traducao
        ]);
    } else {

        echo json_encode([
            'status' => 'ja_traduzido',
            'traducao_existente' => $row['traducao']
        ]);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $query = $conexao->prepare("SELECT id_morse, morse, traducao FROM morse_iot");
    $query->execute();
    $result = $query->get_result();

    $lista = [];

    while ($row = $result->fetch_assoc()) {
        $lista[] = $row;
    }

    echo json_encode($lista);
}

mysqli_close($conexao);