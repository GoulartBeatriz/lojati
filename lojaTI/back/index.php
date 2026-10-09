<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "Clientes"  : "teste");

function teste(){
    echo "API respondendo com sucesso!";
}

function listarClientes($con){
    $stmt = $con->query("SELECT * FROM Clientes");
    echo json_encode($stmt ->fetchAll(PDO::FETCH_ASSOC));
}

function adicionar($con){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    try{
        $stmt = $con->prepare("INSERT INTO Clientes (nome, email, telefone, endereco) VALUES (?, ?,?,?)");
        $stmt ->execute([$nome, $email, $telefone, $endereco]);
        header("Location: ../front/index.html");
    }catch (PDOExcepetion $e){
        header("Location: ../front/erro.html");
    }
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    adicionar($con);
}else if($rota === "clientes"){
    listarClientes($con);
}else {
    teste();
}
    
?>