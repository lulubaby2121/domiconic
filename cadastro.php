
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanControl - Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="pagina-login">

<div class="login">
    <h1>Criar conta</h1>
    <p>Cadastre-se no FinanControl</p>

    <?php if (isset($_GET["erro"])): ?>
        <div id="mensagem">
            <?= htmlspecialchars($_GET["erro"]) ?>
        </div>
    <?php endif; ?>

    <form action="cadastrar.php" method="POST">

        <label>Nome</label>
        <input
            type="text"
            name="nome"
            required
            maxlength="100"
        >

        <label>E-mail</label>
        <input
            type="email"
            name="email"
            required
            maxlength="150"
        >

        <label>Senha</label>
        <input
            type="password"
            name="senha"
            minlength="6"
            required
        >

        <label>Confirmar senha</label>
        <input
            type="password"
            name="confirmar"
            minlength="6"
            required
        >

        <button type="submit">
            Cadastrar
        </button>

    </form>

    <a
        class="cadastro-link"
        href="login.php"
    >
        Já tenho uma conta
    </a>
</div>

</body>
</html>