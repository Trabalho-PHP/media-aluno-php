
<?php
    include 'conexao_login.php';
    session_start();
    
    if(!isset($_POST["nome"]) && !isset($_POST["matricula"]) && !isset($_POST["nota1"]) && !isset($_POST["nota2"])) {

        if(empty($nome) || empty($matricula) || empty($nota1) || empty($nota2)) {
            echo "Todos os campos devem ser preenchidos.";
        }else{
            $nome = $mysqli->real_escape_string($_POST["nome"]);
            $matricula = $mysqli->real_escape_string($_POST["matricula"]);
            $nota1 = $mysqli->real_escape_string($_POST["nota1"]);
            $nota2 = $mysqli->real_escape_string($_POST["nota2"]);

            // Evitar injeção de SQL usando prepared statement
            $stmt = $mysqli->prepare("INSERT INTO alunos (nome, matricula, nota1, nota2) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sddd", $nome, $matricula, $nota1, $nota2);
            
            // Executar a declaração
            if ($stmt->execute()) {
                echo "Aluno cadastrado com sucesso!";
                exit();
            } else {
                echo "Erro ao cadastrar aluno: " . $mysqli->error;
            }
                        
            $stmt->close();
        }
    }else{
        echo "<br><br> é isso, deu merda";
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
            <label for="nome">Nome:</label>
            <input type="text" name="nome"><br><br>
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula"><br><br>
            <label for="nota1">Nota 1:</label>
            <input type="number" name="nota1" step="0.1"><br><br>
            <label for="nota2">Nota 2:</label>
            <input type="number" name="nota2" step="0.1"><br><br>
            <button type="submit">Cadastrar</button>
        </form>
        <h1>tabela de alunos cadastrados</h1> <!-- será gerada com JS -->

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

