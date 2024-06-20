<?php
header('Content-Type: application/json');

$host = 'db';
$db = 'CadastroAnimais';
$user = 'usuario';
$pass = 'senha';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action == 'read') {
    $stmt = $pdo->query('SELECT * FROM pets');
    echo json_encode(['itens' => $stmt->fetchAll()]);
} elseif ($action == 'create') {
    $nome = $_POST['nome'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $tutor = $_POST['tutor'];

    $stmt = $pdo->prepare('INSERT INTO pets (nome, raca, idade, tutor) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nome, $raca, $idade, $tutor]);
    
    echo json_encode(['success' => true]);
} elseif ($action == 'update') {
    $id = $_POST['id'] ?? null;
    $nome = $_POST['nome'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $tutor = $_POST['tutor'];

    $stmt = $pdo->prepare('UPDATE pets SET nome = ?, raca = ?, idade = ?, tutor = ? WHERE id = ?');
    $stmt->execute([$nome, $raca, $idade, $tutor, $id]);
    echo json_encode(['success' => true]);
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM pets WHERE id = ?');
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
}
?>
