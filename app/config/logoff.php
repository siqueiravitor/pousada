<?php

session_start();
session_destroy();

header("Location: ../../?msg=Deslogado com sucesso!&action=0");
