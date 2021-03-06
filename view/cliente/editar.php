<?php
session_start();

if (empty($_SESSION['user'])) {


    header('location: ../../view/cliente/login.php');
}



include_once "../../layout/heard.php";
include_once  "../../class/ClassCliente.php";
include_once "../../dao/ClienteDAO.php";

$ClassCLiente = new Cliente();
$ClassCLiente->SetId($_SESSION['user']['id']);

$Cliente = new ClienteDAO();
$dados = $Cliente->listarCliente($ClassCLiente);


if (isset($_POST['salvarCliente'])) {


    if (!empty($_POST['nome'])  and !empty($_POST['cpf']) and !empty($_POST['cep']) and !empty($_POST['telefone']) and !empty($_POST['email'])) {

        if ($_POST['senha'] === $_POST['confirmar']) {


            if (isset($_FILES['imagem']['name'])) {
                $imagem = $_FILES['imagem']['name'];
                $diretorio = '../../images/';
                //$diretorioPDF = '../pdf/';
                move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $imagem);
            }

            $ClassCliente = new Cliente();
            $ClassCliente->SetId($_POST['id']);
            $ClassCliente->SetFoto($imagem);
            @$ClassCliente->SetOpcao($_POST['opt']);
            $ClassCliente->SetRazao($_POST['razao']);
            $ClassCliente->SetNome($_POST['nome']);
            $ClassCliente->SetSenha($_POST['senha']);
            $ClassCliente->SetCpf($_POST['cpf']);
            $ClassCliente->SetCep($_POST['cep']);
            $ClassCliente->SetUf($_POST['uf']);
            $ClassCliente->SetCidade($_POST['cidade']);
            $ClassCliente->SetLogradouro($_POST['logradouro']);
            $ClassCliente->SetNumero($_POST['numerp']);
            $ClassCliente->SetBairro($_POST['bairro']);
            $ClassCliente->SetComplemento($_POST['complemento']);
            $ClassCliente->SetTelefone($_POST['telefone']);
            $ClassCliente->SetEmail($_POST['email']);

            $ClassCliente->SetSexo($_POST['sexo']);
            $ClassCliente->SetNascimento($_POST['data_nascimento']);
            if(!empty($_POST['termo'])){
                $ClassCliente->SetTermo($_POST['termo']);
            }


       


            $Cliente = new ClienteDAO();
            $Cliente->editarCliente($ClassCliente);
        }
    } else {
?>

        <script>
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Preencha Todos os Campos',
                showConfirmButton: false,
                timer: 3500
            })
        </script>


<?php

    }
}

