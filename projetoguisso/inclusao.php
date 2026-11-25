<?php
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/protecao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');

    // Criaçao da Tabela
    if ($nome !== '') {
        $tarefa = R::dispense('tarefa');

        // Dados da Tarefa
        $tarefa->nome = $nome;
        $tarefa->concluida = 0;
        $tarefa->usuario_id = (int) $_SESSION['usuario_id'];
        // Armazenar no banco de dados
        R::store($tarefa);

        // Voltar para index.php
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa</title>
    <script src="assets/js/tema.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/c4c9e76409.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="assets/img/icone.png">
</head>
<body>

    <header class="cabecalho">

        <div class="acoes-cabecalho">
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

        <h1>Nova Tarefa</h1>
        <p>Adicione uma tarefa à sua rotina.</p>
    </header>

    <main class="container">

        <section class="form-inclusao">

            <h2>O que você precisa fazer?</h2>

            <form action="inclusao.php" method="post">

                <label for="nome">Nome da tarefa</label>

                <input
                    type="text"
                    name="nome"
                    id="nome"
                    placeholder="Ex.: Estudar PHP"
                    maxlength="255"
                    value="<?= htmlspecialchars($_POST['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required 
                >

                <button type="submit" class="btn-salvar-tarefa">
                    Salvar tarefa
                </button>

            </form>

            <a href="index.php">Voltar para minhas tarefas</a>

        </section>

    </main>

    <footer class="rodape">
        <p>Minhas Tarefas &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>
