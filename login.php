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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
        <form action="" method="post">
            <label for="email">E-mail:</label>
            <input type="text" name="email"><br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha"><br><br>
            <button type="submit">Entrar</button>
        </form>
    <p>Ainda não possui uma conta?</p>
    <a href="cadastro_user.php">Cadastre-se!</a>

    
</body>
</html>
