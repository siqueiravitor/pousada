<?php

include '../app/config/conectionDB.php';

$login = $_POST['login'];
$pass = $_POST['senha'];
$senha = md5($pass);

$sql = "select * from funcionario where login = '$login'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

if ($login == '' || $senha == '') {
    $msg = 'Preencha todos os campos!';
    echo json_encode($msg);

    return;
}

if (mysqli_num_rows($query) > 0) {
    
    if ($senha === $row[3]) {
        session_start();

        $_SESSION['idUser'] = $row[0];
        $_SESSION['user'] = $row[1];
        $_SESSION['login'] = $row[2];
        $_SESSION['timeLogged'] = time();
        
        if($row[4] == 's'){
            $_SESSION['admin'] = 'admin';
        }

        $msg = 'logado';
    } else {
        $msg = 'Senha inválida';
    }
} else {
    $msg = "Usuário inexistente";
}

echo json_encode($msg);
