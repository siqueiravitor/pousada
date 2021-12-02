<?php
include '../config/seguranca.php';
include '../config/conectionDB.php';
$countItem = 1;
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
                margin: 20px;
            }
            .consulta{
                width: 50vw;
                height: 60vh;
                padding: 10px;
                margin: 20px;
                border-radius: 8px;
                background: #607e9c77;
                box-shadow: 8px 7px 16px 1px #3337;
                overflow: auto;
            }
            #frigobarItems{
                display: flex;
                flex-direction: row;
                justify-content: center;
                width: 100%;
                flex-wrap: wrap;
                margin-top: 10px;
                overflow: auto;
            }
            .divItem{
                padding: 10px;
                margin: 5px;
                margin-top: 0;
                border: 1px solid black;
                min-height: 50px;
                background: #f1f5f7;
                border-radius: 4px;
                width: 25%;
                position: relative;
            }
            .divItemRemove:hover{
                cursor: pointer;
            }
            .divItemRemove:hover:before{
                content: "Duplo click para remover";
                position: absolute;
                top: 0;
                right: 0;

                display: flex;
                text-align: center;
                align-items: center;
                justify-content: center;
                text-transform: uppercase;
                border-radius: 4px;
                height: 100%;
                width: 100%;
                
                background: #000c;
                font-weight: 600;
                color: #f00;
            }
            .spanNome{
                white-space: pre;
                color: #000;
                font-weight: 600;
                line-height: 1.5em;
            }
            #mainArea{
                display: flex; 
                flex-direction: row; 
                width: 100vw; 
                justify-content: space-around;
                flex-wrap: wrap;
            }
            #row{
                display: flex; 
                flex-direction: row; 
            }
            .consulta > h2 {
                text-align: center;
            }
            @media screen and (max-device-width: 600px){
                #frigobarItems{
                    display: block;
                    scroll-snap-type: y mandatory !important;
                }
                .consulta{
                    padding-top: 30px;
                    width: 90% !important;
                    margin: auto !important;    
                    margin-top: 5em !important;
                }
                .divItem{
                    padding: 30px ;
                    margin-bottom: 30px;
                    width: auto;
                    scroll-snap-align: start !important;

                }
                .spanNome{
                    font-size: 50px;
                    font-weight: normal;
                }
                .divItemRemove:hover:before{
                    font-size: 3em;
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $('#acomodacao').on('change', function () {
                    loadItem();
                });

                $('#addItem').click(function (e) {
                    e.preventDefault();
                    let acomodacao = document.getElementById("acomodacao");
                    let valor = document.getElementById("valor");
                    let item = document.getElementById("item");
                    let qtd = document.getElementById("qtd");
                    let erro = 0;
                    if (acomodacao.value === "") {
                        msg("Selecione um quarto!", 1);
                        erro++;
                    }

                    if (erro === 0 && (valor.value === "" || item.value === "" || qtd.value === "")) {
                        msg('Preencha todos os campos!', 1);
                        erro++;
                    }


                    if (erro === 0) {
                        $.ajax({
                            url: "./include/gFrigobar.php",
                            type: "POST",
                            data: $('form').serialize(),
                            dataType: "JSON",
                            success: function (mensagem) {
                                valor.value = '';
                                item.value = '';
                                qtd.value = '';

                                if (mensagem !== 'erro') {
                                    msg(mensagem, 0);
                                    loadItem();
                                } else {
                                    msg('Erro ao cadastrar!', 1)
                                }
                            },
                            error: function (mensagem) {
                                console.log(mensagem);
                            }
                        })
                    }
                });
            });

            function loadItem() {
                $.ajax({
                    url: "./include/cFrigobar.php",
                    type: "POST",
                    data: $('form').serialize(),
                    dataType: "JSON",
                    success: function (itens) {
                        let friItem = document.getElementById("frigobarItems");
                        friItem.innerHTML = '';
                        if (itens === '') {
                            return;
                        }
                        itens.map((item) => {
                            let div = document.createElement("div");
                            if (document.getElementById('admin').value === 'admin') {
                                div.className = 'divItem divItemRemove';
                                div.ondblclick = () => removeItem(item.id, item.frigobarId);
                            } else {
                                div.className = 'divItem';
                            }
                            let spanNome = document.createElement("span");
                            spanNome.className = 'spanNome';
                            spanNome.innerHTML = item.nome + "\n" +
                                    "Valor: " + item.valor + "\n" +
                                    "Quantidade: " + item.quantidade;
                            div.appendChild(spanNome);
                            friItem.appendChild(div);
                        });
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                })
            }

            function removeItem(item, frigobar) {
                $.ajax({
                    url: "./include/eFrigobar.php",
                    type: "POST",
                    data: {
                        item: item,
                        frigobarId: frigobar
                    },
                    dataType: "JSON",
                    success: function (mensagem) {
                        if (mensagem !== 'erro') {
                            msg(mensagem, 0);
                            loadItem();
                        } else {
                            msg('Erro ao remover item!', 1)
                        }
                    },
                    error: function (mensagem) {
                        console.log(mensagem);
                    }
                })
            }
        </script>
    </head>
    <body>
        <?php
        include '../components/navbar.php';
        ?>

        <div id="msgArea" class="msgTop" style="display:flex; flex-direction: column; ">
        </div>
        <input id='admin' hidden value="<?= $_SESSION['admin']; ?>" />

        <div class="body" style="flex-direction: row; flex-wrap: wrap; flex: 1">
            <form class="loginArea">
                <div class="container cadastro">
                    <h2>Cadastrar item ao frigobar</h2>
                    <div class="inputArea">
                        <select id='acomodacao' name='acomodacao'>
                            <option value='' selected disabled>Quartos disponíveis</option>
                            <?php
                            $sql = "SELECT idAcomodacao, nome FROM acomodacao 
                                    WHERE status = 's'
                                    AND idAcomodacao NOT IN (
                                        SELECT idAcomodacao FROM acomodacao aco
                                        INNER JOIN cliente cli ON (cli.idCliente = aco.idCliente)
                                    );
                                    ";
                            $query = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                echo "<option value='$row[0]'>$row[1]</option>";
                            }
                            ?>
                        </select>
                        <input id='item' name='item' type='text' autocomplete='off' placeholder='Item' />
                    </div>
                    <div class="inputArea">
                        <input id='qtd' name='qtd' type='number' min='0' autocomplete='off' placeholder='Quantidade' />
                        <input id='valor' name='valor' type='number' autocomplete='off' placeholder='Valor' />
                    </div>
                    <div class="container center" >
                        <button id="addItem" type="submit" class="btn btnCadastrar">Cadastrar item</button>
                    </div>
                </div>
            </form>
            <div class="consulta">
                <h2>Itens no frigobar</h2>
                <div id="frigobarItems">
                    <!-- Itens to be added -->
                </div>
            </div>
        </div>




    </body>
</html>
