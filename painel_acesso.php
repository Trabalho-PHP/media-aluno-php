<?php
    include 'conexao_login.php';
    session_start();
    echo"alo";
    
    if(isset($_POST["nomeAluno"]) && isset($_POST["matricula"]) && isset($_POST["nota1"]) && isset($_POST["nota2"])) {
        echo "coisa";
        $nomeAluno = $mysqli->real_escape_string($_POST["nomeAluno"]);
        $matricula = $mysqli->real_escape_string($_POST["matricula"]);
        $nota1 = $mysqli->real_escape_string($_POST["nota1"]);
        $nota2 = $mysqli->real_escape_string($_POST["nota2"]);

        if(empty($nomeAluno) || empty($matricula) || empty($nota1) || empty($nota2)) {
            echo "Todos os campos devem ser preenchidos.";
        }else{
            echo"deu merda 2";
            // Evitar injeção de SQL usando prepared statement
            $stmt = $mysqli->prepare("INSERT INTO alunos (nome, matricula, nota1, nota2) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sddd", $nomeAluno, $matricula, $nota1, $nota2);
            
            // Executar a declaração
            if ($stmt->execute()) {
                echo "Aluno cadastrado com sucesso!";
                exit();
            } else {
                echo "Erro ao cadastrar aluno: " . $mysqli->error;
            }
                        
            $stmt->close();
        }
        echo"Deu n";
    }else{
        echo "<br><br> é isso, deu merda memo";
    }
    

//    busca de aluno (teste)
    $conn = new mysqli("localhost", "root", "", "login");
    if(isset($_POST["nomeAluno"])) {
        if(empty($_POST["nomeAluno"])) {
            echo "Atenção: Insira o nome do aluno que deseja buscar!";
        }
    }else { 
        $nomeAluno = $mysqli->real_escape_string($_POST["nomeAluno"]);
        $sql_code = "SELECT * FROM alunos WHERE nome = '$nomeAluno'";
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilo_tabela.css">
        <title>Cadastro de Aluno</title>
        </head>
        <body>
            <h3>Bem vindo, <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Usuário"; ?></h3> <!-- parte bonitinha de boas vindas no topo -->
            <h1>Cadastro de Aluno</h1>
            <form action="" method="post" id="cadastroaluno">
                <label for="nomeAluno">Nome:</label>
                <input type="text" name="nomeAluno" id="nome"><br><br>
                <label for="matricula">Matrícula:</label>
                <input type="text" name="matricula" id="matricula"><br><br>
                <label for="nota1">Nota 1:</label>
                <input type="number" name="nota1" step="0.1" id="nota1"><br><br>
                <label for="nota2">Nota 2:</label>
                <input type="number" name="nota2" step="0.1" id="nota2"><br><br>
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