?>
<link href="../../layout/css/cliente_registro.css" rel="stylesheet">
<div class="container-fluid">
    <div class="container" id="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="text-center">
                <a href="https://gotoservice.com.br/"><img src="../../images/primazia.png" alt="" width="250" height="190"></a>
            </div>

            <div class="title text-center">
                <p>EDITAR PERFIL</p>
            </div>


            <div id="form-row">
                <div class="row" style="padding: 40px;">
                    <div class="text-center">
                        <div class="mb-3">
                            <?php
                            if (!empty($dados['foto'])) {

                            ?>
                                <label for="formFile" class="form-label"><img id="editarusuario" src="../../images/<?php echo $dados['foto']; ?>" class="img" width="150" style="border-radius: 50%;"></label>
                                <input class="form-control" type="file" name="imagem" value="<?php echo $dados['foto'] ?>" id="formFile" style="display:none" accept=".png, .jpg, .jpeg" >

                            <?php
                            } else {
                            ?>

                                <label for="formFile" class="form-label"><img id="editarusuario" src="../../images/usuario.png" class="img" width="150" style="border-radius: 50%;"></label>
                                <input class="form-control" type="file" name="imagem" id="formFile" style="display:none" accept=".png, .jpg, .jpeg" >

                            <?php
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <?php

                if ($dados['razao'] === 'F') {

                ?>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="pessoa form-check-input" type="radio" name="opt" id="j" onclick="juridica()" value="J" CHECKED disabled>
                            <label class="form-check-label" for="pessoa" id="j">
                            Pessoa Jur??dica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="pessoa form-check-input" type="radio" name="opt" id="f" onclick="fisica()" value="F" disabled>
                            <label class="form-check-label" for="pessoa" id="f">
                            Pessoa F??sica
                            </label>
                        </div>
                    </div>


                <?php

                } else {


                ?>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="pessoa form-check-input" type="radio" name="opt" id="j" onclick="juridica()" value="J" disabled>
                            <label class="form-check-label" for="pessoa" id="j">
                            Pessoa Jur??dica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="pessoa form-check-input" type="radio" name="opt" id="f" onclick="fisica()" value="F" CHECKED disabled>
                            <label class="form-check-label" for="pessoa" id="f">
                            Pessoa F??sica
                            </label>
                        </div>
                    </div>


                <?php

                }

                ?>

                <div id="Pfisica">

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label>Raz??o Social<span style="color: red;">*</span></label>
                            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                            <input type="text" name="razao" value="<?php echo $dados['razao']; ?>" id="razao" class="form-control form-control-sm" aria-label="Nome de Usu??rio">
                        </div>
                        <div class="col-md-6">
                            <label>Inscri????o Estadual<span style="color: red;">*</span></label>
                            <input type="text" name="Inscri????o Estadual" id="estadual" class="form-control form-control-sm cpf-mask" >
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>Nome de Usu??rio<span style="color: red;">*</span></label>
                        <input type="text" name="nome" id="nome" value="<?php echo $dados['nome']; ?>" class="form-control form-control-sm"  aria-label="Nome de Usu??rio">
                    </div>
                    <div class="col-md-6">
                        <label>CPF/CNPJ<span style="color: red;">*</span></label>
                        <input type="text" name="cpf" id="cpf" value="<?php echo $dados['cpf']; ?>" class="form-control form-control-sm cpf-mask" onkeypress="return somenteNumeros(event)" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" readonly>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                    <label>Alterar Senha<span style="color: red;">*</span></label>
                        <input type="password" name="senha" id="senha" class="form-control form-control-sm"  aria-label="">
                    </div>
                    <div class="col-md-6">
                    <label>Confirme sua senha<span style="color: red;">*</span></label>
                        <input type="password" name="confirmar" id="confirmar" class="form-control form-control-sm cpf-mask" >
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>Data de Nascimento<span style="color: red;">*</span></label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $dados['nascimento'];?>" class="form-control form-control-sm"  aria-label="Data de Nascimento">
                    </div>
                    <div class="col-md-6">
                    <label>G??nero<span style="color: red;">*</span></label>
                        <select class="form-select form-select-sm" name="sexo" id="sexo">
                        
                        <option  <?php echo $dados['sexo'] =='masculino'?'selected':'' ; ?> value="masculino" >Masculino</option>
                        <option  <?php echo $dados['sexo'] =='feminino'?'selected':'' ; ?> value="feminino">Feminino</option>
                        <option  <?php echo $dados['sexo'] =='outros'?'selected':'' ; ?> value="outros">Outros</option>
                        </select>
                    </div>
                </div>



                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>CEP<span style="color: red;">*</span></label>
                        <input type="text" maxlength="9" name="cep" id="cep" value="<?php echo $dados['cep']; ?>" class="form-control form-control-sm"  onkeypress="$(this).mask('00.000-000')">
                    </div>
                    <div class="col-md-6">
                        <label>Endere??o<span style="color: red;">*</span></label>
                        <input type="text" name="logradouro" id="rua" value="<?php echo $dados['rua']; ?>" class="form-control form-control-sm" >
                    </div>
                    <div class="col-md-3">
                        <label>N??<span style="color: red;">*</span></label>
                        <input type="text" name="numerp" id="numero" value="<?php echo $dados['numero']; ?>" class="form-control form-control-sm" >
                    </div>
                    <div class="col-md-3">
                        <label>UF<span style="color: red;">*</span></label>
                        <input type="text" name="uf" id="uf" value="<?php echo $dados['uf']; ?>" class="form-control form-control-sm" >
                    </div>
                    <div class="col-md-6">
                    <label>Cidade<span style="color: red;">*</span></label>
                        <input type="text" name="cidade" id="cidade" value="<?php echo $dados['cidade']; ?>" class="form-control form-control-sm " >
                    </div>
                    <div class="col-md-6">
                    <label>Bairro<span style="color: red;">*</span></label>
                        <input type="text" name="bairro" value="<?php echo $dados['bairro']; ?>" id="bairro" class="form-control form-control-sm " >
                    </div>

                    <div class="col-md-6">
                    <label>Complemento<span style="color: red;">*</span></label>
                        <input type="text" name="complemento" id="complemento" value="<?php echo $dados['complemento']; ?>" class="form-control form-control-sm" >
                    </div>
                    <div class="col-md-6">
                    <label>Telefone<span style="color: red;">*</span></label>
                        <input type="text" name="telefone" id="telefone" value="<?php echo $dados['telefone']; ?>" class="form-control form-control-sm phone-ddd-mask"  onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                    </div>
                    <div class="col-md-6">
                    <label>E-mail<span style="color: red;">*</span></label>
                        <input type="email" name="email" id="email" value="<?php echo $dados['email']; ?>" class="form-control form-control-sm"  aria-label="E-mail" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-check-label" for="">
                        Eu li e concordo com os <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" >termos</a>  de uso
                        </label>
                        <input class="form-check-input" name="termo" type="checkbox" <?php echo $dados['termo']== 'on'? 'checked':''  ?> id="flexCheckDefault">
                    </div>
                </div>

                <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Termo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                <div class="text-center" style="margin-bottom: 50px;">
                                    <h2><b>Pol??tica de Privacidade</b></h2>
                                </div>
                                <div style="margin-bottom: 50px;">
                                    <p>A sua privacidade ?? importante para n??s. ?? pol??tica do respeitar a sua privacidade em rela????o a qualquer informa????o sua que possamos coletar no site , e outros sites que possu??mos e operamos.</p>
                                    <p>Solicitamos informa????es pessoais apenas quando realmente precisamos delas para lhe fornecer um servi??o. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Tamb??m informamos por que estamos coletando e como ser?? usado.</p>
                                    <p>Apenas retemos as informa????es coletadas pelo tempo necess??rio para fornecer o servi??o solicitado. Quando armazenamos dados, protegemos dentro de meios comercialmente aceit??veis ??????para evitar perdas e roubos, bem como acesso, divulga????o, c??pia, uso ou modifica????o n??o autorizados.</p>
                                    <p>N??o compartilhamos informa????es de identifica????o pessoal publicamente ou com terceiros, exceto quando exigido por lei.</p>
                                    <p>O nosso site pode ter links para sites externos que n??o s??o operados por n??s. Esteja ciente de que n??o temos controle sobre o conte??do e pr??ticas desses sites e n??o podemos aceitar responsabilidade por suas respectivas pol??ticas de privacidade.</p>
                                    <p>Voc?? ?? livre para recusar a nossa solicita????o de informa????es pessoais, entendendo que talvez n??o possamos fornecer alguns dos servi??os desejados.</p>
                                    <p>O uso continuado de nosso site ser?? considerado como aceita????o de nossas pr??ticas em torno de privacidade e informa????es pessoais. Se voc?? tiver alguma d??vida sobre como lidamos com dados do usu??rio e informa????es pessoais, entre em contacto connosco.</p>

                                </div>

                                <div style="margin-bottom: 50px;">
                                    <h4 style="margin-bottom: 20px;"><b>Pol??tica de Cookies</b></h4>
                                    <h6><b>O que s??o cookies?</b></h6>
                                    <p>Como ?? pr??tica comum em quase todos os sites profissionais, este site usa cookies, que s??o pequenos arquivos baixados no seu computador, para melhorar sua experi??ncia. Esta p??gina descreve quais informa????es eles coletam, como as usamos e por que ??s vezes precisamos armazenar esses cookies. Tamb??m compartilharemos como voc?? pode impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o downgrade ou ???quebrar??? certos elementos da funcionalidade do site.</p>
                                   
                                    <h6><b>Como usamos os cookies?</b></h6>
                                    <p>Utilizamos cookies por v??rios motivos, detalhados abaixo. Infelizmente, na maioria dos casos, n??o existem op????es padr??o do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles adicionam a este site. ?? recomend??vel que voc?? deixe todos os cookies se n??o tiver certeza se precisa ou n??o deles, caso sejam usados ??????para fornecer um servi??o que voc?? usa.</p>
                                    <h6><b>Cookies que definimos</b></h6>

                                    <p>
                                        <li>Cookies relacionados ?? conta</li>
                                    </p>
                                    <p>Se voc?? criar uma conta connosco, usaremos cookies para o gerenciamento do processo de inscri????o e administra????o geral. Esses cookies geralmente ser??o exclu??dos quando voc?? sair do sistema, por??m, em alguns casos, eles poder??o permanecer posteriormente para lembrar as prefer??ncias do seu site ao sair.</p>

                                    <p>
                                        <li>Cookies relacionados ao login</li>
                                    </p>
                                    <p>Utilizamos cookies quando voc?? est?? logado, para que possamos lembrar dessa a????o. Isso evita que voc?? precise fazer login sempre que visitar uma nova p??gina. Esses cookies s??o normalmente removidos ou limpos quando voc?? efetua logout para garantir que voc?? possa acessar apenas a recursos e ??reas restritas ao efetuar login.</p>

                                    <p>
                                        <li>Cookies relacionados a boletins por e-mail</li>
                                    </p>
                                    <p>Este site oferece servi??os de assinatura de boletim informativo ou e-mail e os cookies podem ser usados ??????para lembrar se voc?? j?? est?? registrado e se deve mostrar determinadas notifica????es v??lidas apenas para usu??rios inscritos / n??o inscritos.</p>

                                    <p>
                                        <li>Pedidos processando cookies relacionados</li>
                                    </p>
                                    <p>Este site oferece facilidades de com??rcio eletr??nico ou pagamento e alguns cookies s??o essenciais para garantir que seu pedido seja lembrado entre as p??ginas, para que possamos process??-lo adequadamente.</p>


                                    <p>
                                        <li>Cookies relacionados a formul??rios</li>
                                    </p>
                                    <p>Quando voc?? envia dados por meio de um formul??rio como os encontrados nas p??ginas de contacto ou nos formul??rios de coment??rios, os cookies podem ser configurados para lembrar os detalhes do usu??rio para correspond??ncia futura.</p>

                                    <p>
                                        <li>Cookies de prefer??ncias do site</li>
                                    </p>
                                    <p>Para proporcionar uma ??tima experi??ncia neste site, fornecemos a funcionalidade para definir suas prefer??ncias de como esse site ?? executado quando voc?? o usa. Para lembrar suas prefer??ncias, precisamos definir cookies para que essas informa????es possam ser chamadas sempre que voc?? interagir com uma p??gina for afetada por suas prefer??ncias.</p>

                                </div>

                                <div style="margin-bottom: 50px;">
                                    <h4><b>Cookies de Terceiros</b></h4>
                                    <p>Em alguns casos especiais, tamb??m usamos cookies fornecidos por terceiros confi??veis. A se????o a seguir detalha quais cookies de terceiros voc?? pode encontrar atrav??s deste site.</p>
                                    <p>
                                        <li>Este site usa o Google Analytics, que ?? uma das solu????es de an??lise mais difundidas e confi??veis ??????da Web, para nos ajudar a entender como voc?? usa o site e como podemos melhorar sua experi??ncia. Esses cookies podem rastrear itens como quanto tempo voc?? gasta no site e as p??ginas visitadas, para que possamos continuar produzindo conte??do atraente.</li>
                                    </p>
                                    <p>Para mais informa????es sobre cookies do Google Analytics, consulte a p??gina oficial do Google Analytics.</p>
                                    <p>
                                        <li>As an??lises de terceiros s??o usadas para rastrear e medir o uso deste site, para que possamos continuar produzindo conte??do atrativo. Esses cookies podem rastrear itens como o tempo que voc?? passa no site ou as p??ginas visitadas, o que nos ajuda a entender como podemos melhorar o site para voc??.</li>
                                    </p>
                                    <p>
                                        <li>Periodicamente, testamos novos recursos e fazemos altera????es subtis na maneira como o site se apresenta. Quando ainda estamos testando novos recursos, esses cookies podem ser usados ??????para garantir que voc?? receba uma experi??ncia consistente enquanto estiver no site, enquanto entendemos quais otimiza????es os nossos usu??rios mais apreciam.</li>
                                    </p>
                                    <p>
                                        <li>?? medida que vendemos produtos, ?? importante entendermos as estat??sticas sobre quantos visitantes de nosso site realmente compram e, portanto, esse ?? o tipo de dados que esses cookies rastrear??o. Isso ?? importante para voc??, pois significa que podemos fazer previs??es de neg??cios com precis??o que nos permitem analizar nossos custos de publicidade e produtos para garantir o melhor pre??o poss??vel.</li>
                                    </p>

                                </div>

                                <div>
                                    <h4><b>Compromisso do Usu??rio</b></h4>
                                    <p>O usu??rio se compromete a fazer uso adequado dos conte??dos e da informa????o que o oferece no site e com car??ter enunciativo, mas n??o limitativo:</p>
                                    <p>
                                        <li>A) N??o se envolver em atividades que sejam ilegais ou contr??rias ?? boa f?? a ?? ordem p??blica;</li>
                                    </p>
                                    <p>
                                        <li>B) N??o difundir propaganda ou conte??do de natureza racista, xenof??bica, ou salmao, casas de apostas (ex.: Betway), jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;</li>
                                    </p>
                                    <p>
                                        <li>C) N??o causar danos aos sistemas f??sicos (hardwares) e l??gicos (softwares) do , de seus fornecedores ou terceiros, para introduzir ou disseminar v??rus inform??ticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.</li>
                                    </p>

                                </div>

                            </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                   


                <div class="row">

                    <div class="d-grid gap-2 col-3 mx-auto mt-5">
                        <button type="submit" name="salvarCliente" class="btn btn-lg orangered">SALVAR</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container" id="registro_logo">
        <img src="../../images/cliente.gif">
    </div>


