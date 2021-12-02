<?php
include '../../config/conectionDB.php';

$itemId = $_POST['item'];
$frigoId = $_POST['frigobarId'];

$sql = "delete from item where idFrigobar = $frigoId and idItem = $itemId";

if (mysqli_query($con, $sql)) {
    $msg = "Item removido com sucesso!";
} else {
    $msg = "erro";
}

echo json_encode($msg);
