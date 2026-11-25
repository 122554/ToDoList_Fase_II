
<?php

session_start();

require_once __DIR__ . '/conexao.php';

// Impede acesso direto sem envio de formulário.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Identifica a operação solicitada.
$acao = $_POST['acao'] ?? '';

if ($acao === 'cadastrar') {

    // Recupera os dados enviados pelo formulário.
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    // Verifica se todos os campos foram preenchidos.
    if (
        $nome === '' ||
        $email === '' ||
        $senha === '' ||
        $confirmarSenha === ''
    ) {
        header('Location: cadastro.php?erro=campos');
        exit;
    }

    // Valida o formato do e-mail.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: cadastro.php?erro=campos');
        exit;
    }

    // Verifica se as senhas coincidem.
    if ($senha !== $confirmarSenha) {
        header('Location: cadastro.php?erro=senhas_diferentes');
        exit;
    }

    // Verifica o tamanho mínimo da senha.
    if (strlen($senha) < 8) {
        header('Location: cadastro.php?erro=campos');
        exit;
    }

    // Verifica se o e-mail já está cadastrado.
    $usuarioExistente = R::findOne(
        'usuario',
        'email = ?',
        [$email]
    );

    if ($usuarioExistente) {
        header('Location: cadastro.php?erro=email_existente');
        exit;
    }

    // Cria um novo registro de usuário.
    $usuario = R::dispense('usuario');

    $usuario->nome = $nome;
    $usuario->email = $email;

    // Criptografa a senha antes de armazená-la.
    $usuario->senha = password_hash(
        $senha,
        PASSWORD_DEFAULT
    );

    // Salva o usuário no banco de dados.
    $idUsuario = R::store($usuario);

    // Inicia a sessão do usuário cadastrado.
    session_regenerate_id(true);

    $_SESSION['usuario_id'] = $idUsuario;
    $_SESSION['usuario_nome'] = $nome;

    header('Location: index.php');
    exit;
}


if ($acao === 'login') {

    // Recupera os dados enviados pelo formulário.
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Verifica se os campos foram preenchidos.
    if ($email === '' || $senha === '') {
        header('Location: login.php?erro=credenciais');
        exit;
    }

    // Busca o usuário pelo e-mail.
    $usuario = R::findOne(
        'usuario',
        'email = ?',
        [$email]
    );

    // Verifica se o usuário existe e se a senha está correta.
    if (
        !$usuario ||
        !password_verify($senha, $usuario->senha)
    ) {
        header('Location: login.php?erro=credenciais');
        exit;
    }

    // Regenera o identificador da sessão.
    session_regenerate_id(true);

    // Armazena os dados necessários na sessão.
    $_SESSION['usuario_id'] = $usuario->id;
    $_SESSION['usuario_nome'] = $usuario->nome;

    header('Location: index.php');
    exit;
}

// Caso a operação seja desconhecida.
header('Location: login.php');
exit;
