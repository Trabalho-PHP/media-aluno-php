<?php
function conexao(){   // Configurações do banco de dados
    $usuario = "root";
    $senha = "";
    $database = "login";
    $host = "localhost";

    // Criar uma conexão
    $mysqli = new mysqli($host, $usuario, $senha, $database);

    // Verificar a conexão
    if ($mysqli->connect_error) {
        die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
    } 
    return $mysqli;
}

// Chamada da função para obter a instância do MySQLi
$mysqli = conexao();
?>
