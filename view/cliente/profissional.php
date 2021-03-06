<?php
include_once "../../layout/heard.php";

include_once  "../../class/ClassProfissional.php";
include_once "../../dao/ProfissionalDAO.php";
session_start();
if (empty($_SESSION['user'])) {

   
    header('location: ../../view/cliente/login.php');
}


if (isset($_POST['salvarProfissional'])) {


    if (!empty($_POST['nome']) and !empty($_POST['senha']) and !empty($_POST['cpf']) and !empty($_POST['cep']) and !empty($_POST['telefone']) and !empty($_POST['email'])) {

        if ($_POST['senha'] === $_POST['confirmar']) {


            if (isset($_FILES['imagem']['name'])) {
                $imagem = $_FILES['imagem']['name'];
                $diretorio = '../../images/';
                //$diretorioPDF = '../pdf/';
                move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $imagem);
            }

            $ClassProfissional = new Profissional();
            $ClassProfissional->SetFoto($imagem);
            $ClassProfissional->SetOpcao($_POST['opt']);
            $ClassProfissional->SetRazao($_POST['razao']);
            $ClassProfissional->SetNome($_POST['nome']);
            $ClassProfissional->SetSenha($_POST['senha']);
            $ClassProfissional->SetCpf($_POST['cpf']);
            $ClassProfissional->SetCep($_POST['cep']);
            $ClassProfissional->SetUf($_POST['uf']);
            $ClassProfissional->SetCidade($_POST['cidade']);
            $ClassProfissional->SetLogradouro($_POST['logradouro']);
            $ClassProfissional->SetNumero($_POST['numerp']);
            $ClassProfissional->SetBairro($_POST['bairro']);
            $ClassProfissional->SetComplemento($_POST['complemento']);
            $ClassProfissional->SetTelefone($_POST['telefone']);
            $ClassProfissional->SetEmail($_POST['email']);
            $ClassProfissional->SetServico($_POST['servico']);

            $ClassProfissional->SetSexo($_POST['sexo']);
            $ClassProfissional->SetNascimento($_POST['data_nascimento']);
            $ClassProfissional->SetTermo($_POST['termo']);

            $subcategoria = $_POST['categoria'];

            $Profissional = new ProfissionalDAO();
            $Profissional->insertProfissional($ClassProfissional, $subcategoria);

            
        } else {

?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Senhas N??o Coincidem',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>


        <?php

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
<link href="../../layout/css/profissional_registro.css" rel="stylesheet">
<div class="container-fluid">
    <div class="container" id="registro">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="text-center">
                <a href="https://gotoservice.com.br/"><img src="../../images/primazia.png" alt="" width="250" height="190"></a>
            </div>

            <div class="title text-center">
                <p>REGISTRO PROFISSIONAL</p>
            </div>

            <div id="form-row">
                <div class="row" style="padding: 40px;">
                <div class="text-center">
                        <div class="mb-3">
                            <?php
                            if (!empty($_SESSION['user']['foto'])) {

                            ?>
                                <label for="formFile" class="form-label"><img id="editarusuario" src="../../images/<?php echo $_SESSION['user']['foto']; ?>" class="img" width="150" style="border-radius: 50%;"></label>
                                <input class="form-control" type="file" name="imagem" value="<?php echo $_SESSION['user']['foto'] ?>" id="formFile" style="display:none" accept=".png, .jpg, .jpeg" >

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
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="pessoa form-check-input" type="radio" name="opt" id="j" onclick="juridica()" value="J" <?php echo $_SESSION['user']['option'] =='J'?'checked':'' ;?>>
                        <label class="form-check-label" for="j" id="j">
                            Pessoa Juridica
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="pessoa form-check-input" type="radio" name="opt" id="f" onclick="fisica()" value="F" <?php echo $_SESSION['user']['option'] =='F'?'checked':'' ;?>>
                        <label class="form-check-label" for="f" id="f">
                            Pessoa Fisica
                        </label>
                    </div>
                </div>
                <div id="Pfisica">

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label>Raz??o Social<span style="color: red;">*</span></label>
                            <input type="text" name="razao" id="razao" class="form-control form-control-sm" aria-label="Nome de Usu??rio" >
                        </div>
                        <div class="col-md-6">
                            <label>Inscri????o Estadual</label>
                            <input type="text" name="Inscri????o Estadual" id="estadual" class="form-control form-control-sm cpf-mask">
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>Nome de Usu??rio <span style="color: red;">*</span></label>
                        <input type="text" name="nome" id="nome" class="form-control form-control-sm" aria-label="Nome de Usu??rio" value="<?php echo $_SESSION['user']['nome'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>CPF/CNPJ <span style="color: red;">*</span></label>
                        <input type="text" name="cpf" id="cpf" class="form-control form-control-sm cpf-mask" value="<?php echo $_SESSION['user']['cpf'] ?>" onkeypress="return somenteNumeros(event)" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>Senha <span style="color: red;">*</span></label>
                        <input type="password" minlength="6" name="senha" id="senha" class="form-control form-control-sm" aria-label="" required>
                    </div>
                    <div class="col-md-6">
                        <label>Confirme sua senha <span style="color: red;">*</span></label>
                        <input type="password" minlength="6" name="confirmar" id="confirmar" class="form-control form-control-sm cpf-mask" required>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>Data de Nascimento <span style="color: red;">*</span></label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $_SESSION['user']['nascimento'] ?>" class="form-control form-control-sm" aria-label="Data de Nascimento" required>
                    </div>
                    <div class="col-md-6">
                        <label>G??nero <span style="color: red;">*</span></label>
                        <select class="form-select form-select-sm" name="sexo" id="sexo" required>

                            <option <?php echo $_SESSION['user']['sexo'] =='masculino'?'selected':'' ;?> value="masculino">Masculino</option>
                            <option <?php echo $_SESSION['user']['sexo'] =='feminino'?'selected':'' ;?>  value="feminino">Feminino</option>
                            <option <?php echo $_SESSION['user']['sexo'] =='outros'?'selected':'' ;?>    value="outros">Outros</option>
                        </select>
                    </div>
                </div>


                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label>CEP <span style="color: red;">*</span></label>
                        <input type="text" maxlength="9" name="cep" id="cep" value="<?php echo $_SESSION['user']['cep'] ?>" class="form-control form-control-sm" onkeypress="$(this).mask('00.000-000')" required>
                    </div>
                    <div class="col-md-6">
                        <label>Endere??o <span style="color: red;">*</span></label>
                        <input type="text" name="logradouro" id="rua" class="form-control form-control-sm" value="<?php echo $_SESSION['user']['rua'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>N?? <span style="color: red;">*</span></label>
                        <input type="text" name="numerp" id="numero" class="form-control form-control-sm" value="<?php echo $_SESSION['user']['numero'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>UF <span style="color: red;">*</span></label>
                        <input type="text" name="uf" id="uf" class="form-control form-control-sm" value="<?php echo $_SESSION['user']['uf'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Cidade <span style="color: red;">*</span></label>
                        <input type="text" name="cidade" id="cidade" class="form-control form-control-sm " value="<?php echo $_SESSION['user']['cidade'] ?>" placeholder="Cidade" required>
                    </div>
                    <div class="col-md-6">
                        <label>Bairro <span style="color: red;">*</span></label>
                        <input type="text" name="bairro" id="bairro" class="form-control form-control-sm " value="<?php echo $_SESSION['user']['bairro'] ?>" placeholder="Bairro" required>
                    </div>

                    <div class="col-md-6">
                        <label>Complemento</label>
                        <input type="text" name="complemento" id="complemento" class="form-control form-control-sm " value="<?php echo $_SESSION['user']['complemento'] ?>" >
                    </div>
                    <div class="col-md-6">
                        <label>Telefone <span style="color: red;">*</span></label>
                        <input type="text" name="telefone" id="telefone" class="form-control form-control-sm phone-ddd-mask" value="<?php echo $_SESSION['user']['telefone'];?>" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);"require>
                    </div>
                    <div class="col-md-6">
                        <label>E-mail<span style="color: red;">*</span></label>
                        <input type="email"  class="form-control form-control-sm" aria-label="E-mail" value="<?php echo $_SESSION['user']['email']; ?>" disabled>
                        <input type="hidden" name="email" id="email" class="form-control form-control-sm" aria-label="E-mail" value="<?php echo $_SESSION['user']['email']; ?>">
                    </div>

                    <div class="col-md-12">
                        <select class="form-select form-select-sm" name="servico" id="servico" onchange="change()" required>
                            <option selected>Tipo de Servi??o</option>
                            <option value="Art??fice (Eletricista,Pintor e Hidr??ulico)">Art??fice (Eletricista, Pintor e Hidr??ulico)</option>
                            <option value="Bab??">Bab??</option>
                            <option value="Cabeleireiro">Cabeleireiro</option>
                            <option value="Cuidador(a) de Pessoas">Cuidador(a) de Pessoas</option>
                            <option value="Dedetiza????o">Dedetiza????o</option>
                            <option value="Diarista">Diarista</option>
                            <option value="Lavanderia">Lavanderia</option>
                            <option value="Manuten????o de Ar Condicionado">Manuten????o de Ar Condicionado</option>
                            <option value="Motoboy">Motoboy</option>
                            <option value="Manicure e Pedicure">Manicure e Pedicure</option>
                        </select>
                    </div>
                    <div id="pergunta01">

                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px; font-family: inherit;">Selecione uma ou mais op????es:</samp>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Limpeza comercial" name="categoria[]" id="limpezaComercial" title="Limpeza padr??o do dia-a-dia voltada para salas comerciais.">
                                <label style="font-size:18px;" class="form-check-label" for="limpezaComercial" title="Limpeza padr??o do dia-a-dia voltada para salas comerciais.">
                                    Limpeza comercial
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Limpeza padr??o" name="categoria[]" id="limpezaPadrao" title="Limpeza padr??o do dia-a-dia, limpeza mais superficial, voltada para resid??ncias com ??reas entre 53m?? e 170m??. Resid??ncias do tipo loft, 01, 02 ou 03 quartos, varanda, 01,02 ou 03 banheiros.">
                                <label style="font-size:18px;" class="form-check-label" for="limpezaPadrao" title="Limpeza padr??o do dia-a-dia, limpeza mais superficial, voltada para resid??ncias com ??reas entre 53m?? e 170m??. Resid??ncias do tipo loft, 01, 02 ou 03 quartos, varanda, 01,02 ou 03 banheiros.">
                                    Limpeza padr??o
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Limpeza pesada" name="categoria[]" id="limpezaPesada" title="Limpeza mais pesada, inclui limpeza embaixo dos m??veis, limpeza de m??veis, lavagem de lou??as expostas, limpeza de eletrodom??sticos">
                                <label style="font-size:18px;" class="form-check-label" for="limpezaPesada" title="Limpeza mais pesada, inclui limpeza embaixo dos m??veis, limpeza de m??veis, lavagem de lou??as expostas, limpeza de eletrodom??sticos">
                                    Limpeza pesada
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Limpeza p??s obra" name="categoria[]" id="limpezaPosobra" title="Limpeza realizada para limpeza p??s pintura; Limpeza de res??duos de rejunte; retirada de entulhos p??s demoli????o.">
                                <label style="font-size:18px;" class="form-check-label" for="limpezaPosobra" title="Limpeza realizada para limpeza p??s pintura; Limpeza de res??duos de rejunte; retirada de entulhos p??s demoli????o.">
                                    Limpeza p??s obra
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Limpeza pr?? mudan??a" name="categoria[]" id="limpezaPremudanca" title="Limpeza geral p??s instala????o de m??veis e decora????o, deixando o ambiente limpo a mudan??a do cliente.">
                                <label style="font-size:18px;" class="form-check-label" for="limpezaPremudanca" title="Limpeza geral p??s instala????o de m??veis e decora????o, deixando o ambiente limpo a mudan??a do cliente.">
                                    Limpeza pr?? mudan??a
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="outros" title="Especifica????es Extras">
                                <label style="font-size:18px;" class="form-check-label" for="outros" title="Outros."> Outros
                                </label>
                                <div id="div_outros">
                                    <div class="mb-3">
                                        <label for="outros" class="form-label"></label>
                                        <textarea name="categoria[]" class="form-control" id="outros" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pergunta02">

                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Desintetiza????o" name="categoria[]" id="desintetizacao" title="">
                                <label style="font-size:18px;" class="form-check-label" for="desintetizacao" title="Combate e controle das diferentes infesta????es de pragas urbanas, tais como: Baratas, formiga, aranhas, moscas, gorgulhos de cereais, pulgas, carrapatos, insetos alados, pernilongos, tra??as e??caramujos.">
                                    Desintetiza????o
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Controle de Pragas" name="categoria[]" id="controleRoedores" title="Combate e controle de ratos.">
                                <label style="font-size:18px;" class="form-check-label" for="controleRoedores" title="">
                                    Controle de Pragas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Sanitiza????o" name="categoria[]" id="sanitizacao" title="Higieniza????o e desinfec????o de ambientes e superf??cies para preven????o de prolifera????o de v??rus.">
                                <label style="font-size:18px;" class="form-check-label" for="sanitizacao" title="">
                                    Sanitiza????o
                                </label>
                            </div>

                        </div>
                    </div>

                    <div id="pergunta03">
                        <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Instala????o" name="categoria[]" id="Instala????o" title="">
                            <label style="font-size:18px;" class="form-check-label" for="Instala????o" title="Instala????o de aparelhos splits e multisplits de diferentes BTU??s com infraestrutura pronta.">
                                Instala????o
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Limpeza" name="categoria[]" id="Limpeza" title="">
                            <label style="font-size:18px;" class="form-check-label" for="Limpeza" title="Lavagem de evaporadora e condensadora de aparelhos splits e multisplits de diferentes BTU??s">
                                Limpeza
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Recarga de g??s" name="categoria[]" id="Recarga de g??s" title="">
                            <label style="font-size:18px;" class="form-check-label" for="Recarga de g??s" title="Recarga de g??s refrigerante em aparelhos splits e multisplits de diferentes BTU??s.">
                                Recarga de g??s
                            </label>
                        </div>

                    </div>
                    <div id="pergunta04">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Lavagem ?? ??gua" name="categoria[]" id="lavagemAgua" title="Processo de limpeza dos tecidos atrav??s de a????o mec??nica, temperatura adequada e tempo preciso, em conjunto com o tratamento requerido.">
                                <label style="font-size:18px;" class="form-check-label" for="lavagemAgua" title="Processo de limpeza dos tecidos atrav??s de a????o mec??nica, temperatura adequada e tempo preciso, em conjunto com o tratamento requerido.">
                                    Lavagem ?? ??gua
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Lavagem a seco" name="categoria[]" id="lavagemSeco" title="A limpeza a seco ?? um processo usado em pe??as que n??o podem ser lavadas a ??gua, pois o tecido pode encolher, desbotar ou at?? mesmo perder a forma.">
                                <label style="font-size:18px;" class="form-check-label" for="lavagemSeco" title="A limpeza a seco ?? um processo usado em pe??as que n??o podem ser lavadas a ??gua, pois o tecido pode encolher, desbotar ou at?? mesmo perder a forma. ">
                                    Lavagem a seco
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Impermeabilizar" name="categoria[]" id="impermeabilizar" title="Ao impermeabilizar tecidos, eles se tornam menos porosos, formando uma esp??cie de camada protetora invis??vel e imperme??vel, que cobre o tecido e previne a incrusta????o das manchas ou mesmo as mol??culas de ??gua.">
                                <label style="font-size:18px;" class="form-check-label" for="impermeabilizar" title="Ao impermeabilizar tecidos, eles se tornam menos porosos, formando uma esp??cie de camada protetora invis??vel e imperme??vel, que cobre o tecido e previne a incrusta????o das manchas ou mesmo as mol??culas de ??gua.">
                                    Impermeabilizar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Revitalizar" name="categoria[]" id="revitalizar" title="revitaliza????o das cores do tecido, fazendo com que elas permane??am impec??veis em todas as circunst??ncias e mantenham a flexibilidade.">
                                <label style="font-size:18px;" class="form-check-label" for="revitalizar" title="revitaliza????o das cores do tecido, fazendo com que elas permane??am impec??veis em todas as circunst??ncias e mantenham a flexibilidade.">
                                    Revitalizar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Alvejar" id="alvejar" name="categoria[]" title="alvejamos suas pe??as brancas ou coloridas, sem adi????o de cloro e de forma altamente eficiente na remo????o de manchas, revitalizando a cor branca e recuperando as pe??as.">
                                <label style="font-size:18px;" class="form-check-label" for="alvejar" title="alvejamos suas pe??as brancas ou coloridas, sem adi????o de cloro e de forma altamente eficiente na remo????o de manchas, revitalizando a cor branca e recuperando as pe??as.">
                                    Alvejar
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Bolsas" name="categoria[]" id="bolsas" title="bolsas.">
                                <label style="font-size:18px;" class="form-check-label" for="bolsas" title="bolsas.">
                                    Bolsas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Sapatos" name="categoria[]" id="sapados" title="sapatos">
                                <label style="font-size:18px;" class="form-check-label" for="sapados" title="sapatos.">
                                    Sapatos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="outros3" title="Especifica????es Extras">
                                <label style="font-size:18px;" class="form-check-label" for="outros" title="Outros."> Outros
                                </label>
                                <div id="lista3">

                                    <div class="mb-3">
                                        <label class="form-label"></label>
                                        <textarea name="categoria[]" class="form-control" id="outros2" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pergunta05">

                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Enviar um documento" name="categoria[]" id="documento" title="Envio ou capta????o de documentos em diferentes locais da cidade com data e hora agendados.">
                                <label style="font-size:18px;" class="form-check-label" for="documento" title="Envio ou capta????o de documentos em diferentes locais da cidade com data e hora agendados.">
                                    Enviar um documento
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Enviar um pacote" name="categoria[]" id="servico" title="Envio e capta????o de pacotes em diferentes locais da cidade com data e hora agendados.">
                                <label style="font-size:18px;" class="form-check-label" for="servico" title="Envio e capta????o de pacotes em diferentes locais da cidade com data e hora agendados.">
                                    Enviar um pacote
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Servi??o de urg??ncia" name="categoria[]" id="urgencia" title="Servi??os realizados imediatamente ap??s o contato com o motoboy">
                                <label style="font-size:18px;" class="form-check-label" for="urgencia" title="Servi??os realizados imediatamente ap??s o contato com o motoboy">
                                    Servi??o de urg??ncia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="outros4" title="Especifica????es Extras">
                                <label style="font-size:18px;" class="form-check-label" for="outros" title="Outros."> Outros
                                </label>
                                <div id="lista4">

                                    <div class="mb-3">
                                        <label class="form-label"></label>
                                        <textarea name="categoria[]" class="form-control" id="outros4" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="pergunta06">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="hidraulica" name="categoria[]" id="hidraulica" title="Servi??os de instala????o e limpeza de torneiras, chuveiros, duchas, bebedouros; desentupimento de ralos e sif??es; reparos em vazamentos.">
                                <label style="font-size:18px;" class="form-check-label" for="hidraulica" title="Servi??os de instala????o e limpeza de torneiras, chuveiros, duchas, bebedouros; desentupimento de ralos e sif??es; reparos em vazamentos.">
                                    Hidr??ulica
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="eletrica" name="categoria[]" id="eletrica" title="Instala????o de lumin??rias; substitui????o de interruptores; instala????o de interruptor paralelo.">
                                <label style="font-size:18px;" class="form-check-label" for="eletrica" title="Instala????o de lumin??rias; substitui????o de interruptores; instala????o de interruptor paralelo.">
                                    El??trica
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="gesso" name="categoria[]" id="gesso" title="Instala????o de cortineiro; Rebaixo para ilumina????o indireta; Sancas.">
                                <label style="font-size:18px;" class="form-check-label" for="gesso" title="Instala????o de cortineiro; Rebaixo para ilumina????o indireta; Sancas.">
                                    Gesso
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="pintura" name="categoria[]" id="pintura" title="Emassamento; Pintura; Aplica????o de textura">
                                <label style="font-size:18px;" class="form-check-label" for="pintura" title="Emassamento; Pintura; Aplica????o de textura">
                                    Pintura
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="pedreiro" name="categoria[]" id="pedreiro" title="">
                                <label style="font-size:18px;" class="form-check-label" for="pedreiro" title="">
                                    Pedreiro
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="pergunta07">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1 crian??a" name="categoria[]" id="1crian??a" title="">
                                <label class="form-check-label" for="1crian??a" title="">
                                    1 crian??a
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="2 crian??as" name="categoria[]" id="2crian??a" title="">
                                <label class="form-check-label" for="2crian??a" title="">
                                    2 crian??as
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="3 crian??as " name="categoria[]" id="3crian??a" title="">
                                <label class="form-check-label" for="3crian??a" title="">
                                    3 crian??as
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="4 crian??as" name="categoria[]" id="4crian??a" title="">
                                <label class="form-check-label" for="4crian??a" title="">
                                    4 crian??as
                                </label>
                            </div>

                        </div>
                    </div>

                    <div id="pergunta08">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
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

                    <div id="pergunta09">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
                            <br><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Cauteriza????o" name="categoria[]" id="Cauteriza????o" title="">
                                <label class="form-check-label" for="Cauteriza????o" title="">
                                    Cauteriza????o
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Colora????o" name="categoria[]" id="Colora????o" title="">
                                <label class="form-check-label" for="Colora????o" title="">
                                    Colora????o
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Corte" name="categoria[]" id="Corte" title="">
                                <label class="form-check-label" for="Corte" title="">
                                    Corte
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Escova Progressiva ou Definitiva" name="categoria[]" id="EscovaProgressivaouDefinitiva" title="">
                                <label class="form-check-label" for="EscovaProgressivaouDefinitiva" title="">
                                    Escova Progressiva ou Definitiva
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Escova, babyliss ou chapinha" name="categoria[]" id="Escovababylissouchapinha" title="">
                                <label class="form-check-label" for="Escovababylissouchapinha" title="">
                                    Escova, babyliss ou chapinha
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Hidrata????o, Nutri????o ou Reconstru????o" name="categoria[]" id="Hidrata????oNutri????oouReconstru????o" title="">
                                <label class="form-check-label" for="Hidrata????oNutri????oouReconstru????o" title="">
                                    Hidrata????o, Nutri????o ou Reconstru????o
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Luzes ou Mechas" name="categoria[]" id="LuzesouMechas" title="">
                                <label class="form-check-label" for="LuzesouMechas" title="">
                                    Luzes ou Mechas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Penteado" name="categoria[]" id="Penteado" title="">
                                <label class="form-check-label" for="Penteado" title="">
                                    Penteado
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="Outros1" title="">
                                <label class="form-check-label" for="Outros1" title="">
                                    Outros
                                </label>
                                <div id="lista1">

                                    <div class="mb-3">
                                        <label for="outros" class="form-label"></label>
                                        <textarea name="categoria[]" class="form-control" id="" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="pergunta10">
                        <div class="row g-12 ms-3 p-2">
                            <samp style="color: red; font-size:20px;">Selecione uma ou mais op????es:</samp>
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
                                <input class="form-check-input" type="checkbox" value="Outros" name="categoria[]" id="Outros2" title="">
                                <label class="form-check-label" for="Outros2" title="">
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
                    </div>
                    <div class="col-md-6">

                        <label class="form-check-label" for="">
                            Eu li e concordo com os <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">termos</a> de uso
                        </label>
                        <input class="form-check-input" name="termo" type="checkbox" id="flexCheckDefault" required>
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
                            <button type="submit" name="salvarProfissional" class="btn btn-lg orangered">CADASTRAR</button>
                        </div>
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
        $("#div_outros").hide();
        $("#lista").hide();
        $("#lista3").hide();
        $("#lista4").hide();

        $("#pergunta01").hide();
        $('#pergunta02').hide();
        $('#pergunta03').hide();
        $('#pergunta04').hide();
        $('#pergunta05').hide();
        $('#pergunta06').hide();
        $('#pergunta07').hide();
        $('#pergunta08').hide();
        $('#pergunta09').hide();
        $('#pergunta10').hide();

        $('#lista1').hide();
        $('#lista2').hide();
    });

    $('#Outros1').click(function() {

        if (document.getElementById('Outros1').checked) {

            $('#lista1').show();

        } else {
            $('#lista1').hide();

        }

    });

    $('#Outros2').click(function() {

        if (document.getElementById('Outros2').checked) {

            $('#lista2').show();

        } else {
            $('#lista2').hide();

        }

    });

    function change() {
        var select = document.getElementById('servico');
        var value = select.options[select.selectedIndex].value;


        if (value === 'Diarista') {

            $("#pergunta01").show();
        } else {
            $("#pergunta01").hide();
        }
        if (value === 'Dedetiza????o') {
            $("#pergunta02").show();
        } else {
            $("#pergunta02").hide();
        }
        if (value === 'Manuten????o de Ar Condicionado') {
            $("#pergunta03").show();
        } else {
            $("#pergunta03").hide();
        }
        if (value === 'Lavanderia') {
            $('#pergunta04').show();
        } else {
            $('#pergunta04').hide();
        }
        if (value === 'Motoboy') {
            $('#pergunta05').show();
        } else {
            $('#pergunta05').hide();
        }

        if (value === 'Art??fice (Eletricista,Pintor e Hidr??ulico)') {
            $('#pergunta06').show();
        } else {
            $('#pergunta06').hide();
        }


        if (value === 'Bab??') {
            $('#pergunta07').show();
        } else {
            $('#pergunta07').hide();
        }

        if (value === 'Manicure e Pedicure') {
            $('#pergunta08').show();
        } else {
            $('#pergunta08').hide();
        }

        if (value === 'Cabeleireiro') {
            $('#pergunta09').show();
        } else {
            $('#pergunta09').hide();
        }

        if (value === 'Cuidador(a) de Pessoas') {
            $('#pergunta10').show();
        } else {
            $('#pergunta10').hide();
        }


    }



    $('#outros').click(function() {

        var outros = document.getElementById('outros');

        if (outros.checked) {

            $("#div_outros").show();

        } else {


            $("#div_outros").hide();

        }

    });

    $('#outros2').click(function() {

        var outros = document.getElementById('outros2');

        if (outros.checked) {

            $("#lista").show();

        } else {


            $("#lista").hide();

        }

    });

    $('#outros3').click(function() {

        var outros = document.getElementById('outros3');

        if (outros.checked) {

            $("#lista3").show();

        } else {


            $("#lista3").hide();

        }

    });

    $('#outros4').click(function() {

        var outros = document.getElementById('outros4');

        if (outros.checked) {

            $("#lista4").show();

        } else {


            $("#lista4").hide();

        }

    });
</script>

<script>

    $(document).ready(function(){
        if (document.getElementById('j').checked) {
            document.getElementById('Pfisica').style.display = "block"

            var razao = document.getElementById('razao')
                razao.required = true;



        } else {

            document.getElementById('Pfisica').style.display = "none"
            var razao = document.getElementById('razao')
                razao.required = false;
            
            var razao = document.getElementById('estadual')
            razao.required = false;
        }
    });


    function juridica() {

        var Pfisica = document.getElementById('Pfisica').style.display = "block";
        var razao = document.getElementById('razao') 
            razao.required = true;
    }

    function fisica() {

        var Pfisica = document.getElementById('Pfisica').style.display = "none";
        var razao = document.getElementById('razao')
                razao.required = false;


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