
<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
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
    <title>FinanControl - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-login">

<div class="login">

    <h1>FinanControl</h1>

    <p>Entre na sua conta</p>

    <?php if (isset($_GET["erro"])): ?>
        <div id="mensagem">
            <?= htmlspecialchars($_GET["erro"]) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["sucesso"])): ?>
        <div class="sucesso">
            <?= htmlspecialchars($_GET["sucesso"]) ?>
        </div>
    <?php endif; ?>

    <form action="autenticar.php" method="POST">

        <label>E-mail</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Senha</label>

        <input
            type="password"
            name="senha"
            required
        >

        <button type="submit">
            Entrar
        </button>

    </form>

    <a
        class="cadastro-link"
        href="cadastro.php"
    >
        Ainda não tenho uma conta
    </a>

</div>

</body>
</html>