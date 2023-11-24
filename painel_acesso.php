<?php

    session_start();
    include 'conexao_login.php';
    if(isset($_POST["nome"]) && isset($_POST["matricula"]) && isset($_POST["nota1"]) && isset($_POST["nota2"])) {
        $nome = $mysqli->real_escape_string($_POST["nome"]);
        $matricula = $mysqli->real_escape_string($_POST["matricula"]);
        $nota1 = $mysqli->real_escape_string($_POST["nota1"]);
        $nota2 = $mysqli->real_escape_string($_POST["nota2"]);

        // Evitar injeção de SQL usando prepared statement
        $stmt = $mysqli->prepare("INSERT INTO alunos (nome, matricula, nota1, nota2) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sddd", $nome, $matricula, $nota1, $nota2);

                    
        if ($stmt->error) {
            echo "Erro ao cadastrar aluno: " . $stmt->error;
        }
        
                        
        $stmt->close();
    }else{
        echo "Preencha todos os campos.";
    }
    

    //busca de aluno (teste)
    $conn = new mysqli("localhost", "root", "", "login");
    if(isset($_POST["nome"])) {
        if(empty($_POST["nome"])) {
            echo "Atenção: Insira o nome do aluno que deseja buscar!";
        }
    }else { 

        $nome = $mysqli->real_escape_string($_POST["nome"]);
        $sql_code = "SELECT * FROM alunos WHERE nome = '$nome'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->connect_error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade > 0) {
            // Exibe as informações do aluno
            while ($row = $result->fetch_assoc()) {
                echo "Nome: " . $row["nome"] . "<br>";
                echo "Matrícula: " . $row["matricula"] . "<br>";
                echo "nota 1: " . $row["nota1"] . "<br>";
                echo "nota 2: " . $row["nota2"] . "<br>";

            }
        }else{
            echo "nenhum aluno encontrado";

        }
    }
    $mysqli->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">          
    <link rel="stylesheet" href="estilo_tabela.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Área de acesso</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

    <div class="row border rounded-5 p-3 bg-white shadow box-area">

        <h1>Bem vindo, <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Usuário"; ?></h1> <!-- parte bonitinha de boas vindas no topo -->
        <h3>Cadastro de Aluno</h3>
        <div class="row align-items-center">
            <form id="cadastroaluno" action="" method="post">
                <div class="input-group mb-2">
                    <input for="nome" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nome do aluno" required>
                </div>
                <div class="input-group mb-2">
                    <input for="matricula" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="matrícula do aluno" required>
                </div>
                <div class="input-group mb-2">
                    <input for="nota1" type="number" step="0.1" class="form-control form-control-lg bg-light fs-6" placeholder="primeira nota" required>
                </div>
                <div class="input-group mb-2">
                    <input for="nota2" type="number" step="0.1" class="form-control form-control-lg bg-light fs-6" placeholder="segunda nota" required>
                </div>
                <br>
                <div class="input-group mb-2">
                    <button class="btn btn-sm btn-primary btn-block fs-6" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    

        <h1>tabela de alunos cadastrados</h1> <!-- será gerada com JS -->
        <h3>Buscar aluno</h3>
        <form action="" method="post" id="busca">
            <div class="input-group mb-2">
                <input for="nome" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Nome" required>
            </div>
            <div class="input-group mb-3">
                <button class="btn btn-sm btn-primary btn-block fs-6" type="submit">Pesquisar</button>
            </div>
        </form>
        <table id="Alunos">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                </tr>
            </thead>
            <tbody>
                    <!-- As linhas da tabela serão adicionadas aqui dinamicamente com JavaScript -->
            </tbody>
        </table>
    </div>
        <script>
            document.getElementById("cadastroaluno").addEventListener("submit", function(event) {
                event.preventDefault(); 
                // Exemplo: Adicionando uma linha à tabela com dados do formulário
                var nome = document.querySelector("input[name='nome']").value;
                var matricula = document.querySelector("input[name='matricula']").value;
                var nota1 = document.querySelector("input[name='nota1']").value;
                var nota2 = document.querySelector("input[name='nota2']").value;

                var tabela = document.getElementById("Alunos");
                var linha = tabela.insertRow();
                var colunaNome = linha.insertCell(0);
                var colunaMatricula = linha.insertCell(1);
                var colunaNota1 = linha.insertCell(2);
                var colunaNota2 = linha.insertCell(3);

                colunaNome.innerHTML = nome;
                colunaMatricula.innerHTML = matricula;
                colunaNota1.innerHTML = nota1;
                colunaNota2.innerHTML = nota2;
            });
        </script>
    </body>
</html>