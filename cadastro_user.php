<?php
/*
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
*/
?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Criando sua conta</title>
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

        <!--------------------------- Left Box ----------------------------->

        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
            <div class="featured-image mb-3">
                <img src="gatinho_comemora.png" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Cadastro mais simples</p>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Obrigado pela preferência!</small>
        </div> 

        <!-------------------- ------ Right Box ---------------------------->
            
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Seja Bem-Vindo!</h2>
                        <p>crie sua conta agora.</p>
                    </div>
                    <form id="userData" action="" method="post">
                        <div class="input-group mb-3">
                            <input for="nome" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="seu Nome aqui">
                        </div>
                        <div class="input-group mb-3">
                            <input for="email" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="seu Email aqui">
                        </div>
                        <div class="input-group mb-1">
                            <input for="senha" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="sua nova Senha">
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Pronto</button>
                        </div>
                    </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="validacoesCadastroUser.js"></script>
    </body>
</html>
