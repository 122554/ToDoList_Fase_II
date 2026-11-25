<?php
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/protecao.php';
$usuarioId = (int) $_SESSION['usuario_id'];


/* Atualizar status da tarefa */
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_status'])
) {
    $id = (int) ($_POST['id'] ?? 0);

    // Busca somente uma tarefa pertencente ao usuário conectado.
    $tarefa = R::findOne(
        'tarefa',
        'id = ? AND usuario_id = ?',
        [$id, $usuarioId]
    );

    if ($tarefa) {
        $tarefa->concluida = isset($_POST['concluida']) ? 1 : 0;
        R::store($tarefa);
    }

    header('Location: index.php');
    exit;
}

/* Pesquisa e filtro */
$pesquisa = trim($_GET['pesquisa'] ?? '');
$filtro = $_GET['filtro'] ?? 'todas';

if (!in_array($filtro, ['todas', 'pendentes', 'concluidas'], true)) {
    $filtro = 'todas';
}

// $sql = "nome IS NOT NULL AND TRIM(nome) <> ''";
// $valores = [];

$sql = "usuario_id = ? AND nome IS NOT NULL AND TRIM(nome) <> ''";
$valores = [$usuarioId];

if ($pesquisa !== '') {
    $sql .= " AND nome LIKE ?";
    $valores[] = '%' . $pesquisa . '%';
}

if ($filtro === 'pendentes') {
    $sql .= " AND concluida = 0";
} elseif ($filtro === 'concluidas') {
    $sql .= " AND concluida = 1";
}

$tarefas = R::find('tarefa', $sql . ' ORDER BY id DESC', $valores);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
    <script src="assets/js/tema.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/c4c9e76409.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="assets/img/icone.png">
</head>
<body>

    <header class="cabecalho">
    <p class="mensagem-boas-vindas">
        Olá, <?= htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8') ?>!
    </p>
        <h1>Minhas Tarefas</h1>
        <p>Organize sua rotina, uma tarefa por vez.</p>


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

        <form action="logout.php" method="POST">
            <button type="submit" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sair
            </button>
        </form>

    </div>

    </header>

    <main class="container">

        <section class="controles">

            <form action="index.php" method="get" class="pesquisa">
                <input
                    type="text"
                    name="pesquisa"
                    placeholder="Pesquisar tarefa..."
                    value="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>"
                >

                <input
                    type="hidden"
                    name="filtro"
                    value="<?= htmlspecialchars($filtro, ENT_QUOTES, 'UTF-8') ?>"
                >

                <button type="submit">Pesquisar</button>
            </form>

            <a href="inclusao.php" class="btn-adicionar" aria-label="Adicionar tarefa">+</a>

        </section>

        <nav class="filtros">
            <a href="index.php?filtro=todas&amp;pesquisa=<?= urlencode($pesquisa) ?>"
               class="<?= $filtro === 'todas' ? 'ativo' : '' ?>">
                Todas
            </a>

            <a href="index.php?filtro=pendentes&amp;pesquisa=<?= urlencode($pesquisa) ?>"
               class="<?= $filtro === 'pendentes' ? 'ativo' : '' ?>">
                Pendentes
            </a>

            <a href="index.php?filtro=concluidas&amp;pesquisa=<?= urlencode($pesquisa) ?>"
               class="<?= $filtro === 'concluidas' ? 'ativo' : '' ?>">
                Concluídas
            </a>
        </nav>

        <section class="lista-tarefas">

            <?php if (count($tarefas) > 0): ?>

                <?php foreach ($tarefas as $tarefa): ?>

                    <article class="tarefa <?= $tarefa->concluida ? 'concluida' : '' ?>">

                        <form action="index.php" method="post" class="form-tarefa">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $tarefa->id ?>"
                            >

                            <label class="tarefa-conteudo">
                                <input
                                    type="checkbox"
                                    name="concluida"
                                    value="1"
                                    <?= $tarefa->concluida ? 'checked' : '' ?>
                                >

                                <span>
                                    <?= htmlspecialchars($tarefa->nome, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </label>

                            <button
                                type="submit"
                                name="atualizar_status"
                                value="1"
                                class="btn-status"
                                aria-label="Atualizar status da tarefa"
                                title="Atualizar status"
                            >
                                <i class="fa-solid fa-pencil"></i>
                            </button>

                        </form>

                        <a
                            href="exclusao.php?id=<?= (int) $tarefa->id ?>"
                            class="btn-excluir"
                            aria-label="Excluir tarefa"
                            title="Excluir tarefa"
                        >
                            <i class="fa-solid fa-trash-can"></i>
                        </a>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="lista-vazia">
                    <h2>Nenhuma tarefa encontrada</h2>
                    <p>Adicione uma nova tarefa ou altere sua pesquisa.</p>

                    <!-- <a href="inclusao.php" class="btn-adicionar" aria-label="Adicionar tarefa">+</a> -->
                </div>

            <?php endif; ?>

        </section>

    </main>

    <footer class="rodape">
        <p>Minhas Tarefas &copy; <?= date('Y') ?></p>
    </footer>

</body>
</html>