</div>

<script>
    $(document).ready(function() {

        if (document.getElementById("j").checked) {

            var Pfisica = document.getElementById('Pfisica').style.display = "block";

        } else {
            var Pfisica = document.getElementById('Pfisica').style.display = "none";
        }



    });

    function juridica() {

        var Pfisica = document.getElementById('Pfisica').style.display = "block";


    }

    function fisica() {

        var Pfisica = document.getElementById('Pfisica').style.display = "none";


    }
</script>



<script>
    function formatarCampo(campoTexto) {
        if (campoTexto.value.length <= 11) {
            campoTexto.value = mascaraCpf(campoTexto.value);
        } else {
            campoTexto.value = mascaraCnpj(campoTexto.value);
        }
    }

    function retirarFormatacao(campoTexto) {
        campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g, "");
    }

    function mascaraCpf(valor) {
        return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
    }

    function somenteNumeros(e) {
        var charCode = e.charCode ? e.charCode : e.keyCode;
        // charCode 8 = backspace   
        // charCode 9 = tab
        if (charCode != 8 && charCode != 9) {
            // charCode 48 equivale a 0   
            // charCode 57 equivale a 9
            if (charCode < 48 || charCode > 57) {
                return false;
            }
        }
    }
</script>

<script>
    $('#editarusuario').click(function() {
        formFile.executar();
    });

    $('#formFile').change(function() {

        const file = $(this)[0].files[0];
        const fileReader = new FileReader()
        fileReader.onloadend = function() {
            $('#editarusuario').attr('src', fileReader.result)
        }
        fileReader.readAsDataURL(file)
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<?php
include_once "../../layout/footer.php";
?>