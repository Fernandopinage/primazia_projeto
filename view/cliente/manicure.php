<?php

include_once "../../layout/heard.php";
include_once "../../dao/CategoriaDAO.php";
include_once "../../class/ClassCategoria.php";
include_once "../../dao/gerarProtocolo.php";

session_start();
if (empty($_SESSION['user'])) {

    header('location: ../../view/cliente/login.php');
}

if (isset($_POST['salvaManicure'])) {

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

            'tpservico' => 'Manicure',
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
            <p>Manicure e Pedicure</p>

        </div>


        <form action="" method="post">

            <div id="form-row">


                <!--***************************************************************************** --->
                <div id="pergunta01">

                    <div class="row g-5">
                        <div class="col">
                            <label class="fs-3">Qual servi??o voc?? procura?</label>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Alongamento de unhas" name="categoria[]" id="Alongamentodeunhas" title="">
                                <label class="form-check-label" for="Alongamentodeunhas" title="">
                                    Alongamento de unhas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Manicure" name="categoria[]" id="Manicure" title="">
                                <label class="form-check-label" for="Manicure" title="">
                                    Manicure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Manuten????o de alongamento" name="categoria[]" id="Manuten????odealongamento" title="">
                                <label class="form-check-label" for="Manuten????odealongamento" title="">
                                    Manuten????o de alongamento
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Pedicure" name="categoria[]" id="Pedicure" title="">
                                <label class="form-check-label" for="Pedicure" title="">
                                    Pedicure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Spa dos p??s" name="categoria[]" id="Spadosp??s" title="">
                                <label class="form-check-label" for="Spadosp??s" title="">
                                    Spa dos p??s
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Remo????o de calosidade" name="categoria[]" id="Remo????odecalosidade" title="">
                                <label class="form-check-label" for="Remo????odecalosidade" title="">
                                    Remo????o de calosidade
                                </label>
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
                    <div class="row g-12 ms-3 p-2">
                        <label class="fs-3">Onde voc?? gostaria de ser atendido?</label>
                        <br><br>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Em casa" name="descricao[]" id="Emcasa" title="">
                            <label class="form-check-label" for="Emcasa" title="">
                                Em casa
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Em um sal??o de beleza" name="descricao[]" id="Emumsal??odebeleza" title="">
                            <label class="form-check-label" for="Emumsal??odebeleza" title="">
                                Em um sal??o de beleza
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Sem prefer??ncia" name="descricao[]" id="Semprefer??ncia" title="">
                            <label class="form-check-label" for="Semprefer??ncia" title="">
                                Sem prefer??ncia
                            </label>
                        </div>

                    </div>


                    <div class="row" style="margin-top: 20px;">
                        <div class="col text-center">
                            <button id='botaoEnviar' type="button" id="volta01" onclick="voltando02()" class="btn azulprima btn-lg">VOLTAR</button>
                        </div>
                        <div class="col text-center">
                            <input id='botaoEnviar' type="submit" name="salvaManicure" value="FINALIZAR" class="btn orangered btn-lg">
                        </div>
                    </div>
                </div>
                <!--***************************************************************************** --->
            </div>
        </form>
    </div>

    <div class="container" id="registro_logo">
        <img id='photo' src="../../images/manicure.gif" class="img">
    </div>


</div>

<script>
    document.getElementById('pergunta02').style.display = 'none';

    function avan??ando01() {

        var check01 = document.getElementById('Alongamentodeunhas');
        var check02 = document.getElementById('Manicure');
        var check03 = document.getElementById('Manuten????odealongamento');

        var check04 = document.getElementById('Pedicure');
        var check05 = document.getElementById('Spadosp??s');
        var check06 = document.getElementById('Remo????odecalosidade');


        if (check01.checked || check02.checked || check03.checked || check04.checked || check05.checked || check06.checked) {

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