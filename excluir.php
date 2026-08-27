
<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require "conexao.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare(
    "DELETE FROM transacoes
     WHERE id = ?
     AND usuario_id = ?"
);

$stmt->execute([
    $id,
    $_SESSION["usuario_id"]
]);

header("Location: index.php");
exit;