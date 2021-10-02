<?php
include_once "../../layout/heard.php";
include_once "../../class/ClassAdmin.php";
include_once "../../dao/AdminDAO.php";
include_once "../../class/ClassCliente.php";
include_once "../../dao/ClienteDAO.php";
include "../../class/ClassProfissional.php";
require_once "../../dao/ProfissionalDAO.php";

session_start();

if (empty($_SESSION['admin'])) {

    header('Refresh: 0.0; url=login.php');
}

?>
<link href="../../layout/css/admin_painel2.css" rel="stylesheet">
<div id="logo">
    <a href="https://primazia.agenciaprogride.com.br/"><img src="../../images/primazia.png" alt="" width="250" height="190"></a>
</div>

<div class="container">

    <div class="row ms-3 p-2">
        <div class="col-md-5 ">
            <label for="basic-url" class="form-label">Selecione uma opção para editar</label>
            <select class="form-select form-select-sm" id="opcao" aria-label="Default select example" onchange="edit()">
                <option selected value="1">Administrador</option>
                <option value="2">Profissional</option>
                <option value="3">Cliente</option>
            </select><br>
        </div>
    </div>

    <div id="editarAdministrador">

        <?php



        if (isset($_POST['editar_admin'])) {

            if ($_POST['admsenha'] === $_POST['admconfirmar']) {


                $ClassAdmin = new Admin();
                $ClassAdmin->SetId($_POST['admid']);
                $ClassAdmin->SetNome($_POST['admnome']);
                $ClassAdmin->SetCpf($_POST['admcpf']);
                if (!empty($_POST['admsenha'])) {

                    $ClassAdmin->SetSenha($_POST['admsenha']);
                }
                $ClassAdmin->SetEmail($_POST['admemail']);
                $ClassAdmin->SetTelefone($_POST['admtel']);

                $Admin = new AdminDAO();
                $Admin->updateAdmin($ClassAdmin);
            } else {

        ?>


                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Erro',
                        text: 'Senha divergente',
                        showConfirmButton: false,
                        timer: 3500
                    })
                </script>

            <?php
            }
        }



        if (isset($_POST['editar_admin_profissional'])) {

            if ($_POST['senha'] === $_POST['confirmar']) {

                $ClassProfissional = new Profissional();
                $ClassProfissional->SetId($_POST['admid']);
                $ClassProfissional->SetOpcao($_POST['opt']);
                $ClassProfissional->SetNome($_POST['nome']);
                $ClassProfissional->SetCpf($_POST['cpf']);
                $ClassProfissional->SetSenha($_POST['senha']);
                $ClassProfissional->SetCep($_POST['cep']);
                $ClassProfissional->SetLogradouro($_POST['logradouro']);
                $ClassProfissional->SetNumero($_POST['numerp']);
                $ClassProfissional->SetUf($_POST['uf']);
                $ClassProfissional->SetCidade($_POST['cidade']);
                $ClassProfissional->SetBairro($_POST['bairro']);
                $ClassProfissional->SetComplemento($_POST['complemento']);
                $ClassProfissional->SetTelefone($_POST['telefone']);
                $ClassProfissional->SetEmail($_POST['email']);
                $ClassProfissional->SetServico($_POST['servico']);
                $Profissional = new ProfissionalDAO();
                $Profissional->updateProfissionalModal($ClassProfissional);
            } else {
            ?>

                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Erro',
                        text: 'Senha divergente',
                        showConfirmButton: false,
                        timer: 3500
                    })
                </script>

        <?php
            }
        }


        if (isset($_POST['editarCliente'])) {

            if (isset($_POST['clisenha']) === isset($_POST['cliconfirmar'])) {

                $ClassCliente = new Cliente();
                $ClassCliente->SetID($_POST['cliID']);
                $ClassCliente->SetOpcao($_POST['cliopt']);
                $ClassCliente->SetRazao($_POST['clirazao']);
                //$ClassCliente->SetID($_POST['cliInscrição']);
                $ClassCliente->SetNome($_POST['clinome']);
                $ClassCliente->SetCpf($_POST['clicpf']);
                $ClassCliente->SetSenha($_POST['clisenha']);

                $ClassCliente->SetCep($_POST['clicep']);
                $ClassCliente->SetLogradouro($_POST['clilogradouro']);
                $ClassCliente->SetNumero($_POST['clinumer']);
                $ClassCliente->SetUf($_POST['cliuf']);
                $ClassCliente->SetCidade($_POST['clicidade']);
                $ClassCliente->SetBairro($_POST['clibairro']);
                $ClassCliente->SetComplemento($_POST['clicomplemento']);
                $ClassCliente->SetTelefone($_POST['clitelefone']);
                $ClassCliente->SetEmail($_POST['cliemail']);

                $ClienteDao = new ClienteDAO();
                $ClienteDao->updateCliente($ClassCliente);
            }
        }




        ?>

        <form method="POST">
            <div id="admin" class="row ms-3 p-2">

                <div class="col-md-3">
                    <label for="validationServer01" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="adm_name">

                </div>
                <div class="col-md-3">
                    <label for="validationServer01" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="adm_email">

                </div>
                <div class="col-md-4" style="margin-top: 31px;">
                    <input type="submit" name="filtror_adm" class="btn btn-secondary" value="Filtrar">

                </div>
        </form>

    </div>
    <br>

    <table class="table table-hover">
        <thead style="background-color: #e9781e; color:white; font-family: 'Montserrat', sans-serif">
            <tr>
                <th class="text-center" scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (isset($_POST['filtror_adm'])) {

                
                if(!empty($_POST['adm_name'])  or !empty($_POST['adm_email'])){
                    
                    $nome = $_POST['adm_name'];
                    $email = $_POST['adm_email'];

                    $Admin = new AdminDAO();
                    $dadosAdmin = $Admin->ListarAdminsFiltro($nome,$email);


                }else{
                    
                $Admin = new AdminDAO();
                $dadosAdmin = $Admin->ListarAdmins();
                }

            }else{
                
                $Admin = new AdminDAO();
                $dadosAdmin = $Admin->ListarAdmins();
            }

            foreach ($dadosAdmin as $dadosAdmin) {


            ?>

                <tr data-bs-toggle="modal" data-bs-target="#admin<?php echo $dadosAdmin['id']; ?>">
                    <td class="text-center" scope="col"><?php echo $dadosAdmin['nome']; ?></td>
                    <td scope="col"><?php echo $dadosAdmin['email']; ?></td>
                    <td scope="col"><?php echo $dadosAdmin['telefone']; ?></td>
                </tr>

                <div class="modal fade" id="admin<?php echo $dadosAdmin['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $dadosAdmin['nome']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <input type="hidden" name="admid" value="<?php echo $dadosAdmin['id']; ?>">
                                        <label for="floatingInput">Nome de Usuário</label>
                                        <input type="text" name="admnome" id="admnome" class="form-control form-control-sm" placeholder="Nome" aria-label="Nome do administrador" value="<?php echo $dadosAdmin['nome']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="floatingInput">CPF/CNPJ</label>
                                        <input type="text" name="admcpf" id="admcpf" class="form-control form-control-sm cpf-mask" value="<?php echo $dadosAdmin['cpf']; ?>" placeholder="CPF/CNPJ" onkeypress="return somenteNumeros(event)" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Senha</label>
                                        <input type="password" name="admsenha" id="admsenha" class="form-control form-control-sm" placeholder="Senha" aria-label="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Confirmar senha</label>
                                        <input type="password" name="admconfirmar" id="admconfirmar" class="form-control form-control-sm cpf-mask" placeholder="Confirmar senha">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Telefone</label>
                                        <input type="text" name="admtel" id="tel" class="form-control form-control-sm" value="<?php echo $dadosAdmin['telefone']; ?>" placeholder="Telefone" aria-label="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">E-mail</label>
                                        <input type="email" name="admemail" id="admemail" class="form-control form-control-sm" value="<?php echo $dadosAdmin['email']; ?>" placeholder="E-mail" aria-label="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" name="editar_admin" class="btn btn-primary" value="Editar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            <?php

            }

            ?>
        </tbody>
    </table>
