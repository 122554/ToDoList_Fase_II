<?php
require_once __DIR__ . '/protecao.php';
require_once __DIR__ . '/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header('Location: index.php');
    exit;
}

$usuarioId = (int) $_SESSION['usuario_id'];

/* Busca a tarefa pertencente ao usuário autenticado */
$tarefa = R::findOne(
    'tarefa',
    'id = ? AND usuario_id = ?',
    [$id, $usuarioId]
);

/* Verifica se a tarefa existe e possui nome válido */
if (!$tarefa || !$tarefa->id || trim((string) $tarefa->nome) === '') {
    header('Location: index.php');
    exit;
}

/* Exclui a tarefa somente após a confirmação */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_exclusao'])) {
    R::trash($tarefa);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar exclusão</title>
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

        <h1>Excluir tarefa</h1>
        <p>Confirme se deseja remover esta tarefa.</p>
    </header>

    <main class="container">

        <section class="confirmacao-exclusao">

            <div class="icone-alerta">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <h2>Tem certeza?</h2>

            <p>
                Você está prestes a excluir a tarefa:
            </p>

            <p class="nome-tarefa-exclusao">
                <?= htmlspecialchars($tarefa->nome, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <p class="aviso-exclusao">
                Essa ação não poderá ser desfeita.
            </p>

            <div class="acoes-exclusao">

                <a href="index.php" class="btn-cancelar">
                    Cancelar
                </a>

                <form action="exclusao.php?id=<?= (int) $tarefa->id ?>" method="post">
                    <button
                        type="submit"
                        name="confirmar_exclusao"
                        value="1"
                        class="btn-confirmar-exclusao"
                    >
                        <i class="fa-solid fa-trash-can"></i>
                        Excluir tarefa
                    </button>
                </form>

            </div>

        </section>

    </main>

    <footer class="rodape">
        <p>Minhas Tarefas &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>
