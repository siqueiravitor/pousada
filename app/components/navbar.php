<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            *{
                margin: 0;
                padding: 0;
            }
            .top{
                margin-top: 15px;
                display:flex;
                justify-content: center;
            }
            .navbar {
                border-radius: 8px; 
                overflow: auto;
                align-items: center;

                user-select: none;
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
            }

            .navbar a {
                min-height: 20px;
                float: left;
                text-align: center;
                color: white;
                text-decoration: none;
                font-size: 17px;
                padding: 12px;

                user-drag: none;
                -webkit-user-drag: none;
            }
            a{
                background-color: #34495e;
            }
            .navbar a:last-child{
                background-color: #f00;
                font-weight: bold;
            }
            .navbar a:last-child:hover{
                background-color: #000 !important;
                color: #f00;
            }
            .navbar a:hover:not(.active) {
                background-color: #04AA6D;
            }
            .active {
                background-color: #2ecc71;
            }

            @media screen and (max-width: 500px) {
                body{
                    padding-top: 0;
                }
                .navbar a {
                    float: none;
                    display: block;
                }
                .navbar{
                    border-radius: 0; 
                    position: unset;
                    top: 0;

                    margin-bottom: 10px;
                }
                .top{
                    display: inline;
                }
            }
            @media screen and (max-device-width: 600px){
                body{
                    padding-top: 0;
                }
                .navbar a {
                    padding: 30px 0;
                    font-size: 30px;
                    float: none;
                    display: block;
                }
                .navbar{
                    position: fixed;
                    bottom: 10px;
                    right: auto;
                    left: auto;
                    border-radius: 0; 
                    position: unset;
                    top: 0;
                    margin-bottom: 0;
                }
                .top{
                    display: inline;
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let page = document.getElementById('page').value;
                page = page.split('.').shift();

                let home = document.getElementById('homePage');
                let acomodacao = document.getElementById('roomPage');
                let cliente = document.getElementById('clientPage');
                let frigobar = document.getElementById('frigobarPage');
                let controle = document.getElementById('controlePage');
                let logoff = document.getElementById('logoff');

                if (page === 'index') {
                    home.className = 'active'

                    home.setAttribute('href', "#");
                    cliente.setAttribute('href', "pages/cliente.php");
                    acomodacao.setAttribute('href', "pages/acomodacao.php");
                    frigobar.setAttribute('href', "pages/frigobar.php");
                    controle.setAttribute('href', "pages/controle.php");
                    logoff.setAttribute('href', "config/logoff.php");
                } else {
                    home.setAttribute('href', "../");
                    cliente.setAttribute('href', "cliente.php");
                    acomodacao.setAttribute('href', "acomodacao.php");
                    frigobar.setAttribute('href', "frigobar.php");
                    controle.setAttribute('href', "controle.php");
                    logoff.setAttribute('href', "../config/logoff.php");
                }

                if (page === 'acomodacao') {
                    acomodacao.className = 'active';
                    acomodacao.setAttribute('href', "#");
                }
                if (page === 'cliente') {
                    cliente.className = 'active';
                    cliente.setAttribute('href', "#");
                }
                if (page === 'frigobar') {
                    frigobar.className = 'active';
                    frigobar.setAttribute('href', "#");
                }
                if (page === 'controle') {
                    controle.className = 'active';
                    controle.setAttribute('href', "#");
                }
            })
        </script>
    </head>
    <body>
        <?php
        echo "<input id='page' value='" . basename($_SERVER['PHP_SELF']) . "' hidden>";
        ?>
        <div class="top">
            <div class="navbar">
                <a id="homePage" ><i class="fa fa-fw fa-home"></i> Home</a>
                <a id="clientPage"><i class="fa fa-fw fa-user"></i> Cliente</a>
                <a id="roomPage"><i class="fa fa-fw fa-hotel"></i> Acomodação</a>
                <a id="frigobarPage" ><i class="fa fa-fw fa-glass"></i>Frigobar</a>
                <a id="controlePage" ><i class="fa fa-fw fa-cog"></i>Controle</a>
                <a id="logoff" ><i class="fa fa-fw fa-power-off"></i></a>
            </div>
        </div>
    </body>
</html>