</div>
<div id="editarProfissional">

    <?php

    $Profissional = new AdminDAO();
    $dadosProfissional = $Profissional->ListarProfissional();


    ?>

    <div id="profissional" class="row ms-3 p-2">
        <div class="col-md-3">
            <label for="validationServer01" class="form-label">Nome</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="profissinal_name">

        </div>
        <div class="col-md-3">
            <label for="validationServer01" class="form-label">E-mail</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="profissinal_email">

        </div>
        <div class="col-md-4" style="margin-top: 31px;">
            <input type="submit" name="filtror_profissional" class="btn btn-secondary" value="Filtrar">

        </div>

    </div>
    <br>

    <table class="table table-hover">
        <thead style="background-color: #e9781e; color:white; font-family: 'Montserrat', sans-serif">
            <tr>
                <th class="text-center" scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($dadosProfissional as $dadosProfissional) {



            ?>

                <tr data-bs-toggle="modal" data-bs-target="#profissional<?php echo $dadosProfissional['id']; ?>">
                    <td class="text-center" scope="col"><?php echo $dadosProfissional['nome']; ?></td>
                    <td scope="col"><?php echo $dadosProfissional['email']; ?></td>
                    <td scope="col"><?php echo $dadosProfissional['telefone']; ?></td>
                </tr>
                <div class="modal fade" id="profissional<?php echo $dadosProfissional['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $dadosProfissional['nome']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">


                                <form method="POST" id="editaProfissionalModal">

                                    <div class="mb-3">
                                        <input type="hidden" name="admid" value="<?php echo $dadosProfissional['id']; ?>">

                                    </div>

                                    <?php

                                    if ($dadosProfissional['opt'] === 'J') {

                                    ?>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="opt" id="j" onclick="juridica()" value="J" CHECKED>
                                                <label class="form-check-label" for="pessoa" id="j">
                                                    Pessoa Juridica
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="opt" id="f" onclick="fisica()" value="F">
                                                <label class="form-check-label" for="pessoa" id="f">
                                                    Pessoa Fisica
                                                </label>
                                            </div>
                                        </div>
                                        <div id="Pfisica">


                                            <div class="mb-3">
                                                <label for="floatingInput">Razão Social</label>
                                                <input type="text" name="razao" id="razao" class="form-control  form-control-sm" value="<?php echo $dadosProfissional['razao'] ?>" placeholder="Razão Social" aria-label="Nome de Usuário">
                                            </div>
                                            <div class="mb-3">
                                                <label for="floatingInput">Inscrição Estadual</label>
                                                <input type="text" name="Inscrição Estadual" id="estadual" class="form-control  form-control-sm cpf-mask" placeholder="Inscrição Estadual">
                                            </div>

                                        </div>


                                    <?php
                                    } else {

                                    ?>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="opt" id="j" onclick="juridica()" value="J">
                                                <label class="form-check-label" for="pessoa" id="j">
                                                    Pessoa Juridica
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="opt" id="f" onclick="fisica()" value="F" CHECKED>
                                                <label class="form-check-label" for="pessoa" id="f">
                                                    Pessoa Fisica
                                                </label>
                                            </div>
                                        </div>

                                    <?php


                                    }

                                    ?>

                                    <div class="mb-3">

                                        <label for="floatingInput">Nome de Usuário</label>
                                        <input type="text" name="nome" id="nome" value="<?php echo $dadosProfissional['nome'] ?>" class="form-control  form-control-sm" placeholder="Nome de Usuário" aria-label="Nome de Usuário">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">CPF/CNPJ</label>
                                        <input type="text" name="cpf" id="cpf" value="<?php echo $dadosProfissional['cpf'] ?>" class="form-control  form-control-sm cpf-mask" placeholder="CPF/CNPJ" onkeypress="return somenteNumeros(event)" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);">
                                    </div>



                                    <div class="mb-3">
                                        <label for="floatingInput">Senha</label>
                                        <input type="password" name="senha" id="senha" class="form-control  form-control-sm" placeholder="Senha" aria-label="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Confirmar senha</label>
                                        <input type="password" name="confirmar" id="confirmar" class="form-control  form-control-sm" placeholder="Confirmar senha">
                                    </div>

                                    <div class="mb-3">
                                        <label for="floatingInput">Cep</label>
                                        <input type="text" maxlength="9" name="cep" id="cep" value="<?php echo $dadosProfissional['cep'] ?>" class="form-control  form-control-sm" placeholder="CEP" onkeypress="$(this).mask('00.000-000')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Endereço</label>
                                        <input type="text" name="logradouro" id="rua" value="<?php echo $dadosProfissional['rua'] ?>" class="form-control  form-control-sm" placeholder="Endereço ">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Nº</label>
                                        <input type="text" name="numerp" id="numero" value="<?php echo $dadosProfissional['numero'] ?>" class="form-control  form-control-sm" placeholder="Nº ">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">UF</label>
                                        <input type="text" name="uf" id="uf" value="<?php echo $dadosProfissional['uf'] ?>" class="form-control  form-control-sm" placeholder="UF">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" value="<?php echo $dadosProfissional['cidade'] ?>" class="form-control  form-control-sm " placeholder="Cidade">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" value="<?php echo $dadosProfissional['bairro'] ?>" class="form-control  form-control-sm" placeholder="Bairro">
                                    </div>

                                    <div class="mb-3">
                                        <label for="floatingInput">Complemento</label>
                                        <input type="text" name="complemento" id="complemento" value="<?php echo $dadosProfissional['complemento'] ?>" class="form-control  form-control-sm" placeholder="Complemento">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">Telefone</label>
                                        <input type="text" name="telefone" id="telefone" value="<?php echo $dadosProfissional['telefone'] ?>" class="form-control  form-control-sm phone-ddd-mask" placeholder="Telefone" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                                    </div>
                                    <div class="mb-3">
                                        <label for="floatingInput">E-mail</label>
                                        <input type="email" name="email" id="email" value="<?php echo $dadosProfissional['email'] ?>" class="form-control  form-control-sm" placeholder="E-mail" aria-label="E-mail">
                                    </div>
                                    <div class="mb-3">

                                        <input type="text" value="<?php echo $dadosProfissional['opt'] ?>" class="form-control" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" name="servico" id="servico" onchange="change()">

                                            <option value="Artífice (Pedreiro,Pintor e Hidráulico)">Artífice (Pedreiro,Pintor e Hidráulico)</option>
                                            <option value="Babá">Babá</option>
                                            <option value="Cabeleireiro">Cabeleireiro</option>
                                            <option value="Cuidador(a) de Idoso">Cuidador(a) de Idoso</option>
                                            <option value="Dedetização">Dedetização</option>
                                            <option value="Diarista">Diarista</option>
                                            <option value="Lavanderia">Lavanderia</option>
                                            <option value="Manutenção de Ar Condicionado">Manutenção de Ar Condicionado</option>
                                            <option value="Motoboy">Motoboy</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" name="editar_admin_profissional" class="btn btn-primary" value="Editar">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }

            ?>
        </tbody>
    </table>
