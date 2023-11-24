<?php
    include 'conexao_login.php';
    session_start();
    
    if(isset($_POST["nomeAluno"]) && isset($_POST["matricula"]) && isset($_POST["nota1"]) && isset($_POST["nota2"])) {
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
            $stmt->bind_param("ssss", $nomeAluno, $matricula, $nota1, $nota2);
            
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
    

//  //    busca de aluno (teste)
    // $conn = new mysqli("localhost", "root", "", "login");
    // if(isset($_POST["nomeAluno"])) {
    //     if(empty($_POST["nomeAluno"])) {
    //         echo "Atenção: Insira o nome do aluno que deseja buscar!";
    //     }
    // }else { 
    //     $nomeAluno = $mysqli->real_escape_string($_POST["nomeAluno"]);
    //     $sql_code = "SELECT * FROM alunos WHERE nome = '$nomeAluno'";
    //     $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->connect_error);
    //     $quantidade = $sql_query->num_rows;

    //     if ($quantidade > 0) {
    //         // Exibe as informações do aluno
    //         while ($row = $result->fetch_assoc()) {
    //             echo "Nome: " . $row["nome"] . "<br>";
    //             echo "Matrícula: " . $row["matricula"] . "<br>";
    //             echo "nota 1: " . $row["nota1"] . "<br>";
    //             echo "nota 2: " . $row["nota2"] . "<br>";

    //         }
    //     }else{
    //         echo "nenhum aluno encontrado";

    //     }
    // }
    $mysqli->close();

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
    
    <!-----login container----->

    <div class="row border rounded-5 p-3 bg-white shadow box-area">

        <h1>Bem vindo, <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Usuário"; ?></h1> <!-- parte bonitinha de boas vindas no topo -->
        <h3>Cadastro de Aluno</h3>
        <div class="row align-items-center">
        <form id="cadastroaluno" action="" method="post">
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

        <h1>Tabela de alunos cadastrados</h1> <!-- será gerada com JS -->
        <h3>Buscar aluno</h3>
        <form action="" method="post" id="busca">
            <div class="input-group mb-2">
                <input type="text" name="nome" id="nome" class="form-control form-control-lg bg-light fs-6" placeholder="Nome do aluno" required>
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
            // event.preventDefault(); 
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

            //document.getElementById('nome').value = '';
            //document.getElementById('matricula').value = '';
           // document.getElementById('nota1').value = '';
            //document.getElementById('nota2').value = '';
        


            //AQUI COMEÇA O CODIGO QUE VI SOBRE FILTRAGEM MAS ENTENDI NADA E DEIXEI SO O EXEMPLO QUE ELE FEZ LA
           // const cadastro_aluno = document.getElementById("cadastroaluno");
           // const tabela_alunos = document.getElementById("Alunos");

          //  cadastro_aluno.addEventListener("keyup", () => {
               // let expressao = cadastro_aluno.value.toLowerCase();

                //if(expressao.length < 2) {

                //}
                
              //  let linhas = tabela_alunos.getElementsByTagName("tr");

             //   for (let posicao in linhas) {
             //      if (true === isNaN(posicao)) {
             //       continue;
              //     }

             //      let conteudoDaLinha = linhas[posicao].innerHTML.toLowerCase();

               //    if (true === conteudoDaLinha.includes(expressao)) {
              //      linhas[posicao].style.display = "";
               //    } else {
              //      linhas[posicao.style.display = "none"];
              //     }
              //  }

           // });
        });
        </script>
    </body>
    </html>
