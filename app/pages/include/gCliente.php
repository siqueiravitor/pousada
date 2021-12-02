<?php

include '../../config/conectionDB.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$emailCheck = $_POST['emailCheck'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$dataNasc = $_POST['dataNasc'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$erro = 0;

$sqlCheckCPF = "select * from cliente where cpf = $cpf";
$query = mysqli_query($con, $sqlCheckCPF);
if (mysqli_num_rows($query) > 0) {
    $erro++;
    $msg = 'erroCPF';

} else {
    $sql = "insert into cliente values (null, '$nome','$dataNasc','$cpf','$email','$telefone', '$estado', '$cidade', 's')";

    if (mysqli_query($con, $sql)) {
        $msg = "Cliente cadastrado com sucesso!";
    } else {
        $msg = 'erro';
        $erro++;
    }
}
echo json_encode($msg);

