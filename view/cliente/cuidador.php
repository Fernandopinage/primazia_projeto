<?php

include_once "../../layout/heard.php";
include_once "../../dao/CategoriaDAO.php";
include_once "../../class/ClassCategoria.php";
include_once "../../dao/gerarProtocolo.php";

session_start();
if (empty($_SESSION['user'])) {

    header('location: ../../view/cliente/login.php');
}

if (isset($_POST['salvaBaba'])) {

    if (!empty($_POST['categoria'])) {


        $ClassRequest = new Categoria();
        $ClassRequest->SetNome($_SESSION['user']['nome']);
        $ClassRequest->SetTelefone($_SESSION['user']['telefone']);
        $ClassRequest->SetEmail($_SESSION['user']['email']);
        $ClassRequest->SetCpf($_SESSION['user']['cpf']);
        $ClassRequest->SetCep($_SESSION['user']['cep']);
        $ClassRequest->SetCidade($_SESSION['user']['cidade']);
        $ClassRequest->SetLogradouro($_SESSION['user']['rua']);
        $ClassRequest->SetNumero($_SESSION['user']['numero']);
        $ClassRequest->SetUf($_SESSION['user']['uf']);
        $ClassRequest->SetBairro($_SESSION['user']['bairro']);
        $ClassRequest->SetComplemento($_SESSION['user']['complemento']);
        $ClassRequest->SetProtocolo(Protocolo::gerarProtocolo());

        $dados = array(

            'tpservico' => 'Cuidador(a) de Pessoas',
            'categoria' => @$_POST['categoria'],
            'descricao' => @$_POST['descricao'],


        );


        $ClassRequest->SetDescricao($dados);
        $Dedetizacao = new CategoriaDAO();
        $Dedetizacao->insertReparos($ClassRequest);
    }
}

?>
<link href="../../layout/css/cliente_baba.css" rel="stylesheet">
<div class="container-fluid">
    <a id="retorne" href="../../view/cliente/pedido.php" class="btn" style="position: relative; top:50px;background-color:orangered"><img src="../../images/left-arrow.png" width="28px" alt=""></a>
    <div class="container" id="registro">
        <div class="text-center">
            <a href="https://gotoservice.com.br/"><img src="../../images/primazia.png" alt="" width="250" height="190"></a>
        </div>

        <div class="title text-center">
            <p>Cuidador de pessoas</p>

        </div>


        <form action="" method="post">

            <div id="form-row">


                <!--***************************************************************************** --->
                <div id="pergunta01">

                    <div class="row g-12 ms-3 p-2">
                        <label class="fs-3">Qual servi??os voc?? procura?</label>
                        <br><br>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Acompanhamento em sa??das (supermercado, Shopping, etc)" name="categoria[]" id="sa??das" title="">
                            <label class="form-check-label" for="sa??das" title="">
                                Acompanhamento em sa??das (supermercado, Shopping, etc)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Acompanhamento terap??utico (consultas, p??s operat??rio, etc)" name="categoria[]" id="terap??utico" title="">
                            <label class="form-check-label" for="terap??utico" title="">
                                Acompanhamento terap??utico (consultas, p??s operat??rio, etc)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Administra????o de medicamentos" name="categoria[]" id="medicamentos" title="">
                            <label class="form-check-label" for="medicamentos" title="">
                                Administra????o de medicamentos
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Administra????o de refei????es" name="categoria[]" id="refei????es" title="">
                            <label class="form-check-label" for="refei????es" title="">
                                Administra????o de refei????es
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Banho" name="categoria[]" id="Banho" title="">
                            <label class="form-check-label" for="Banho" title="">
                                Banho
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Companhia" name="categoria[]" id="Companhia" title="">
                            <label class="form-check-label" for="Companhia" title="">
                                Companhia
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Transporte" name="categoria[]" id="Transporte" title="">
                            <label class="form-check-label" for="Transporte" title="">
                                Transporte
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="Outros" title="">
                            <label class="form-check-label" for="Outros" title="">
                                Outros
                            </label>
                            <div id="lista2">

                                <div class="mb-3">
                                    <label for="outros" class="form-label"></label>
                                    <textarea name="categoria[]" class="form-control" id="" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col text-center">
                            <button id='botaoEnviar' type="button" id="avanca01" onclick="avan??ando01()" class="btn orangered btn-lg">AVAN??AR</button>
                        </div>
                    </div>
                </div>
                <!--***************************************************************************** --->

                <!--***************************************************************************** --->
                <div id="pergunta02">
                    <div class="row g-5">
                        <div class="col">
                            <label class="fs-3">O paciente ???</label>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Adulto com limita????es" name="descricao[]" id="Adulto" title="">
                                <label class="form-check-label" for="Adulto" title="">
                                    Adulto com limita????es
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Crian??a com limita????es" name="descricao[]" id="Crian??a" title="">
                                <label class="form-check-label" for="Crian??a" title="">
                                    Crian??a com limita????es
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Idoso" name="descricao[]" id="Idoso" title="">
                                <label class="form-check-label" for="Idoso" title="">
                                    Idoso
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Gestante" name="descricao[]" id="Gestante" title="">
                                <label class="form-check-label" for="Gestante" title="">
                                    Gestante
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="row" style="margin-top: 20px;">
                        <div class="col text-center">
                            <button id='botaoEnviar' type="button" id="volta01" onclick="voltando02()" class="btn azulprima btn-lg">VOLTAR</button>
                        </div>
                        <div class="col text-center">
                            <input id='botaoEnviar' type="submit" name="salvaBaba" value="FINALIZAR" class="btn orangered btn-lg">
                        </div>
                    </div>
                </div>
                <!--***************************************************************************** --->



            </div>
        </form>
    </div>

    <div class="container" id="registro_logo">
        <img id='photo' src="../../images/cuidador.gif" class="img">
    </div>


</div>

<script>
    document.getElementById('pergunta02').style.display = 'none';
    document.getElementById('lista2').style.display = 'none';
    $('#Outros').click(function() {

        if (document.getElementById('Outros').checked) {
            document.getElementById('lista2').style.display = 'block';
        } else {
            document.getElementById('lista2').style.display = 'none';
        }
    });


    function avan??ando01() {

        var check01 = document.getElementById('sa??das');
        var check02 = document.getElementById('terap??utico');
        var check03 = document.getElementById('medicamentos');
        var check04 = document.getElementById('refei????es');
        var check05 = document.getElementById('Banho');
        var check06 = document.getElementById('Companhia');
        var check07 = document.getElementById('Transporte');
        var check08 = document.getElementById('Outros');


        if (check01.checked || check02.checked || check03.checked || check04.checked || check05.checked || check06.checked || check07.checked || check08.checked) {

            document.getElementById('pergunta01').style.display = 'none';
            document.getElementById('pergunta02').style.display = 'block';
        } else {
            Swal.fire({
                position: 'top-center',
                icon: 'info',
                text: 'PREENCHA COM PELO MENOS UMA OP????O',
                showConfirmButton: false,
                timer: 4500
            })
        }

    }

    function voltando02() {
        document.getElementById('pergunta01').style.display = 'block';
        document.getElementById('pergunta02').style.display = 'none';
    }
</script>

<?php
include_once "../../layout/footer.php";
?>