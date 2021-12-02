<?php
include './config/seguranca.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no" />

        <title>Pousada Parnaióca</title>
        <link rel="stylesheet" href="include/homeStyle.css">

    </head>
    <body>
        <?php
        include './components/navbar.php';
        ?>
        <div class="main">

            <a href="pages/cliente.php" class="link">
                <div class="card">
                    <div><span>Cadastrar Cliente</span></div>
                </div>
            </a>
            <a href="pages/acomodacao.php" class="link">
                <div class="card">
                    <div><span>Cadastrar Acomodação</span></div>
                </div>
            </a>
            <a href="pages/frigobar.php" class="link">
                <div class="card">
                    <div><span>Cadastrar Frigobares</span></div>
                </div>
            </a>
            <a href="pages/controle.php" class="link">
                <div class="card">
                    <div><span>Controle</span></div>
                </div>
            </a>

            <?php
            if (isset($_SESSION['admin'])) {
                echo " 
                        <a href='pages/frigobar.php' class='link'>
                            <div class='card'>
                                <div><span>Cadastrar funcionários</span></div>
                            </div>
                        </a>
                    ";
                echo " 
                        <a href='pages/frigobar.php' class='link'>
                            <div class='card'>
                                <div><span>Grupos</span></div>
                            </div>
                        </a>
                    ";
            }
            ?>

        </div>
    </body>
</html>