</div>
<div id="editarCliente">

    <?php

    $Cliente = new AdminDAO();
    $dadosCliente = $Cliente->ListarCliente();

    ?>
    <div id="cliente" class="row ms-3 p-2">
        <div class="col-md-3">
            <label for="validationServer01" class="form-label">Nome</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="cliente_name">

        </div>
        <div class="col-md-3">
            <label for="validationServer01" class="form-label">E-mail</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="cliente_nome">

        </div>
        <div class="col-md-4" style="margin-top: 31px;">
            <input type="submit" name="filtror_cliente" class="btn btn-secondary" value="Filtrar">

        </div>

    </div>
    <br>

    <table class="table table-hover">
        <thead style="background-color: #e9781e; color:white; font-family: 'Montserrat', sans-serif;">
            <tr>
                <th class="text-center" scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Telefone</th>
            </tr>


        </thead>
        <tbody>
            <?php

            foreach ($dadosCliente as $dadosCliente) {
            ?>

                <tr data-bs-toggle="modal" data-bs-target="#cliente<?php echo $dadosCliente['id']; ?>">
                    <td class="text-center" scope="col"><?php echo $dadosCliente['nome']; ?></td>
                    <td scope="col"><?php echo $dadosCliente['email']; ?></td>
                    <td scope="col"><?php echo $dadosCliente['telefone']; ?></td>
                </tr>
                <div class="modal fade" id="cliente<?php echo $dadosCliente['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $dadosCliente['nome']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">

                                    <input type="hidden" name="cliID" value="<?php echo $dadosCliente['id']; ?>">

                                    <?php



                                    if ($dadosCliente['opcao'] === 'J') {

                                    ?>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="cliopt" id="j" onclick="juridica()" value="J" CHECKED>
                                                <label class="form-check-label" for="pessoa" id="j">
                                                    Pessoa juridica
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="cliopt" id="f" onclick="fisica()" value="F">
                                                <label class="form-check-label" for="pessoa" id="f">
                                                    Pessoa Fisica
                                                </label>
                                            </div>
                                        </div>

                                    <?php

                                    } else {
                                    ?>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="cliopt" id="j" onclick="juridica()" value="J">
                                                <label class="form-check-label" for="pessoa" id="j">
                                                    Pessoa juridica
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="pessoa form-check-input" type="radio" name="cliopt" id="f" onclick="fisica()" value="F" CHECKED>
                                                <label class="form-check-label" for="pessoa" id="f">
                                                    Pessoa Fisica
                                                </label>
                                            </div>
                                        </div>


                                    <?php

                                    }
                                    ?>
                                    <div id="Pfisica">


                                        <div class="mb-3">
                                            <input type="text" name="clirazao" id="razao" value="<?php echo $dadosCliente['razao']; ?>" class="form-control" placeholder="Razão Social" aria-label="Nome de Usuário">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="cliInscrição" id="estadual" class="form-control cpf-mask" placeholder="Inscrição Estadual">
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <input type="text" name="clinome" id="nome" value="<?php echo $dadosCliente['nome']; ?>" class="form-control" placeholder="Nome de Usuário" aria-label="Nome de Usuário">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clicpf" id="cpf" value="<?php echo $dadosCliente['cpf']; ?>" class="form-control cpf-mask" placeholder="CPF/CNPJ" onkeypress="return somenteNumeros(event)" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);">
                                    </div>



                                    <div class="mb-3">
                                        <input type="password" name="clisenha" id="senha" class="form-control" placeholder="Senha" aria-label="">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="cliconfirmar" id="confirmar" class="form-control cpf-mask" placeholder="Confirmar senha">
                                    </div>




                                    <div class="mb-3">
                                        <input type="text" maxlength="9" name="clicep" value="<?php echo $dadosCliente['cep']; ?>" id="cep" class="form-control" placeholder="CEP" onkeypress="$(this).mask('00.000-000')">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clilogradouro" value="<?php echo $dadosCliente['logradouro']; ?>" id="rua" class="form-control" placeholder="Endereço ">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clinumer" id="numero" value="<?php echo $dadosCliente['numero']; ?>" class="form-control" placeholder="Nº ">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="cliuf" id="uf" value="<?php echo $dadosCliente['uf']; ?>" class="form-control" placeholder="UF">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clicidade" value="<?php echo $dadosCliente['cidade']; ?>" id="cidade" class="form-control " placeholder="Cidade">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clibairro" value="<?php echo $dadosCliente['bairro']; ?>" id="bairro" class="form-control " placeholder="Bairro">
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" name="clicomplemento" value="<?php echo $dadosCliente['complemento']; ?>" id="complemento" class="form-control " placeholder="Complemento">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="clitelefone" id="telefone" value="<?php echo $dadosCliente['telefone']; ?>" class="form-control phone-ddd-mask" placeholder="Telefone" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" name="cliemail" id="email" value="<?php echo $dadosCliente['email']; ?>" class="form-control" placeholder="E-mail" aria-label="E-mail">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <input type="submit" name="editarCliente" class="btn btn-primary" value="Editar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }

            ?>
        </tbody>
    </table>
</div>

</div>

<script>
    var administrador = document.getElementById('editarAdministrador').style.display = 'block';
    var profissional = document.getElementById('editarProfissional').style.display = 'none';
    var cliente = document.getElementById('editarCliente').style.display = 'none';


    $(document).ready(function() {
        var administrador = document.getElementById('editarAdministrador').style.display = 'block';
        var profissional = document.getElementById('editarProfissional').style.display = 'none';
        var cliente = document.getElementById('editarCliente').style.display = 'none';

    });

    function edit() {

        var select = document.getElementById('opcao').value;

        if (select === '1') {

            var administrador = document.getElementById('editarAdministrador').style.display = 'block';
            var profissional = document.getElementById('editarProfissional').style.display = 'none';
            var cliente = document.getElementById('editarCliente').style.display = 'none';
        }

        if (select === '2') {
            var administrador = document.getElementById('editarAdministrador').style.display = 'none';
            var profissional = document.getElementById('editarProfissional').style.display = 'block';
            var cliente = document.getElementById('editarCliente').style.display = 'none';
        }

        if (select === '3') {
            var administrador = document.getElementById('editarAdministrador').style.display = 'none';
            var profissional = document.getElementById('editarProfissional').style.display = 'none';
            var cliente = document.getElementById('editarCliente').style.display = 'block';
        }

    }
</script>

<script>
    $(document).ready(function() {


        $cheched = document.querySelector('input[name=opt]:checked').value;

        if ($cheched === 'J') {
            var Pfisica = document.getElementById('Pfisica').style.display = "block";
        }

        if ($cheched === 'F') {
            var Pfisica = document.getElementById('Pfisica').style.display = "none";
        }


    });
</script>

<script>
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

<?php
require "../../layout/footer.php";
?>