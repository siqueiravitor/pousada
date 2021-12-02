<?php
include '../../config/conectionDB.php';

$idReserva = $_POST['idreserva'];
$sql = "update reserva set checkIn = true, dataCheckIn = '".date("Y-m-d h:i:s")."'  where idReserva = $idReserva";
if(mysqli_query($con, $sql)){
//    $msg = "sucesso";
    
    $sqlIdCli = "select idCliente from reserva where idReserva = $idReserva";
    $queryIdCli = mysqli_query($con, $sqlIdCli);
    $rowCli = mysqli_fetch_array($queryIdCli);
    
    $msg = $rowCli[0];
} else {
    $msg = "erro";
}

echo json_encode($msg);