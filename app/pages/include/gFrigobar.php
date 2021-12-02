<?php
include '../../config/conectionDB.php';

$acomodacao = $_POST['acomodacao'];
$item = $_POST['item'];
$item = strtolower($item);
$qtdItem = $_POST['qtd'];
$valorItem = $_POST['valor'];
$valorItem = str_replace(',', '.', $valorItem);
$msg = '';
$erro = 0;

$sql = "select 1 from frigobar where idAcomodacao = $acomodacao";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);
if (mysqli_num_rows($query) == 0) {
    $sqlAddFrigobar = "insert into frigobar values (null, $acomodacao)";
    mysqli_query($con, $sqlAddFrigobar);

    $frigoId = mysqli_insert_id($con);
    $msg = 'Frigobar cadastrado! ';
} else {
    $sqlItem = "select idFrigobar from frigobar where idAcomodacao = $acomodacao";
    $queryItem = mysqli_query($con, $sqlItem);

    $row = mysqli_fetch_array($queryItem);
    $frigoId = $row[0];
}

$sqlItem = "select 1 from item where nome = '$item' and idFrigobar = '$frigoId'";
$queryItem = mysqli_query($con, $sqlItem);

if (mysqli_num_rows($queryItem) > 0) {
    $sqlUpdateItemVlr = "update item set valor = $valorItem where idFrigobar = $frigoId and nome = '$item';";
    $sqlUpdateItemQtd = "update item set quantidade = $qtdItem where idFrigobar = $frigoId and nome = '$item';";

    if (mysqli_query($con, $sqlUpdateItemVlr)) {
        
    } else {
        $erro++;
    }
    if (mysqli_query($con, $sqlUpdateItemQtd)) {
        
    } else {
        $erro++;
    }

    if ($erro == 0) {
        $msg .= "Quantidade/Valor de $item atualizado! ";
    }
} else {
    $sqlAddItem = "insert into item values (null, $frigoId, '$item', $valorItem, $qtdItem)";

    if (mysqli_query($con, $sqlAddItem)) {
        $item = ucfirst($item);
        $msg .= "$item adicionado ao frigobar";
    } else {
        $erro++;
    }
}
if($erro > 0){
    $msg = 'erro';
}

echo json_encode($msg);
