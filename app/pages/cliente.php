<?php
include '../config/seguranca.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no" />

        <link rel="stylesheet" href="../include/styles.css">
        <link rel="stylesheet" href="../include/msgStyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../config/functions.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $('#cadCliente').click(function (e) {
                    let nome = document.getElementById("nome");
                    let cpf = document.getElementById("cpf");
                    let email = document.getElementById("email");
                    let emailCheck = document.getElementById("emailCheck");
                    let telefone = document.getElementById("telefone");
                    let dataNasc = document.getElementById("dataNasc");
                    let estado = document.getElementById("estado");
                    let cidade = document.getElementById('cidade');
                    let erro = 0;
                    if
                            (
                                    nome.value === "" ||
                                    cpf.value === "" ||
                                    email.value === "" ||
                                    emailCheck.value === "" ||
                                    telefone.value === "" ||
                                    dataNasc.value === "" ||
                                    estado.value === "" ||
                                    cidade.value === ""
                                    )
                    {
                        msg('Preencha todos os campos!', 1);
                        erro++;
                    } else if (email.value !== emailCheck.value) {
                        msg('Emails devem ser iguais!', 1);
                        erro++;
                    }

                    e.preventDefault();

                    if (erro === 0) {
                        setTimeout(() => {
                        }, 1200)
                        $.ajax({
                            url: "./include/gCliente.php",
                            type: "POST",
                            data: $('form').serialize(),
                            dataType: "JSON",
                            success: function (mensagem) {
                                if (mensagem === 'erroCPF') {
                                    msg('CPF já cadastrado', 1);
                                    return;
                                } else if (mensagem === 'erro') {
                                    msg("Erro ao cadastrar!", 1);
                                    return;
                                } else {
                                    msg(mensagem, 0);
                                }

                                nome.value = '';
                                cpf.value = '';
                                email.value = '';
                                emailCheck.value = '';
                                telefone.value = '';
                                dataNasc.value = '';
                                estado.value = '';
                                cidade.value = '';
                                cidade.innerHTML = '';

                                let optionNull = document.createElement("option");
                                optionNull.value = '';
                                optionNull.innerHTML = 'Selecione a cidade';
                                optionNull.setAttribute("disabled", "disabled");
                                cidade.appendChild(optionNull);

                                console.log(mensagem)
                            },
                            error: function (mensagem) {
                                console.log(mensagem);
                            }
                        })
                    }
                });
                $('#estado').on('change', function () {
                    $.ajax({
                        url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + this.value + "/municipios?orderBy=nome",
                        type: "GET",
                        dataType: "JSON",
                        success: function (mensagem) {
                            let cidade = document.getElementById('cidade');
                            cidade.innerHTML = '';
                            mensagem.map((msg) => {
                                let divNova = document.createElement("option");
//                                let id = msg.id;
                                let nome = msg.nome;
                                cidade.appendChild(divNova);
                                divNova.value = nome;
                                divNova.innerHTML = nome;
                            });
                        },
                        error: function (mensagem) {
                            console.log(mensagem);
                        }
                    });
                });
            });

        </script>
    </head>
    <body>

        <?php
        include '../components/navbar.php';
        ?>

        <div id="msgArea" class="msgTop" style="display:flex; flex-direction: column; ">
        </div>
        <div class="body">
            <form>
                <div class="container cadastro">
                    <h1>Cadastrar cliente</h1>
                    <div class="inputArea">
                        <input id="nome" name="nome" type="text" autocomplete="off" placeholder="Nome Completo" />
                        <input id="cpf" name="cpf" type="text" autocomplete="off" placeholder="CPF" />
                    </div>
                    <div class="inputArea">
                        <input id="email" name="email" type="email" autocomplete="off" placeholder="Email" />
                        <input id="emailCheck" name="emailCheck" type="email" autocomplete="off" placeholder="Confirmar email" />
                    </div>
                    <div class="inputArea">
                        <input id="telefone" name="telefone" type="text" autocomplete="off" placeholder="Telefone" />
                        <input id="dataNasc" name="dataNasc" type="date" autocomplete="off" placeholder="Data de Nascimento" />
                    </div>

                    <div class="inputArea">
                        <select id="estado" name="estado" placeholder="Selecione o estado">
                            <option value="" disabled selected>Selecione o estado</option>

                            <?php
                            $estadosURL = "https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome";
                            $estados = json_decode(file_get_contents($estadosURL), true);

                            foreach ($estados as $estado) {
                                echo "<option value='" . $estado['sigla'] . "' >" . $estado['nome'] . "</option>";
                            }
                            ?>

                        </select>
                        <select id="cidade" name="cidade" placeholder="Selecione a cidade">
                            <option value="" disabled selected>Selecione a cidade</option>
                        </select>
                    </div>

                    <div class="container center" >
                        <button id="cadCliente" type="submit" class="btn btnCadastrar">Confirmar cadastro</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
