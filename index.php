<?php
session_start();
include 'app/config/conectionDB.php';

if (isset($_SESSION['idUser'])) {
    header("Location: app");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no" />

        <title>Pousada Parnaióca</title>
        <!--<link rel="stylesheet" href="app/include/styles.css">-->
        <link rel="stylesheet" href="app/include/msgStyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="app/config/functions.js"></script>
        <style>
            body{
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background: #34495e;
            }
            .box{
                width: 300px;
                padding: 40px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #191919;
                text-align: center;
                border-radius: 8px;
            }
            .box h1{
                color: #fff;
                text-transform: uppercase;
                font-weight: 500;
            }
            .box input[type='text'], .box input[type = 'password']{
                border:0;
                background: none;
                display: block;
                margin: 20px auto;
                text-align: center;
                border: 2px solid #3498db;
                padding: 14px 10px;
                width: 200px;
                outline: none;
                color: #fff;
                border-radius: 24px;
                transition: .25s;
            }
            .box input[type='text']:focus, .box input[type = 'password']:focus{
                width: 280px;
                border-color: #2ecc71;
            }
            .box input[type='submit']{
                border:0;
                background: none;
                display: block;
                margin: 20px auto;
                text-align: center;
                border: 2px solid #2ecc71;
                padding: 14px 40px;
                outline: none;
                color: #fff;
                border-radius: 24px;
                transition: .25s;
                cursor: pointer;
                font-weight: 300;
            }
            .box input[type='submit']:hover{
                background: #2ecc71;
                color: #000;
            }
            .form-control {
                place-content: center;
                font-family: system-ui, sans-serif;
                font-weight: bold;
                line-height: 1;
                color: #f1f5f777;
                display: grid;
                grid-template-columns: .5em 8em;
                gap: 0.5em;
            }
            .box input[type='checkbox']{
                -webkit-appearance: none;
                appearance: none;
                background-color: transparent;
                margin: 0;
                font: inherit;
                color: currentColor;
                width: 1.15em;
                height: 1.15em;
                border: 0.15em solid #3498db;
                border-radius: 0.15em;
                transform: translateY(-0.075em);
                outline: none;
                display: grid;
                place-content: center;
                cursor: pointer;
            }
            input[type="checkbox"]::before {
                content: "X";
                color: #3498db;
                width: 0.65em;
                height: 0.65em;
                transform: scale(0);
                transition: 120ms transform ease-in-out;
                box-shadow: inset 1em 1em var(--form-control-color);
                transform-origin: bottom left;
                clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
            }
            input[type="checkbox"]:checked::before {
                transform: scale(1);
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                hideMsg()

                $('#logar').click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "./login/validaLogin.php",
                        type: "POST",
                        data: $('form').serialize(),
                        dataType: "JSON",
                        success: function (mensagem) {
                            console.log(mensagem);

                            if (mensagem === 'logado') {
                                window.location.href = './app';
                                return;
                            }
                            msg(mensagem, 1);
                        },
                        error: function (mensagem) {
                            console.log(mensagem);
                        }
                    })
                });
            });

            function passVisible() {
                let check = document.getElementById('setVisible');
                let senha = document.getElementById('senha');

                $('#setVisible').toggleClass('setVisibleCheck');
                if (!check.classList.contains('setVisibleCheck')) {
                    senha.type = 'password';
                } else {
                    senha.type = 'text';
                }
            }

            function hideMsg() {
                setTimeout(() => {
                    document.getElementById('mensagem').className = 'hide';
                }, 2000);
                setTimeout(() => {
                    document.getElementById('mensagem').style.display = 'none';
                }, 3000);
            }
        </script>
    </head>
    <body>
        <div id="msgArea" class="msgTop" style="display:flex; flex-direction: column; ">
            <?php
            if (isset($_GET['msg']) && !isset($_GET['action'])) {
                ?>
                <div id='mensagem' class='msgErro'>
                    <span> <?= $_GET['msg'] ?></span>
                </div>
                <?php
            } else if (isset($_GET['msg'])) {
                ?>
                <div id='mensagem' class=' msgSuccess'>
                    <span> <?= $_GET['msg'] ?></span>
                </div>
                <?php
            }
            ?>
        </div>
        <!--        <h1>Login</h1>
                <form class="loginArea">
                    <div class="container">
                        <input id="login" name="login" type="text" autocomplete="off" placeholder="Login" />
                    </div>
                    <div class="container">
                        <input id="senha" name="senha" type="password" autocomplete="off" placeholder="Senha" />
                    </div>
                    <div class="container">
                        <button id="setVisible" type="button" onclick="passVisible()"></button><span>Mostrar senha</span>
                    </div>
                    <div class="container center" >
                        <button id="logar" type="submit" class="btn">Acessar</button>
                    </div>
                </form>-->
        <form class="box">
            <h1>Login</h1>

            <input id="login" name="login" type="text" autocomplete="off" placeholder="Login" />
            <input id="senha" name="senha" type="password" autocomplete="off" placeholder="Senha" />

<!--<button id="setVisible" type="button" onclick="passVisible()"></button><span>Mostrar senha</span>-->
            <!--<button id="setVisible" type="button" onclick="passVisible()"></button><span>Mostrar senha</span>-->
            <label class="form-control">
                <input id="setVisible" type='checkbox' onclick="passVisible()"/>
                Mostrar senha
            </label>
            <input id="logar" type="submit" value='Login' class="btn" />
        </div>
    </form>
</body>
</html>
