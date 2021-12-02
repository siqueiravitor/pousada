<?php
include '../../config/conectionDB.php';

$idCliente = $_POST['dados'];

$sqlAcomodacao = "select idAcomodacao, nome, numero, valor from acomodacao where idCliente = $idCliente";
$queryAcomodacao = mysqli_query($con, $sqlAcomodacao);

$rowAco = mysqli_fetch_array($queryAcomodacao);

$sqlReserva = "select idReserva, checkIn, checkOut, dataInicio, dataFim, dataCheckIn, dataCheckOut
               from reserva
               where idCliente = $idCliente
                 and idAcomodacao = {$rowAco['idAcomodacao']}";
$queryReserva = mysqli_query($con, $sqlReserva);
;

$rowRes = mysqli_fetch_array($queryReserva);

$data = array(
    'idReserva' => $rowRes[0],
    'acoNome' => $rowAco[1],
    'acoNum' => $rowAco[2],
    'acoVal' => $rowAco[3],
    'checkIn' => $rowRes[1],
    'checkOut' => $rowRes[2],
    'datIni' => $rowRes[3],
    'datFim' => $rowRes[4],
    'dataCheckIn' => $rowRes[5],
    'dataCheckOut' => $rowRes[6]
);

//echo json_encode($data);
if ($data['checkIn'] == false) {
//    echo json_encode("Check in Pendente");
    ?>
    <form id='formReserva'>
        <div class='container cadastro '>
            <div class="inputArea flexDiv">
                <span>Quarto <?= $data['acoNome'] ?> - nº<?= $data['acoNum'] ?></span>
                <span>Valor do quarto: <?= $data['acoVal'] ?></span>
                <span>Período reservado: <?= $data['datIni'] ?> até <?= $data['datFim'] ?></span>
                <span><b>Check-in não realizado</b></span>
            </div>
            <div>
                <input type='button' onclick='rCheckIn(<?= $data['idReserva'] ?>)' class='btnCadastrar' value='Realizar Check-In'/> 
            </div>
        </div>
    </form>
    <?php
} else if ($data['checkOut'] == false) {
//    echo json_encode("Check Realizado");
    ?>
    <div class='container cadastro '>
        <div class="inputArea flexDiv">
            <span>Quarto <?= $data['acoNome'] ?> - nº<?= $data['acoNum'] ?></span>
            <span>Valor do quarto: <?= $data['acoVal'] ?></span>
            <span>Período reservado: <?= $data['datIni'] ?> até <?= $data['datFim'] ?></span>
            <span><b>Check-in Efetuado</b></span>
        </div>
        <div>
            <input id='btnCheckout' onclick='confirm(this, <?= $idCliente ?>)' type='button' class='btnCadastrar' value='Realizar Check-out'/> 
        </div>
    </div>
    <?php
} else {
    //CHECK IN E CHECK OUT EFETUADOS!
    ?>
    <div>
        <span style="margin-top: 50px;">Não há reserva para esse cliente!</span>
    </div>
    <?php
}