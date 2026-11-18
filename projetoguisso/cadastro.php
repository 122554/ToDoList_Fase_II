
<?php
session_start();

// Se o usuário já estiver autenticado, redireciona para a página inicial.
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// Recupera possíveis mensagens de erro enviadas pelo auth.php.
$erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro | Minhas Tarefas</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://kit.fontawesome.com/c4c9e76409.js"
            crossorigin="anonymous"></script>

    <link rel="icon" type="image/png" href="assets/img/icone.png">
</head>

<body class="pagina-login">

    <!-- Cabeçalho -->
    <header class="cabecalho-login">
        <h1>Minhas Tarefas</h1>
        <p>Crie sua conta e organize sua rotina.</p>
    </header>

    <!-- Conteúdo principal -->
    <main class="container-login">

        <!-- Formulário de cadastro -->
        <form action="autenticar.php" method="POST" class="form-login">

            <!-- Identifica a operação solicitada -->
            <input type="hidden" name="acao" value="cadastrar">

            <!-- Ícone -->
            <div class="icone-login">
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <!-- Título -->
            <h2>Crie sua conta</h2>

            <p class="descricao-login">
                Preencha os campos abaixo para começar.
            </p>

            <!-- Mensagens de erro -->
            <?php if ($erro === 'email_existente'): ?>
                <div class="mensagem-erro">
                    Este e-mail já está cadastrado.
                </div>
            <?php elseif ($erro === 'senhas_diferentes'): ?>
                <div class="mensagem-erro">
                    As senhas informadas não coincidem.
                </div>
            <?php elseif ($erro === 'campos'): ?>
                <div class="mensagem-erro">
                    Preencha todos os campos corretamente.
                </div>
            <?php endif; ?>

            <!-- Nome -->
            <div class="campo-login">
                <label for="nome">Nome completo</label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Digite seu nome completo"
                    autocomplete="name"
                    maxlength="100"
                    required
                >
            </div>

            <!-- E-mail -->
            <div class="campo-login">
                <label for="email">E-mail</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Digite seu e-mail"
                    autocomplete="email"
                    maxlength="150"
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
                    placeholder="Crie uma senha"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <!-- Confirmação da senha -->
            <div class="campo-login">
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

            <!-- Botão de cadastro -->
            <button type="submit" class="btn-login">
                Criar conta
            </button>

            <!-- Link para login -->
            <p class="link-cadastro"><a href="login.php">
                Já possui uma conta?
                Entrar</a>
            </p>

        </form>

    </main>

    <!-- Rodapé -->
    <footer class="rodape">
        <p>Minhas Tarefas &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>
