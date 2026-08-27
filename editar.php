
<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require "conexao.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare(
    "SELECT *
     FROM transacoes
     WHERE id = ?
     AND usuario_id = ?"
);

$stmt->execute([
    $id,
    $_SESSION["usuario_id"]
]);

$transacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transacao) {
    die("Transação não encontrada.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $descricao = trim($_POST["descricao"]);
    $valor = (float)$_POST["valor"];
    $tipo = $_POST["tipo"];
    $data = $_POST["data"];
    $categoria = trim($_POST["categoria"]);

    $stmt = $pdo->prepare(
        "UPDATE transacoes
         SET descricao = ?,
             valor = ?,
             tipo = ?,
             data = ?,
             categoria = ?
         WHERE id = ?
         AND usuario_id = ?"
    );

    $stmt->execute([
        $descricao,
        $valor,
        $tipo,
        $data,
        $categoria,
        $id,
        $_SESSION["usuario_id"]
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Editar transação</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-login">

<div class="login">

    <h1>Editar transação</h1>

    <form method="POST">

        <label>Descrição</label>

        <input
            type="text"
            name="descricao"
            value="<?= htmlspecialchars($transacao["descricao"]) ?>"
            required
        >

        <label>Valor</label>

        <input
            type="number"
            name="valor"
            step="0.01"
            value="<?= $transacao["valor"] ?>"
            required
        >

        <label>Tipo</label>

        <select name="tipo">

            <option
                value="ENTRADA"
                <?= $transacao["tipo"] === "ENTRADA" ? "selected" : "" ?>
            >
                Entrada
            </option>

            <option
                value="SAIDA"
                <?= $transacao["tipo"] === "SAIDA" ? "selected" : "" ?>
            >
                Saída
            </option>

        </select>

        <label>Categoria</label>

        <input
            type="text"
            name="categoria"
            value="<?= htmlspecialchars($transacao["categoria"]) ?>"
            required
        >

        <label>Data</label>

        <input
            type="date"
            name="data"
            value="<?= $transacao["data"] ?>"
            required
        >

        <button type="submit">
            Atualizar
        </button>

    </form>

    <a
        href="index.php"
        class="cadastro-link"
    >
        Voltar
    </a>

</div>

</body>
</html>