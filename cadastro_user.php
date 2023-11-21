<?php
include 'conexao_login.php';
session_start();

if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
    $nome = $mysqli->real_escape_string($_POST["nome"]);
    $email = $mysqli->real_escape_string($_POST["email"]);
    $senha = $mysqli->real_escape_string($_POST["senha"]);

    if(empty($nome) || empty($email) || empty($senha)) {
        echo "Todos os campos devem ser preenchidos.";
    }else{
        // Evitar injeção de SQL usando prepared statement
        $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            // Configurar uma variável de sessão para indicar que o usuário está logado
            $_SESSION['usuario_logado'] = true;
            $_SESSION['nome_usuario'] = $nome;
        
            echo "Cadastro realizado com sucesso. Usuário logado.";
            header('Location: login.php');
            exit();
        } else {
            echo "Erro ao cadastrar usuário: " . $mysqli->error;
        }
        
        $stmt->close();
    }
}

$mysqli->close();

?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Criando sua conta</title>
    </head>
        <body>
            <h1>Cadastro de novo usuário</h1>
            <form id="userData" action="" method="post">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" placeholder="Seu nome aqui"><br><br>
                <label for="email" >E-mail:</label>
                <input type="text" name="email" placeholder="seu E-mail aqui"><br><br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" placeholder="crie uma nova senha"><br><br>
                <button type="submit">criar conta</button>
            </form>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="validacoesCadastroUser.js"></script>
    </body>
    </html>
