<?php

include '../../config/conectionDB.php';

$acomodacao = $_POST['acomodacao'];

$sqlItem = "select idFrigobar from frigobar where idAcomodacao = $acomodacao";
$queryItem = mysqli_query($con, $sqlItem);

$row = mysqli_fetch_array($queryItem);

if (mysqli_num_rows($queryItem) > 0) {
    $frigoId = $row[0];
    $sqlFrigo = "select * from item where idFrigobar = $frigoId";

    $queryFrigo = mysqli_query($con, $sqlFrigo);

    if (mysqli_num_rows($queryFrigo) > 0) {
        while ($row = mysqli_fetch_array($queryFrigo)) {
            $itemNome = ucfirst($row[2]);
            $valorItem = str_replace('.', ',', $row[3]);

            $item[] = array(
                'id' => $row[0],
                'nome' => $itemNome,
                'valor' => $valorItem,
                'quantidade' => $row[4],
                'frigobarId' => $frigoId
            );
        }
    } else {
        $item = '';
    }
} else {
    $item = '';
}

echo json_encode($item);
