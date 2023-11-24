<?php
include 'conexao_login.php';
session_start();

if (isset($_POST["nomeAluno"]) && isset($_POST["matricula"]) && isset($_POST["nota1"]) && isset($_POST["nota2"])) {
    $nomeAluno = $mysqli->real_escape_string($_POST["nomeAluno"]);
    $matricula = $mysqli->real_escape_string($_POST["matricula"]);
    $nota1 = $mysqli->real_escape_string($_POST["nota1"]);
    $nota2 = $mysqli->real_escape_string($_POST["nota2"]);

    if (is_null($nomeAluno) || is_null($matricula) || is_null($nota1) || is_null($nota2)) {
        echo "Todos os campos devem ser preenchidos.";
    } else {

        try {
            // Evitar injeção de SQL usando prepared statement
            $stmt = $mysqli->prepare("INSERT INTO alunos (nome, matricula, nota1, nota2) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdd", $nomeAluno, $matricula, $nota1, $nota2);
            $stmt->execute();

            echo "<p class='alert alert-success mt-3 d-flex justify-content-center align-items-center' role='alert'>Usuário cadastrado com sucesso!</p>";
        } catch (Exception $e) {
            echo "<p class='alert alert-danger mt-3 d-flex justify-content-center align-items-center' role='alert'>Erro ao cadastrar o usuário: " . $e->getMessage() . "</p>";
        }
    }
}

?>

<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilo_tabela.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Cadastro de Aluno</title>
    </head>
    <body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!----container----->
    <div class="row border rounded-5 p-3 my-4 bg-white shadow box-area">

        <h1>Bem vindo, <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Usuário"; ?></h1> <!-- parte bonitinha de boas vindas no topo -->
        <h3>Cadastro de Aluno</h3>
        <div class="row align-items-center">
        <form id="cadastroaluno" method="post" novalidate>
            <div class="input-group mb-2">
                <input type="text" name="nomeAluno" id="nome" class="form-control form-control-lg bg-light fs-6" placeholder="Nome do aluno" required>
            </div>
            <div class="input-group mb-2">
                <input type="text" name="matricula" id="matricula" class="form-control form-control-lg bg-light fs-6" placeholder="Matrícula do aluno" required>
            </div>
            <div class="input-group mb-2">
                <input type="number" name="nota1" step="0.1" id="nota1" class="form-control form-control-lg bg-light fs-6" placeholder="Primeira nota" required>
            </div>
            <div class="input-group mb-2">
                <input type="number" name="nota2" step="0.1" id="nota2" class="form-control form-control-lg bg-light fs-6" placeholder="Segunda nota" required>
            </div>
            <br>
            <div class="input-group mb-2">
                <button class="btn btn-sm btn-primary btn-block fs-6" type="submit">Cadastrar</button>
            </div>
        </form>
        </div>

    <?php
    $sql = "SELECT * FROM alunos ";
    $todos = mysqli_query($mysqli, $sql);
    ?>
        <h1>Tabela de alunos cadastrados</h1>
                                            <!-- será gerada com JS -->
        <h3>Buscar aluno</h3>
        <form action="" method="post" id="busca">
            <div class="input-group mb-2">
                <input type="text" name="nome" id="nome" class="form-control form-control-lg bg-light fs-6" placeholder="Nome do aluno" required>
            </div>
            <div class="input-group mb-3">
                <button class="btn btn-sm btn-primary btn-block fs-6" type="submit">Pesquisar</button>
            </div>
        </form>
        <?php
                //   busca de aluno (teste)
                if(isset($_POST["nome"])) {
                    if(empty($_POST["nome"])) {
                        echo "Atenção: Insira o nome do aluno que deseja buscar!";
                    } else { 
                        $nomeAluno = $mysqli->real_escape_string($_POST["nome"]);
                        $sql_code = "SELECT * FROM alunos WHERE nome = '$nomeAluno'";
                        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->connect_error);
                        $quantidade = $sql_query->num_rows;

                        if ($quantidade > 0) {
                            // Exibe as informações do aluno
                            while ($row = $sql_query->fetch_assoc()) {
                                echo "Nome: " . $row["nome"] . "<br>";
                                echo "Matrícula: " . $row["matricula"] . "<br>";
                                echo "Nota 1: " . $row["nota1"] . "<br>";
                                echo "Nota 2: " . $row["nota2"] . "<br>";
                            }
                        } else {
                            echo "Nenhum aluno encontrado";
                        }
                    }
                }
        ?><br>
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
                    <?php while ($dados=mysqli_fetch_array($todos)) {?>
                    <tr>
                        <td scope="row"><?=$dados['nome'];?></td>
                        <td><?= $dados['matricula'];?></td>
                        <td><?= $dados['nota1'];?></td>
                        <td><?=$dados['nota2'];?></td>
                    </tr>

                    <?php } ?>
            </tbody>
        </table>
    </div>
    </body>
    </html>