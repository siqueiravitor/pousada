<?php
include '../../config/conectionDB.php';

$clienteID = $_POST['idCli'];

$sql = "select status from cliente where idCliente = $clienteID";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

if ($row[0] == 's') {
    $clienteStatus = 'n';
    $msg = "Cliente desativado com sucesso!";
    $msgErro = "Erro ao desativar cliente!";
} else {
    $clienteStatus = 's';
    $msg = "Cliente ativado com sucesso!";
    $msgErro = "Erro ao ativar cliente!";
}

$sqlUpdate = "update cliente set status = '$clienteStatus' where idCliente = $clienteID";

if (mysqli_query($con, $sqlUpdate)) {
    echo json_encode($msg);
} else {
    echo json_encode($msgErro);
}

