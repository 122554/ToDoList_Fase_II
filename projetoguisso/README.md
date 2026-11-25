Minhas Tarefas

Prezado Professor Luis Antonio Guisso Lopes,

Seguem as instruções para configurar e executar o projeto.

Lista de tarefas em PHP e MySQL com cadastro e login de usuários.

Requisitos

- PHP 7.4 ou superior
- MySQL ou MariaDB
- Servidor local, como o XAMPP

Configuração

1. Copie o projeto para a pasta `htdocs` do XAMPP.
2. Inicie o Apache e o MySQL.
3. No phpMyAdmin, crie um banco de dados chamado `webdev`.
4. Confira os dados de acesso em `conexao.php`:

php
   $mysql = 'mysql:host=localhost;dbname=webdev';
   $user = 'root';
   $pwd = '';

5. Acesse `http://localhost/nome-da-pasta/` no navegador.

Se o MySQL utilizado tiver senha para o usuário `root` ou outro nome de banco, altere os valores correspondentes em `conexao.php`.

As tabelas `usuario` e `tarefa` são criadas automaticamente no primeiro cadastro e na primeira tarefa, não sendo necessário importar nenhum script SQL.

Primeiro acesso

1. Na tela de login, clique em **Cadastre-se** e crie uma conta.
2. Após o cadastro, o acesso à lista de tarefas é liberado automaticamente.

Hospedagem

1. Envie o conteúdo do projeto (sem a pasta raiz) para a pasta pública do servidor.
2. Crie um banco de dados no painel da hospedagem.
3. Atualize `conexao.php` com o host, o nome do banco, o usuário e a senha da hospedagem.