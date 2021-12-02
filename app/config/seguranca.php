<?php

session_start();

if (isset($_SESSION['idUser'])) {
    if (($_SESSION['timeLogged'] + 60*20) < time()) {
        session_destroy();
        header("Location: ../?msg=Sessão expirada!");
    } else {
        $_SESSION['timeLogged'] = time();
        return;
    }
} else {
    header("Location: ../?msg=Efetue o login!");
}
session_destroy();