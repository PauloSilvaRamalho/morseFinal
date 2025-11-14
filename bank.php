<?php
header('Content-Type: text/plain; charset=utf-8');

$conexao = mysqli_connect('paparella.com.br', 'paparell_prof', '@Senai2025', 'paparell_iot');
if (!$conexao) {
    die('Erro ao conectar: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ======= CONTROLE DO LED =======
    $nome = $_POST['nome'] ?? '';
    $traducao = isset($_POST['traducao']) ? intval($_POST['traducao']) : 0;

    $query = $conexao->prepare("SELECT morse FROM morse_iot WHERE id_morse = ?");
    $query->bind_param("s", $nome);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    $id = $row['id_morse'] ?? null;
    $traducao = $row['traducao']


    if ($id && $traducao == null  ) {
        $query = $conexao->prepare("UPDATE morse_iot SET traducao = ? WHERE id_morse = ?");
        $query->bind_param("ii", $traducao, $id);
        $query->execute();
        echo "traducao: $traducao";
    // } else {
    //     $query = $conexao->prepare("INSERT INTO led (nome_aluno, estado_led) VALUES (?, ?)");
    //     $query->bind_param("si", $nome, $estado);
    //     $query->execute();
    //     echo "LED inserido com estado $estado";
    // }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // ======= LEITURA DE DISTÂNCIA (Luca) =======
    header('Content-Type: application/json; charset=utf-8');
    $nome = $_GET['nome'] ?? 'Luca';

    $query = $conexao->prepare("SELECT valor_cm FROM ultrassom WHERE nome_aluno = ?");
    $query->bind_param("s", $nome);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        echo json_encode(['distancia' => $row['valor_cm']]);
    } else {
        echo json_encode(['distancia' => null]);
    }
}

mysqli_close($conexao);
?>