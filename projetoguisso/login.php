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
    <meta name="color-scheme" content="light dark">

    <title>Entrar | Minhas Tarefas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap">

    <script src="assets/js/tema.js"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=2">

    <script src="https://kit.fontawesome.com/c4c9e76409.js" crossorigin="anonymous"></script>

    <link rel="icon" type="image/png" href="assets/img/icone.png">
</head>

<body class="pagina-auth">

    <div class="auth">

        <!-- Painel de apresentação -->
        <aside class="auth__painel">

            <a href="login.php" class="marca" aria-label="Minhas Tarefas">
                <span class="marca__icone"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                <span class="marca__nome">Minhas Tarefas</span>
            </a>

            <div class="auth__texto">
                <p class="auth__titulo">Organize sua rotina, uma tarefa por vez.</p>

                <p class="auth__subtitulo">
                    Crie, acompanhe e conclua suas tarefas em um só lugar,
                    com uma interface simples e rápida.
                </p>

                <ul class="auth__beneficios">
                    <li>
                        <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        Tarefas privadas: cada conta vê apenas as suas
                    </li>
                    <li>
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        Pesquisa e filtros para encontrar o que importa
                    </li>
                    <li>
                        <i class="fa-solid fa-moon" aria-hidden="true"></i>
                        Modo claro e escuro para trabalhar com conforto
                    </li>
                </ul>
            </div>

        </aside>

        <!-- Formulário -->
        <main class="auth__principal">

            <div class="auth__topo">
                <button
                    type="button"
                    class="btn-tema"
                    data-alternar-tema
                    aria-label="Alternar tema"
                    title="Alternar tema"
                >
                    <span class="icone-lua"><i class="fa-solid fa-moon" aria-hidden="true"></i></span>
                    <span class="icone-sol"><i class="fa-solid fa-sun" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="auth__formulario">

                <header>
                    <h1>Bem-vindo de volta</h1>
                    <p>Informe suas credenciais para acessar suas tarefas.</p>
                </header>

                <form action="autenticar.php" method="POST">
                    <input type="hidden" name="acao" value="login">

                    <?php if ($erro === 'credenciais'): ?>
                        <div class="auth-aviso" role="alert">
                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                            <span>E-mail ou senha incorretos.</span>
                        </div>
                    <?php endif; ?>

                    <div class="auth-campo">
                        <label for="email">E-mail</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="voce@exemplo.com"
                            autocomplete="email"
                            autofocus
                            required
                        >
                    </div>

                    <div class="auth-campo">
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

                    <button type="submit" class="auth-botao">Entrar</button>
                </form>

                <p class="auth__alternativa">
                    Ainda não possui uma conta?
                    <a href="cadastro.php">Cadastre-se</a>
                </p>

            </div>

            <p class="auth__rodape">Minhas Tarefas &copy; <?= date('Y') ?></p>

        </main>
    </div>

</body>
</html>
