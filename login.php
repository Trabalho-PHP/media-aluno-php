<?php
include("conexao_login.php");

if(isset($_POST["email"]) || isset($_POST["senha"])) {
    if(empty($_POST["email"])) {
        echo "Atenção: Insira seu E-mail!";
    }
    else if(empty($_POST["senha"])) {     //lembrar de adicionar excessão caso a senha inserida for numérica*
        echo "Atenção: Insira sua senha!";
    }
    else { //se email e senha estiverem corretos:

        $email = $mysqli->real_escape_string($_POST["email"]);
        $senha = $mysqli->real_escape_string($_POST["senha"]);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->connect_error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }
            
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["name"] = $usuario["nome"];

            header("Location: painel_acesso.php");

        }
        else {
            echo "Falha ao logar! E-mail ou senha incorretos.";
        }
    }
    if (isset($_GET['redirect']) && $_GET['redirect'] == 'cadastro_user') {
        header("Location: cadastro_user.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!-----login container----->

    <div class="row border rounded-5 p-3 bg-white shadow box-area">

    <!-----left box----->

    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
        <div class="featured-image mb-3">
            <img src="gatinho-removebg-preview.png" class="img-fluid" style="width: 250px;">
        </div>
        <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Venha estudar conosco!</p>
        <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Cadastro de alunos com eficiência.</small>
    </div>

    <!-----right box----->

    <div class="col-md-6 right-box">
        <div class="row aign-items-center">
        <div class="header-text mb-4">
        <h2>Olá, User!</h2>
        <p>É bom te ver novamente.</p>
    </div>
    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email">
        </div>
        <div class="input-group mb-1">
            <input type="password" name="senha" class="form-control form-control-lg bg-light fs-6" placeholder="Senha">
        </div>
        <div class="input-group mb-5 d-flex jutify-content- between">
            <div class="from-check">
                <input type="checkbox" class="form-check-input" id="formCheck">
                <label for="formCheck" class="form-check-label text-secondary"><small>Lembre de mim</small></label>
            </div>
        </div>
        <div class="input-group mb-3">
            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Entrar</button>
        </div>
        <div class="row">
            <small>Não tem uma conta? <a href="cadastro_user.php">Cadastre-se!</a></small>
        </div>
    </form>
    </div>
    </div>
    </div>

    
</body>
</html>
