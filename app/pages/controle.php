<?php
include '../config/conectionDB.php';
include '../config/seguranca.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no" />

        <title></title>
        <link rel="stylesheet" href="../include/modal.css">
        <link rel="stylesheet" href="../include/styles.css">
        <link rel="stylesheet" href="../include/msgStyle.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../config/modal.js"></script>
        <script src="../config/functions.js"></script>

        <style>
            table{
                user-select: none;
            }
            .btnAtivar{
                font-weight: bold;
                width: 80px; 
                padding: 5px;
                background-color: #0fa7;
            }
            .btnDesativar{
                font-weight: bold;
                width: 80px; 
                padding: 5px;
                background-color: #f007;
                color: #fff;
            }
            .flexDiv{
                flex-direction: column;
                /*border: 1px solid #3337;*/
                border-radius: 4px;
                background: #f1f5f7;
                padding: 15px;
            }
            @media screen and (max-device-width: 600px){
                .btnAtivar{
                    font-weight: bold;
                    width: 15vw; 
                    padding: 20px;
                    background-color: #0fa7;
                }
                .btnDesativar{
                    font-weight: bold;
                    width: 15vw; 
                    padding: 20px;
                    background-color: #f007;
                    color: #fff;
                }
                .buttons{
                    position: initial; 
                    margin-top: 50px;
                    display: flex; 
                    flex-direction: column;
                }
                button{
                    cursor: pointer;
                    font-size: 20px;
                }
                .btn{
                    font-size: 30px;
                    padding: 30px 0;
                }
                .selected{
                    font-size: 30px;                    
                    padding: 30px 0;
                    color: #0007;
                }
                #myTable_filter{
                    margin-right: 1.2em;
                }
                label{
                    font-size: 2em
                }
                input[type='search']{
                    padding: 0 !important;
                    border: 2px solid black;
                }
            }
        </style>
        <script>
            $(document).ready(function () {
                $('#myTable').DataTable({
                    "paging": false,
                    "order": [[7, "desc"]],
                });
                $('#myTableTwo').DataTable({
                    "paging": false,
                    "order": [[7, "desc"]],
                });
                $('#cRes').on('click', function () {
                    let cliente = document.getElementById('cliente').value;
                    loadReserva(cliente);
                });
            });
            function loadReserva(value) {
                $.ajax({
                    url: "include/cReserva.php",
                    type: "POST",
                    data: {dados: value},
                    dataType: "HTML",
                    success: function (data) {
                        $("#reservaStatusArea").html(data);
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }

            function mudarStatusCliente(data) {
                $.ajax({
                    url: "./include/cControle.php",
                    type: "POST",
                    data: $('.' + data).serialize(),
                    dataType: "JSON",
                    success: function (mensagem) {
                        let text, classe;

                        if (mensagem === 'Cliente ativado com sucesso!') {
                            text = 'Desativar';
                            classe = 'btnDesativar'
                        } else if (mensagem === 'Cliente desativado com sucesso!') {
                            text = 'Ativar';
                            classe = 'btnAtivar'
                        }
                        msg(mensagem, 0);

                        document.getElementById("cli_" + data).className = classe;
                        document.getElementById("cli_" + data).innerHTML = text;
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }
            function mudarStatusAcomodacao(data) {
                $.ajax({
                    url: "./include/cControleAcomodacao.php",
                    type: "POST",
                    data: $('.' + data).serialize(),
                    dataType: "JSON",
                    success: function (mensagem) {
                        let text, classe;

                        if (mensagem === 'Acomodação ativada com sucesso!') {
                            text = 'Desativar';
                            classe = 'btnDesativar'
                        } else if (mensagem === 'Acomodação desativada com sucesso!') {
                            text = 'Ativar';
                            classe = 'btnAtivar'
                        }
                        msg(mensagem, 0);

                        document.getElementById("aco_" + data).className = classe;
                        document.getElementById("aco_" + data).innerHTML = text;
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }
            function acomodacao(props) {
                let checkIn = document.getElementById("checkInArea");
                let checkInBtn = document.getElementById("showCheckIn");
                let cliTable = document.getElementById("clientesTable");
                let cliBtn = document.getElementById("showClientes");
                let acoTable = document.getElementById("acomodacoesTable");
                let acoBtn = document.getElementById("showAcomodacoes");

                checkIn.className = 'none';
                cliTable.className = 'none';
                acoTable.className = 'none';

                checkInBtn.className = 'btn select';
                acoBtn.className = 'btn select';
                cliBtn.className = 'btn select';

                checkInBtn.removeAttribute('disabled');
                cliBtn.removeAttribute('disabled');
                acoBtn.removeAttribute('disabled');

                if (props === 'showCheckIn') {
                    checkIn.className = 'flex';
                    checkInBtn.className = 'selected';
                    checkInBtn.setAttribute('disabled', 'disabled');
                }
                if (props === 'showClientes') {
                    cliTable.className = 'flex';
                    cliBtn.className = 'selected';
                    cliBtn.setAttribute('disabled', 'disabled');
                }
                if (props === 'showAcomodacoes') {
                    acoTable.className = 'flex';
                    acoBtn.className = 'selected';
                    acoBtn.setAttribute('disabled', 'disabled');
                }
            }
            function rCheckIn(value) {
                $.ajax({
                    url: "./include/gCheckIn.php",
                    type: "POST",
                    data: {idreserva: value},
                    dataType: "JSON",
                    success: function (data) {
                        if (data === 'erro') {
                            msg("Erro ao realizar o check-in");
                        } else {
                            msg("Check-in efetuado com sucesso!", 0)
                            loadReserva(data)
                        }
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }
            function confirm(input, idCliente){
                $.ajax({
                    url: "./include/cCheckout.php",
                    type: "POST",
                    data: {idCliente: idCliente},
                    dataType: "HTML",
                    success: function (data) {
                        let area = document.getElementById('modalArea');
                        modal(data, 'Confirmar Check-Out', area);
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }
            function realizarCheckOut(idCliente){
                $.ajax({
                    url: "./include/gCheckout.php",
                    type: "POST",
                    data: {idCliente: idCliente},
                    dataType: "JSON",
                    success: function (data) {
                        if (data === 'erro') {
                            msg("Erro ao realizar o check-out");
                        } else {
                            msg("Check-out efetuado com sucesso!", 0)
                            
                            let modal = document.getElementById('modalArea').style.display = 'none';
                            setTimeout(()=> {document.location.reload(true); }, 1200);

                        }
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                });
            }


        </script>
    </head>
    <body>
        <?php
        include '../components/navbar.php';
        ?>

        <div id="msgArea" class="msgTop" style="display:flex; flex-direction: column; ">
        </div>
        <div id='modalArea'></div>

        <div class="buttons">
            <button id='showCheckIn' onclick="acomodacao(this.id)" class="selected" disabled>Reservas</button>
            <button id='showClientes' onclick="acomodacao(this.id)" class="btn select">Clientes</button>
            <button id='showAcomodacoes' onclick="acomodacao(this.id)" class="btn select">Acomodações</button>
        </div>

        <div class="body">
            <div style="max-height: 75vh; ">
                <div id="checkInArea" class="flex">
                    <div class="body">
                        <form>
                            <div class="container cadastro">
                                <h1>Consultar reserva</h1>
                                <div class="inputArea">
                                    <select id="cliente" name="cliente" placeholder="Selecione o cliente">
                                        <option value="" disabled selected>Selecione o cliente</option>

                                        <?php
                                        $sqlClient = "select cli.idCliente, cli.nome from cliente cli
                                                    inner join acomodacao aco on (aco.idCliente = cli.idCliente)
                                                    where cli.status = 's'";
                                        $queryCliente = mysqli_query($con, $sqlClient);
                                        while ($cliente = mysqli_fetch_array($queryCliente)) {
                                            echo "<option value='" . $cliente['idCliente'] . "' >" . $cliente['nome'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                    <button id="cRes" type="button" class="btn btnCadastrar">Consultar</button>
                                </div>
                                <div id='reservaStatusArea'>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id='clientesTable' class='none'>
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Data de Nascimento</th>
                                <th>Telefone</th>
                                <th>Estado</th>
                                <th>Cidade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlCliente = "select 
                                            cli.idCliente,
                                            cli.nome,
                                            cli.email,
                                            cli.cpf,
                                            cli.dataNasc,
                                            cli.telefone,
                                            cli.estado,
                                            cli.cidade,
                                            cli.status,
                                            aco.idAcomodacao
                                        from cliente cli
                                        left join acomodacao aco on (cli.idCliente = aco.idCliente)
                                        order by cli.status";
                            $query = mysqli_query($con, $sqlCliente);
                            while ($row = mysqli_fetch_row($query)) {
                                if (isset($_SESSION['admin'])) {
                                    if ($row[8] == 's') {
                                        if ($row[9] == '') {
                                            $status = " 
                                            <button id='cli_$row[0]' onclick='mudarStatusCliente($row[0])' type='button' class='btnDesativar'>
                                                Desativar
                                            </button>
                                          ";
                                        } else {
                                            $status = " 
                                            <button disabled id='aco_$row[0]' type='button' class='btnDesativar' style='background: #f003; cursor:default'>
                                                Desativar
                                            </button>
                                          ";
                                        }
                                    } else {
                                        $status = "
                                            <button id='cli_$row[0]' onclick='mudarStatusCliente($row[0])' type='button' class='btnAtivar'>
                                                Ativar
                                            </button>
                                          ";
                                    }
                                } else {
                                    if ($row[8] == 's') {
                                        $status = " Ativo ";
                                    } else {
                                        $status = " Inativo ";
                                    }
                                }
                                $dataNascimento = DateTime::createFromFormat('Y-m-d', $row[4]);
                                $dataNasc = $dataNascimento->format('d/m/Y');

                                echo " 
                                    <tr>
                                        <td>$row[1]</td>
                                        <td>$row[2]</td>
                                        <td style='text-align: center'>$row[3]</td>
                                        <td style='text-align: center'>$dataNasc</td>
                                        <td style='text-align: center'>$row[5]</td>
                                        <td style='text-align: center'>$row[6]</td>
                                        <td>$row[7]</td>
                                        <td style='text-align: center'>
                                        <form class='$row[0]' method='POST' action='include/cControle.php'>
                                            <input name='idCli' hidden value='$row[0]' />
                                            $status
                                        </form>
                                        </td>
                                    </tr>
                                    ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id='acomodacoesTable' class="none">
                    <table id="myTableTwo">
                        <thead>
                            <tr>
                                <th>Acomodação</th>
                                <th>Nº</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Capacidade Max.</th>
                                <th>Estacionamento</th>
                                <th>Cliente</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlAcomodacao = "select 
                                                    aco.idAcomodacao, 
                                                    aco.nome, 
                                                    aco.numero, 
                                                    aco.tipo, 
                                                    aco.valor, 
                                                    aco.capMax, 
                                                    aco.estacionamento, 
                                                    cli.nome, 
                                                    aco.status 
                                                from acomodacao aco
                                                left join cliente cli on (cli.idCliente = aco.idCliente)
                                                order by idAcomodacao ";
                            $queryAcomodacao = mysqli_query($con, $sqlAcomodacao);
                            while ($row = mysqli_fetch_row($queryAcomodacao)) {
                                $valor = str_replace('.', ',', $row[4]);
                                if ($row[3] == 'b') {
                                    $tipo = 'Casal';
                                } else if ($row[3] == 'm') {
                                    $tipo = 'Família';
                                } else {
                                    $tipo = 'Suíte';
                                }
                                if ($row[6] == 's') {
                                    $parking = "Sim";
                                } else {
                                    $parking = "Não";
                                }
                                if ($row[7] != '') {
                                    $cliente = "<td style='min-width: 150px'>$row[7]</td>";
                                } else {
                                    $cliente = "<td style='color: #3337'>Quarto disponível</td>";
                                }
                                if (isset($_SESSION['admin'])) {
                                    if ($row[8] == 's') {
                                        if ($row[7] == '') {
                                            $status = " 
                                            <button id='aco_$row[0]' onclick='mudarStatusAcomodacao($row[0])' type='button' class='btnDesativar'>
                                                Desativar
                                            </button>
                                          ";
                                        } else {
                                            $status = " 
                                            <button disabled id='aco_$row[0]' type='button' class='btnDesativar' style='background: #f003; cursor:default'>
                                                Desativar
                                            </button>
                                          ";
                                        }
                                    } else {
                                        $status = "
                                            <button id='aco_$row[0]' onclick='mudarStatusAcomodacao($row[0])' type='button' class='btnAtivar'>
                                                Ativar
                                            </button>
                                          ";
                                    }
                                } else {
                                    if ($row[8] == 's') {
                                        $status = " Ativo";
                                    } else {
                                        $status = " Inativo";
                                    }
                                }
                                echo " 
                                    <tr>
                                        <td>$row[1]</td>
                                        <td style='text-align: center'>$row[2]</td>
                                        <td style='text-align: center'>$tipo</td>
                                        <td style='text-align: center'>$valor</td>
                                        <td style='text-align: center'>$row[5]</td>
                                        <td style='text-align: center'>$parking</td>
                                        $cliente
                                        <td style='text-align: center'>
                                        <form class='$row[0]'>
                                            <input name='idAco' hidden value='$row[0]' />
                                            $status
                                        </form>
                                        </td>
                                    </tr>
                                    ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</html>
