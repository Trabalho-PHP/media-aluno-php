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
    <title>Área de acesso</title>
</head>
<body>
    <h3>Bem vindo, <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Usuário"; ?></h3> <!-- parte bonitinha de boas vindas no topo -->
    <h1>Cadastro de Aluno</h1>
        <form action="" method="post" id="cadastroaluno">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required><br><br>
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" id="matricula" required><br><br>
            <label for="nota1">Nota 1:</label>
            <input type="number" name="nota1" step="0.1" id="nota1" required><br><br>
            <label for="nota2">Nota 2:</label>
            <input type="number" name="nota2" step="0.1" id="nota2" required><br><br>
            <button type="submit">Cadastrar</button>
        </form>
        <h1>Tabela de alunos cadastrados</h1> <!-- será gerada com JS -->
        <h3>Buscar aluno</h3>
        <form action="" method="post" id="busca">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="nome do aluno" required><br><br>
            <button type="submit">Pesquisar</button>
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
        <script>
            document.getElementById("cadastroaluno").addEventListener("submit", function(event) {
                event.preventDefault(); 
                // Exemplo: Adicionando uma linha à tabela com dados do formulário
                const nome = document.getElementById("nome").value;
                const matricula = document.getElementById("matricula").value;
                const nota1 = parseFloat(document.getElementById("nota1").value);
                const nota2 = parseFloat(document.getElementById("nota2").value);

                const tabela = document.getElementById("Alunos");
                const linha = tabela.insertRow();
                const colunaNome = linha.insertCell(0);
                const colunaMatricula = linha.insertCell(1);
                const colunaNota1 = linha.insertCell(2);
                const colunaNota2 = linha.insertCell(3);

                colunaNome.innerHTML = nome;
                colunaMatricula.innerHTML = matricula;
                colunaNota1.innerHTML = nota1;
                colunaNota2.innerHTML = nota2;

                document.getElementById('nome').value = '';
                document.getElementById('matricula').value = '';
                document.getElementById('nota1').value = '';
                document.getElementById('nota2').value = '';
            });
        </script>
    </body>
</html>