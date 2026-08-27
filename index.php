
<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

require "conexao.php";

$stmt = $pdo->prepare(
    "SELECT *
     FROM transacoes
     WHERE usuario_id = ?
     ORDER BY data DESC, id DESC"
);

$stmt->execute([
    $_SESSION["usuario_id"]
]);

$transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$entradas = 0;
$saidas = 0;

foreach ($transacoes as $transacao) {

    if ($transacao["tipo"] === "ENTRADA") {
        $entradas += (float)$transacao["valor"];
    } else {
        $saidas += (float)$transacao["valor"];
    }
}

$saldo = $entradas - $saidas;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FinanControl</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <div>
        <strong>
            Olá, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>!
        </strong>

        <a href="sair.php">
            <button>Sair</button>
        </a>
    </div>

    <div>
        <h1>FinanControl</h1>
        <p>Sistema de Controle Financeiro</p>
    </div>

    <span>
        PHP • MySQL
    </span>

</header>

<main>

<section class="cards">

    <div class="card">
        <span>Entradas</span>

        <strong>
            R$ <?= number_format(
                $entradas,
                2,
                ",",
                "."
            ) ?>
        </strong>
    </div>

    <div class="card">
        <span>Saídas</span>

        <strong>
            R$ <?= number_format(
                $saidas,
                2,
                ",",
                "."
            ) ?>
        </strong>
    </div>

    <div class="card">
        <span>Saldo</span>

        <strong>
            R$ <?= number_format(
                $saldo,
                2,
                ",",
                "."
            ) ?>
        </strong>
    </div>

</section>

<section class="panel">

    <h2>Nova transação</h2>

    <form
        action="salvar.php"
        method="POST"
    >

        <div class="grid">

            <label>
                Descrição

                <input
                    type="text"
                    name="descricao"
                    maxlength="100"
                    required
                >
            </label>

            <label>
                Valor

                <input
                    type="number"
                    name="valor"
                    step="0.01"
                    min="0.01"
                    required
                >
            </label>

            <label>
                Tipo

                <select
                    name="tipo"
                    required
                >

                    <option value="ENTRADA">
                        Entrada
                    </option>

                    <option value="SAIDA">
                        Saída
                    </option>

                </select>

            </label>

            <label>
                Categoria

                <input
                    type="text"
                    name="categoria"
                    maxlength="50"
                    required
                >
            </label>

            <label>
                Data

                <input
                    type="date"
                    name="data"
                    required
                >
            </label>

        </div>

        <div class="actions">

            <button type="submit">
                Salvar
            </button>

        </div>

    </form>

</section>

<section class="panel">

    <h2>Transações cadastradas</h2>

    <div class="table-wrap">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach ($transacoes as $transacao): ?>

                <tr>

                    <td>
                        <?= $transacao["id"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $transacao["descricao"]
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            $transacao["categoria"]
                        ) ?>
                    </td>

                    <td>
                        <?= $transacao["tipo"] === "ENTRADA"
                            ? "Entrada"
                            : "Saída" ?>
                    </td>

                    <td>
                        <?= date(
                            "d/m/Y",
                            strtotime($transacao["data"])
                        ) ?>
                    </td>

                    <td>
                        R$ <?= number_format(
                            $transacao["valor"],
                            2,
                            ",",
                            "."
                        ) ?>
                    </td>

                    <td>

                        <a href="editar.php?id=<?= $transacao["id"] ?>">
                            <button class="edit">
                                Editar
                            </button>
                        </a>

                        <a
                            href="excluir.php?id=<?= $transacao["id"] ?>"
                            onclick="return confirm('Deseja excluir esta transação?')"
                        >
                            <button class="delete">
                                Excluir
                            </button>
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</section>

</main>

</body>
</html>