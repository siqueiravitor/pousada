<?php
/* Mysql */
$con = mysqlI_connect("127.0.0.1", "root", "", "pousada");

if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
  alert('Erro na Conexão');
}
