<?php
include '../../config/conectionDB.php';

$nome = $_POST['nome'];
$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$numero = $_POST['numero'];
$capacidadeMax = $_POST['capacidadeMax'];
$estacionamento = $_POST['estacionamento'];

$sql = "insert into acomodacao values (null, '$nome',$numero,'$tipo','$valor', $capacidadeMax, '$estacionamento', null, 's')";

$sqlNome = "select 1 from acomodacao where nome = '$nome'";
$queryNome = mysqli_query($con, $sqlNome);

$sqlNumero = "select 1 from acomodacao where numero = $numero";
$queryNumero = mysqli_query($con, $sqlNumero);

if(mysqli_num_rows($queryNome) > 0) {
    $msg = 'erroNome';
    echo json_encode($msg);

    return;
}
if(mysqli_num_rows($queryNumero) > 0) {
    $msg = 'erroNumero';
    echo json_encode($msg);

    return;
}


if(mysqli_query($con, $sql)){
    $msg = "Acomodação cadastrada com sucesso!";
} else {
    $msg = 'erro';
}
echo json_encode($msg);
