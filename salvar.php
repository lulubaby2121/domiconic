
<?php


session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require "conexao.php";

$descricao = trim($_POST["descricao"] ?? "");
$valor = (float)($_POST["valor"] ?? 0);
$tipo = $_POST["tipo"] ?? "";
$data = $_POST["data"] ?? "";
$categoria = trim($_POST["categoria"] ?? "");

if (
    $descricao === "" ||
    $valor <= 0 ||
    !in_array($tipo, ["ENTRADA", "SAIDA"]) ||
    $data === "" ||
    $categoria === ""
) {
    die("Dados inválidos.");
}

$stmt = $pdo->prepare(
    "INSERT INTO transacoes
    (usuario_id, descricao, valor, tipo, data, categoria)
    VALUES (?, ?, ?, ?, ?, ?)"
);

$stmt->execute([
    $_SESSION["usuario_id"],
    $descricao,
    $valor,
    $tipo,
    $data,
    $categoria
]);

header("Location: index.php");
exit;