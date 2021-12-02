<?php
include '../../config/conectionDB.php';

$idCliente = $_POST['idCliente'];

$sqlDados = "select cli.nome, cli.dataNasc, cli.CPF, cli.email, cli.telefone, cli.estado, cli.cidade,
		aco.nome, aco.numero, aco.valor,
		res.dataInicio, res.dataFim, res.dataCheckIn
        from pousada.cliente cli
        inner join pousada.reserva res on (cli.idCliente = res.idCliente)
        inner join acomodacao aco on (aco.idAcomodacao = res.idAcomodacao)
        where cli.idCliente = $idCliente;";

$sqlItems = "select itm.nome, itm.valor, itm.quantidade
        from acomodacao aco
        inner join frigobar fri on (fri.idAcomodacao = aco.idAcomodacao)
        inner join item itm on (itm.idFrigobar = fri.idFrigobar)
        where aco.idCliente = $idCliente;";
$queryDados = mysqli_query($con, $sqlDados);
$queryItems = mysqli_query($con, $sqlItems);

while ($data = mysqli_fetch_array($queryDados)) {
    $idade = intval(date('Y-m-d')) - intval($data[1]);
    ?>
    <div class='container cadastro' style='background: #34495e'>
        <h3 style='margin-top: -20px; color: #f1f5f7'>Confirmar Check-out</h3>
        <div class="inputArea flexDiv" style="background: #607e9c77; color: #f1f5f7">
            <span>Quarto <?= $data[7] ?> - nº<?= $data[8] ?></span>
            <span>Valor do quarto: <?= $data[9] ?></span>
            <span>Período reservado: <?= $data[10] ?> até <?= $data[11] ?></span>
        </div>
        <div class="inputArea flexDiv" style="background: #607e9c77; color: #f1f5f7">
            <span>Cliente: <?= $data[0] ?> - <?= $idade ?> anos</span>
            <span>CPF: <?= $data[2] ?></span>
            <span>Email: <?= $data[3] ?></span>
            <span>Telefone: <?= $data[4] ?></span>
            <span>Cidade: <?= $data[5] . ", " . $data[6] ?></span>
        </div>
        <div class="inputArea flexDiv" style='flex-direction: row; overflow: auto; background: #607e9c77; color: #f1f5f7'>
            <?php
            while ($dataItem = mysqli_fetch_array($queryItems)) {
                $consumido = round(rand(0, $dataItem[2]));
                ?>
                <div style='border: 1px solid black; margin: 5px; padding: 5px; border-radius: 4px; background: #34495e; 
                     min-width: 150px; max-width: 200px;
                     display: flex; justify-content: space-between; flex-direction: row; flex-wrap: wrap'
                     >
                    <span><b>Item: </b><?= $dataItem[0] ?></span>
                    <span><b>Valor: </b><?= $dataItem[1] ?></span>
                    <span><b>Consumido: </b><?= $consumido ?></span>
                    <span><b>Total: </b><?= intval($consumido) * floatval($dataItem[1]) ?></span>
                </div>
                <?php
                $total[] = intval($consumido) * floatval($dataItem[1]);
            }
            $pagarTotal = array_sum($total) + $data[9];
            ?>
        </div>

        <div>
<!--            <form method="POST" action='include/gCheckout.php'>
                <input name='idcliente' hidden value='<?= $idCliente ?>' />-->
                <input id='btnCheckout' onclick='realizarCheckOut(<?= $idCliente ?>)' type='submit' class='btnCadastrar' value='Confirmar Check-out'/> 
            <!--</form>-->
        </div>
    </div>
    <?php
}

