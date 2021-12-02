<?php
include '../config/seguranca.php';
include '../config/conectionDB.php'
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no" />

        <link rel="stylesheet" href="../include/styles.css">
        <link rel="stylesheet" href="../include/msgStyle.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../config/functions.js"></script>

        <style>
            .cadastro{
                min-width: 400px;
                min-height: 200px;
                max-height: 500px;
                padding: 30px;
                padding-top: 0;
                overflow: auto; 
                scroll-snap-type: y mandatory;
                text-align: left;
            }
            .box{
                border-radius: 8px;
                background: #607e9c77;
                box-shadow: 8px 7px 16px 1px #3337;
            }
            .vinculoItem{
                margin-top: 20px;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;

            }
            .vinculoItem > select {
                width: 45%;
                margin: 0 auto;
            }
            .vinculoItem > input[type='date'], .vinculoItem > input[type='text'] {
                padding: 5px; 
                padding-left: 5px;
                width: 45%;
                margin: 0 auto;
                margin-top: 30px
            }
            .vinculoItem > input[type='submit']{
                margin: 2.5rem auto;
            }
            #scroll{
                padding: 10px; 
                text-align: center;
            }
            #vinculoArea{
                height: 30vh;
                width: 30%;
                padding: 20px;
                margin: auto 0;
            }
            #consultar{
                width: 100%;
                display: flex;
                justify-content: space-around;
            }
            .shadow{

            }
            @media screen and (max-device-width: 600px){
                .body{
                    padding-bottom: 10em;
                }
                h1, h2{
                    text-align: center;
                }
                .cadastro{
                    min-height: none;
                    max-height: fit-content;
                }
                .vinculoItem > *{
                    margin: 0 !important;
                    margin-top: 0 !important;
                    margin-bottom: 20px !important;
                }
                .selected {
                    font-size: 40px;
                    width: 50% !important;
                    padding: 30px 50px;
                    border: none;
                }
                .buttons{
                    position: fixed;
                    top: unset;
                    bottom: 0;
                    display: flex; 
                    flex-direction: row;
                    width: 100% !important;
                    left: 0;
                    margin-bottom: 0
                }
                .buttons > button{
                    margin-bottom: 0
                }

                #scroll{
                    overflow: auto;
                    margin-bottom: 30px;

                }
                #cadastro{
                    width: 100% !important;
                }
                #consulta{
                    width: 100% !important;

                }
                #cadastrar{

                }
                #consultar{
                    flex-direction: column;
                }
                #vinculoArea{
                    height: auto;
                    width: 90vw;
                    padding: 20px;
                    padding-top: 30px;
                    padding-bottom: 0;
                    margin: 5em auto;
                }
                #vincular{
                    width: 100% !important;
                    margin-bottom: 10vh;
                }
                #mobile{
                    position: fixed;
                    bottom: 0;
                    display: flex;
                    justify-content: space-around;
                    width: 100%;
                }
                #scroll{
                    height: 100vh;
                    border: none;
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                hideMsg()

                $("#dataIni").on('blur', function () {
                    let datIni = document.getElementById("dataIni");
                    let datFim = document.getElementById("dataFim");
                    $("#dataFim").attr({type: 'date'});

                    if (datFim.value === '') {
                        datFim.value = datIni.value;
                    }
                    if (datIni.value > datFim.value) {
                        datFim.value = datIni.value;
                    }
                })
                $("#dataFim").on('blur', function () {
                    let datIni = document.getElementById("dataIni");
                    let datFim = document.getElementById("dataFim");
                    $("#dataIni").attr({type: 'date'});

                    if (datIni.value === '') {
                        datIni.value = datFim.value;
                    }
                    if (datFim.value < datIni.value) {
                        datFim.value = datIni.value;
                        msg('Data final não pode ser antes da data inicial', 1)
                    }
                })


                $("#dataIni").focus(function () {
                    $(this).attr({type: 'date'});
                });
                $("#dataFim").focus(function () {
                    $(this).attr({type: 'date'});
                });


                $('#cadQuarto').click(function (e) {
                    let nome = document.getElementById("nome");
                    let valor = document.getElementById("valor");
                    let numero = document.getElementById("numero");
                    let tipo = document.getElementById("tipo");
                    let capacidadeMax = document.getElementById("capacidadeMax");
                    let estacionamento = document.getElementById("estacionamento");
                    let erro = 0;

                    if
                            (
                                    nome.value === "" ||
                                    valor.value === "" ||
                                    numero.value === "" ||
                                    tipo.value === "" ||
                                    capacidadeMax.value === "" ||
                                    estacionamento.value === ""
                                    )
                    {
                        msg('Preencha todos os campos!', 1);
                        erro++;
                    }
                    e.preventDefault();

                    if (erro === 0) {
                        $.ajax({
                            url: "./include/gAcomodacao.php",
                            type: "POST",
                            data: $('form').serialize(),
                            dataType: "JSON",
                            success: function (mensagem) {

                                if (mensagem === 'erro') {
                                    msg('Erro ao cadastrar!', 1)
                                    return;
                                } else if (mensagem === 'erroNome') {
                                    msg('Nome já cadastrado!', 1)
                                    return;
                                } else if (mensagem === 'erroNumero') {
                                    msg('Número já cadastrado!', 1)
                                    return;
                                } else {
                                    msg(mensagem + ' Recarregando página', 0);
                                    setTimeout(() => {
                                        window.location.href = "acomodacao.php?msg=Quarto Cadastrado";
                                    }, 2000);
                                }

                                nome.value = '';
                                valor.value = '';
                                numero.value = '';
                                tipo.value = 'null';
                                capacidadeMax.value = '';
                                estacionamento.value = 'null';
                            },
                            error: function (mensagem) {
                                console.log(mensagem);
                            }
                        })
                    }
                });
            });
            function acomodacao(props) {
                if (props === 'cadastro') {
                    document.getElementById("consultar").className = 'none';
                    document.getElementById("cadastrar").className = 'flex';

                    document.getElementById("cadastro").className = 'selected';
                    document.getElementById("cadastro").setAttribute('disabled', 'disabled');
                    document.getElementById("consulta").className = 'btn select';
                    document.getElementById("consulta").removeAttribute('disabled');
                }
                if (props === 'consulta') {
                    document.getElementById("consultar").className = 'flex';
                    document.getElementById("cadastrar").className = 'none';

                    document.getElementById("consulta").className = 'selected';
                    document.getElementById("consulta").setAttribute('disabled', 'disabled');
                    document.getElementById("cadastro").className = 'btn select';
                    document.getElementById("cadastro").removeAttribute('disabled');
                }
            }
            function hideMsg() {
                let msg = document.getElementById('mensagem');
                if (msg !== '') {
                    setTimeout(() => {
                        msg.className = 'hide';
                    }, 2000);
                    setTimeout(() => {
                        msg.style.display = 'none';
                    }, 3000);
                }
            }
        </script>
    </head>
    <body>
        <?php
        include '../components/navbar.php';
        ?>
        <div id="msgArea" class="msgTop">
            <?php
            if (isset($_GET['msg']) && isset($_GET['action'])) {
                ?>
                <div id='mensagem' class='msgErro' onshow="hideMsg()">
                    <span> <?= $_GET['msg'] ?></span>
                </div>
                <?php
            } else if (isset($_GET['msg'])) {
                ?>
                <div id='mensagem' class=' msgSuccess' onshow="hideMsg()">
                    <span> <?= $_GET['msg'] ?></span>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="body"  style="">
            <form class="none" id="cadastrar">
                <div class="container cadastro">
                    <h2>Cadastrar Acomodação</h2>
                    <div class="inputArea">
                        <input id="nome" name="nome" type="text" autocomplete="off" placeholder="Nome do quarto" />
                        <input id="numero" name="numero" type="number" min='0' autocomplete="off" placeholder="Número do quarto" />
                    </div>
                    <div class="inputArea">
                        <input id="valor" name="valor" type="text" autocomplete="off" placeholder="Valor do quarto" />
                        <input id="capacidadeMax" name="capacidadeMax" type="number" min='0' autocomplete="off" placeholder="Capacidade máxima" />
                    </div>
                    <div class="inputArea">
                        <select id='tipo' name='tipo'>
                            <option value="null" selected disabled>Selecione o tipo de quarto</option>
                            <option value='b'>Quarto casal</option>
                            <option value='m'>Quarto família</option>
                            <option value='s'>Suíte</option>
                        </select>
                        <select id='estacionamento' name='estacionamento'>
                            <option value="null" selected disabled>Vaga de estacionamento</option>
                            <option value='n'>Não</option>
                            <option value='s'>Sim</option>
                        </select>
                    </div>

                    <div class="container center">
                        <button id="cadQuarto" type="submit" class="btn btnCadastrar">Confirmar cadastro</button>
                    </div>
                </div>
            </form>

            <div id="consultar" class="flex">
                <div id="scroll" class='box'>
                    <h2 style="margin-bottom: 10px">Acomodações cadastradas</h2>
                    <div class="cadastro" style="box-shadow: none;">
                        <?php
                        $sqlConsulta = "SELECT 
                                            aco.idAcomodacao,  
                                            aco.nome,
                                            aco.numero,
                                            aco.tipo,
                                            aco.valor,
                                            aco.capMax,
                                            aco.estacionamento,
                                            cli.nome,
                                            cli.idCliente,
                                            res.dataInicio,
                                            res.dataFim,
                                            res.checkIn
                                        FROM pousada.acomodacao aco
                                        LEFT JOIN cliente cli on (cli.idCliente = aco.idCliente)
                                        LEFT JOIN reserva res on (aco.idAcomodacao = res.idAcomodacao)                                        
                                        where aco.status = 's'
                                        ORDER BY idCliente
                                        ;";
                        $queryConsulta = mysqli_query($con, $sqlConsulta);

                        while ($row = mysqli_fetch_array($queryConsulta)) {
                            $valor = str_replace('.', ',', $row[4]);
                            if ($row[3] == 'b') {
                                $tipo = "Casal";
                            } else if ($row[3] == 'm') {
                                $tipo = "Família";
                            } else {
                                $tipo = "Suíte";
                            }
                            if ($row[6] == 's') {
                                $parking = 'Sim';
                            } else {
                                $parking = 'Não';
                            }
                            if ($row[7] != "" || $row[7] != null) {
                                $cliente = "$row[7]";
                                $cor = '#34495e55';
                            } else {
                                $cor = '#34495e';
                                $cliente = 'Dísponível';
                            }
                            $dataIni = $row[9];
                            $dataFim = $row[10];
                            $dataReservada = '';

                            if ($dataIni != '' || $dataFim != '') {
                                $dataInicial = DateTime::createFromFormat('Y-m-d', $dataIni);
                                $dataIni = $dataInicial->format('d/m/Y');

                                $dataFinal = DateTime::createFromFormat('Y-m-d', $dataFim);
                                $dataFim = $dataFinal->format('d/m/Y');

                                $dataReservada = "

                                        <span><small>
                                            Reservado de 
                                            <b>    $dataIni</b>
                                            até
                                            <b>    $dataFim</b>
                                        </small></span>  
                                        ";
                            }
                            if ($cliente == 'Disponível') {
                                $dataReservada = '';
                            }

                            echo "
                                <div class='shadow' style='scroll-snap-align: start; border: 3px solid $cor; background: #f1f5f777; margin-bottom: 10px; padding: 10px;'>
                                    <span><b>Acomodação nº$row[2] - $row[1]</b> ($tipo) </span><br />
                                    <span><b>$cliente</b></span><br />
                                        <br />   
                                    <span>Valor: $valor</span><br />
                                    <span>Capacidade máxima: $row[5] pessoas</span><br />
                                    <span>Possui vaga de estacionamento? $parking</span><br /><br />
                                    $dataReservada

                                </div>
                                ";
                        }
                        ?>
                    </div>
                </div>
                <div id="vinculoArea" class='box'>
                    <h2>Reservar Acomodação</h2>
                    <form method="POST" action="include/gAcoCli.php">
                        <div class="vinculoItem">
                            <select id='acomodacao' name='acomodacao' required>
                                <option value='' selected disabled>Quartos disponíveis</option>
                                <?php
                                $sqlAcomodacao = "select idAcomodacao, nome from acomodacao where idCliente is null and status = 's'";
                                $queryAcomodacao = mysqli_query($con, $sqlAcomodacao);
                                while ($row = mysqli_fetch_array($queryAcomodacao)) {
                                    echo "<option value='$row[0]'>$row[1]</option>";
                                }
                                ?>
                            </select>
                            <select id='cliente' name='cliente' required>
                                <option value='' selected disabled>Clientes não vinculados</option>
                                <?php
                                $sqlCliente = "SELECT cli.idCliente, cli.nome 
                                            FROM pousada.cliente cli
                                            where cli.status = 's' and
                                            idCliente not in (
                                                    SELECT cli.idCliente
                                                    FROM pousada.cliente cli
                                                    inner join acomodacao aco on (cli.idCliente = aco.idCliente)
                                            ) 
                                            and status = 's';";
                                $queryCliente = mysqli_query($con, $sqlCliente);
                                while ($row = mysqli_fetch_array($queryCliente)) {
                                    echo "<option value='$row[0]'>$row[1]</option>";
                                }
                                ?>
                            </select>

                            <input type='text' id='dataIni' name="dataIni" autocomplete="off" placeholder="Data de entrada" required />
                            <input type='text' id='dataFim' name="dataFim" autocomplete="off" placeholder="Data de saída" required />

                            <input type="submit" id="vincular" class="btn btnCadastrar" onclick="acomodacao(this.id)" value='Realizar reserva' />
                        </div>
                    </form>
                </div>
            </div>

            <div class='buttons'>
                <button type="button" id="consulta" class="selected" disabled  onclick="acomodacao(this.id)">Consultar</button>
                <button type="button" id="cadastro" class="btn select" onclick="acomodacao(this.id)">Cadastrar</button>
            </div>
        </div>
    </body>
</html>
