<?php

include '../../config/conectionDB.php';
$cliente = $_POST['cliente'];
$acomodacao = $_POST['acomodacao'];
$dataIni = $_POST['dataIni'];
$dataFim = $_POST['dataFim'];

$sqlReserva = "insert into reserva values (null, $cliente, $acomodacao, 0, 0, '$dataIni', '$dataFim', null, null)";
if (mysqli_query($con, $sqlReserva)) {
    $sql = "update acomodacao set idCliente = $cliente where idAcomodacao = $acomodacao";

    if (mysqli_query($con, $sql)) {
        $clienteNome = "select nome from cliente where idCliente = $cliente";
        $queryNome = mysqli_query($con, $clienteNome);
        $rowCliente = mysqli_fetch_array($queryNome);

        $acomodacaoNome = "select nome from acomodacao where idAcomodacao = $acomodacao";
        $queryAcomodacao = mysqli_query($con, $acomodacaoNome);
        $rowAcomodacao = mysqli_fetch_array($queryAcomodacao);

        $msg = "$rowCliente[0] vinculado(a) ao $rowAcomodacao[0]";
    } else {
        $msg = "Erro ao vincular!";
    }
} else {
    $msg = "Erro ao fazer reserva!";
}

header("Location: ../acomodacao.php?msg=$msg");
