<?php

include '../../config/conectionDB.php';

$idCliente = $_POST['idCliente'];

$sql = "update reserva set checkOut = true where idCliente = $idCliente";
if (mysqli_query($con, $sql)) {
    $msg = 'Check-Out realizado com successo';
} else {
    $msg = 'erro';
}


$sql2 = "update reserva set dataCheckOut = '" . date('Y-m-d H:i:s') . "'where idCliente = $idCliente";
if (mysqli_query($con, $sql2)) {
    $msg = 'Check-Out realizado com successo';
} else {
    $msg = 'erro';
}

if ($msg != 'erro') {
    $keyCheck = "set foreign_key_checks = 0;";
    mysqli_query($con, $keyCheck);
    $sqlAco = " 
                update acomodacao set idCliente = null
                where idCliente = $idCliente;";
    if (mysqli_query($con, $sqlAco)) {
        $msg = 'Check-Out realizado com successo';
    } else {
        $msg = 'erro';
    }
}

echo json_encode($msg);
