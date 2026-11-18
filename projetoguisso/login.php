
<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Minhas Tarefas</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://kit.fontawesome.com/c4c9e76409.js"
            crossorigin="anonymous"></script>

    <link rel="icon" type="image/png" href="assets/img/icone.png">
</head>

<body class="pagina-login">

    <!-- Cabeçalho -->
    <header class="cabecalho-login">
        <h1>Minhas Tarefas</h1>
        <p>Acesse sua conta para organizar sua rotina.</p>
    </header>

    <!-- Conteúdo principal -->
    <main class="container-login">

        <!-- Formulário de autenticação -->
        <form action="autenticar.php" method="POST" class="form-login">
        <input type="hidden" name="acao" value="login">
            <!-- Ícone -->
            <div class="icone-login">
                <i class="fa-regular fa-user"></i>
            </div>

            <!-- Título -->
            <h2>Acesse sua conta</h2>

            <p class="descricao-login">
                Informe suas credenciais para continuar.
            </p>

            <!-- Mensagem de erro -->
            <?php if ($erro === 'credenciais'): ?>
                <div class="mensagem-erro">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    E-mail ou senha incorretos.
                </div>
            <?php endif; ?>

            <!-- E-mail -->
            <div class="campo-login">

                <label for="email">E-mail</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Digite seu e-mail"
                    autocomplete="email"
                    required
                >

            </div>

            <!-- Senha -->
            <div class="campo-login">

                <label for="senha">Senha</label>

                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Digite sua senha"
                    autocomplete="current-password"
                    required
                >

            </div>

            <!-- Botão de login -->
            <button type="submit" class="btn-login">
                Entrar
            </button>

            <!-- Link para cadastro -->
            <p class="link-cadastro">  <a href="cadastro.php">
                Ainda não possui uma conta?
                Cadastre-se</a>
            </p>

        </form>

    </main>

    <!-- Rodapé -->
    <footer class="rodape">
        <p>Minhas Tarefas &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>
