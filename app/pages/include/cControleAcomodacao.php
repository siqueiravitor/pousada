<?php
include '../../config/conectionDB.php';

$acomodacaoID = $_POST['idCli'];

$sql = "select status from acomodacao where idAcomodacao = $acomodacaoID";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

if ($row[0] == 's') {
    $acomodacaoStatus = 'n';
    $msg = "Acomodação desativada com sucesso!";
    $msgErro = "Erro ao desativar acomodação!";
} else {
    $acomodacaoStatus = 's';
    $msg = "Acomodação ativada com sucesso!";
    $msgErro = "Erro ao ativar acomodação!";
}

$sqlUpdate = "update acomodacao set status = '$acomodacaoStatus' where idAcomodacao = $acomodacaoID";

if (mysqli_query($con, $sqlUpdate)) {
    echo json_encode($msg);
} else {
    echo json_encode($msgErro);
}