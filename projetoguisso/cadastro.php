<?php
session_start();

// Se o usuário já estiver autenticado, redireciona para a página inicial.
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// Recupera possíveis mensagens de erro enviadas pelo autenticar.php.
$erro = $_GET['erro'] ?? '';

$mensagensErro = [
    'email_existente'   => 'Este e-mail já está cadastrado.',
    'senhas_diferentes' => 'As senhas informadas não coincidem.',
    'campos'            => 'Preencha todos os campos corretamente.',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">

    <title>Criar conta | Minhas Tarefas</title>

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
                    <h1>Crie sua conta</h1>
                    <p>Preencha os campos abaixo para começar.</p>
                </header>

                <form action="autenticar.php" method="POST">

                    <!-- Identifica a operação solicitada -->
                    <input type="hidden" name="acao" value="cadastrar">

                    <?php if (isset($mensagensErro[$erro])): ?>
                        <div class="auth-aviso" role="alert">
                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                            <span><?= htmlspecialchars($mensagensErro[$erro], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="auth-campo">
                        <label for="nome">Nome completo</label>
                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite seu nome completo"
                            autocomplete="name"
                            maxlength="100"
                            autofocus
                            required
                        >
                    </div>

                    <div class="auth-campo">
                        <label for="email">E-mail</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="voce@exemplo.com"
                            autocomplete="email"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="auth-campo">
                        <label for="senha">Senha</label>
                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Crie uma senha"
                            autocomplete="new-password"
                            minlength="8"
                            aria-describedby="dica-senha"
                            required
                        >
                        <p class="auth-campo__dica" id="dica-senha">Use pelo menos 8 caracteres.</p>
                    </div>

                    <div class="auth-campo">
                        <label for="confirmar_senha">Confirmar senha</label>
                        <input
                            type="password"
                            id="confirmar_senha"
                            name="confirmar_senha"
                            placeholder="Digite novamente sua senha"
                            autocomplete="new-password"
                            minlength="8"
                            required
                        >
                    </div>

                    <button type="submit" class="auth-botao">Criar conta</button>
                </form>

                <p class="auth__alternativa">
                    Já possui uma conta?
                    <a href="login.php">Entrar</a>
                </p>

            </div>

            <p class="auth__rodape">Minhas Tarefas &copy; <?= date('Y') ?></p>

        </main>
    </div>

</body>
</html>
