<?php

include_once "../../class/ClassCliente.php";
include_once "../../dao/DAO.php";
require_once __DIR__ . "../../mail/cliente_redefinir.php";
class ClienteDAO extends DAO
{

    public function validarLogin($ClienteClass)
    {

        $sql = "SELECT * FROM `cliente` WHERE CLIENTE_EMAIL = :CLIENTE_EMAIL  and CLIENTE_SENHA = :CLIENTE_SENHA ";
        $select = $this->con->prepare($sql);
        $select->bindValue(':CLIENTE_EMAIL', $ClienteClass->GetEmail());
        $select->bindValue(':CLIENTE_SENHA', md5($ClienteClass->GetSenha()));
        $select->execute();

        $_SESSION['user'] = array();
        if ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            session_start();

            $_SESSION['user'] = array(

                'id' => $row['CLIENTE_ID'],
                'nome' => $row['CLIENTE_NOME'],
                'email' => $row['CLIENTE_EMAIL'],
                'cpf' => $row['CLIENTE_CPF'],
                'telefone' => $row['CLIENTE_TELEFONE'],
                'cep' => $row['CLIENTE_CEP'],
                'uf' => $row['CLIENTE_UF'],
                'rua' => $row['CLIENTE_LOGRADOURO'],
                'numero' => $row['CLIENTE_NUM'],
                'cidade' => $row['CLIENTE_CIDADE'],
                'bairro' => $row['CLIENTE_BAIRRO'],
                'complemento' => $row['CLIENTE_COMPLEMENTO'],
                'foto' => $row['CLIENTE_FOTO']
            );

            header('location: ../../view/cliente/painel.php');
        } else {
?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Dados inválidos',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>


        <?php
        }
    }

    public function updateSenha($novaSenha,$id,$email,$senha){


        $sql = "SELECT * FROM `cliente` WHERE CLIENTE_EMAIL=:CLIENTE_EMAIL and CLIENTE_ID =:CLIENTE_ID";
        $select = $this->con->prepare($sql);
        $select->bindValue(':CLIENTE_EMAIL', $email);
        $select->bindValue(':CLIENTE_ID', $id);
        $select->execute();

        if($select->fetch(PDO::FETCH_ASSOC)){
            $new =  md5($novaSenha);
            $sql2 = "UPDATE `cliente` SET CLIENTE_SENHA=:CLIENTE_SENHA where CLIENTE_ID=:CLIENTE_ID";
            $update = $this->con->prepare($sql2);
            $update->bindValue(':CLIENTE_ID', $id);
            $update->bindValue(':CLIENTE_SENHA', $new);
            $update->execute();

            ?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Senha alterada com sucesso',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>


        <?php
                header('Refresh: 3.5; url=../cliente/login.php');
        }else{

            ?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Erro',
                    text:'ao tentar alterar senha por favor entre em contato com os administradores',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>


        <?php

        }

    }

    public function redefinirSenha($ClassCliente){

        $sql = "SELECT * FROM `cliente` WHERE `CLIENTE_EMAIL` = :CLIENTE_EMAIL";
        $select = $this->con->prepare($sql);
        $select->bindValue(':CLIENTE_EMAIL', $ClassCliente->GetEmail());
        $select->execute();

        if($row = $select->fetch(PDO::FETCH_ASSOC)){

               $id =  $row['CLIENTE_ID'];
               $nome = $row['CLIENTE_NOME'];
               $email = $ClassCliente->GetEmail();
               $senha = ClienteDAO::RandonSenha();
               $senha = base64_encode($senha);


               $sql2 = "UPDATE `cliente` SET  CLIENTE_SENHA = :CLIENTE_SENHA where CLIENTE_ID = :CLIENTE_ID and CLIENTE_EMAIL = :CLIENTE_EMAIL";
               $update = $this->con->prepare($sql2);
               $update->bindValue(':CLIENTE_EMAIL', $ClassCliente->GetEmail());
               $update->bindValue(':CLIENTE_ID', $id);
               $update->bindValue(':CLIENTE_SENHA', $senha);
               
               try {
                   $update->execute();


                   ?>


                   <script>
                       Swal.fire({
                           position: 'center',
                           icon: 'success',
                           title: 'Sua senha foi redefinidar',
                           text: 'Por favor verifique seu e-mail',
                           showConfirmButton: false,
                           timer: 3500
                       })
                   </script>
   
               <?php
              
                RedefinirCliente::Senha($email, $senha,$id,$nome);
                

               } catch (\Throwable $th) {
                ?>


                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Erro',
                        text: 'Por favor entre em contato com administração!',
                        showConfirmButton: false,
                        timer: 3500
                    })
                </script>

            <?php
               }
               
        }else{

            ?>


            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Erro, E-mail invalidor',
                    text: 'Por favor informe um e-mail valido',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>

        <?php
        }
    }

    public function insertCliente($ClassCliente)
    {



        $sql = "INSERT INTO `cliente`(`CLIENTE_ID`, `CLIENTE_NOME`, `CLIENTE_CPF`, `CLIENTE_EMAIL`, `CLIENTE_TELEFONE`, `CLIENTE_CEP`, `CLIENTE_FOTO`, `CLIENTE_SENHA`, `CLIENTE_UF`, `CLIENTE_CIDADE`, `CLIENTE_LOGRADOURO`, `CLIENTE_BAIRRO`, `CLIENTE_COMPLEMENTO`, `CLIENTE_OPCAO`, `CLIENTE_RAZAO`, `CLIENTE_NUM`)
         VALUES (null, :CLIENTE_NOME, :CLIENTE_CPF, :CLIENTE_EMAIL, :CLIENTE_TELEFONE, :CLIENTE_CEP, :CLIENTE_FOTO, :CLIENTE_SENHA, :CLIENTE_UF, :CLIENTE_CIDADE, :CLIENTE_LOGRADOURO, :CLIENTE_BAIRRO, :CLIENTE_COMPLEMENTO, :CLIENTE_OPCAO, :CLIENTE_RAZAO, :CLIENTE_NUM)";
        $insert = $this->con->prepare($sql);
        $insert->bindValue(':CLIENTE_NOME', $ClassCliente->GetNome());
        $insert->bindValue(':CLIENTE_CPF', $ClassCliente->GetCpf());
        $insert->bindValue(':CLIENTE_EMAIL', $ClassCliente->GetEmail());
        $insert->bindValue(':CLIENTE_TELEFONE', $ClassCliente->GetTelefone());
        $insert->bindValue(':CLIENTE_CEP', $ClassCliente->GetCep());
        $insert->bindValue(':CLIENTE_FOTO', $ClassCliente->GetFoto());
        $insert->bindValue(':CLIENTE_SENHA', md5($ClassCliente->GetSenha()));
        $insert->bindValue(':CLIENTE_UF', $ClassCliente->GetUf());
        $insert->bindValue(':CLIENTE_CIDADE', $ClassCliente->GetCidade());
        $insert->bindValue(':CLIENTE_OPCAO', $ClassCliente->GetOpcao());
        $insert->bindValue(':CLIENTE_RAZAO', $ClassCliente->GetRazao());
        $insert->bindValue(':CLIENTE_CIDADE', $ClassCliente->GetCidade());
        $insert->bindValue(':CLIENTE_LOGRADOURO', $ClassCliente->GetLogradouro());
        $insert->bindValue(':CLIENTE_BAIRRO', $ClassCliente->GetBairro());
        $insert->bindValue(':CLIENTE_COMPLEMENTO', $ClassCliente->GetComplemento());
        $insert->bindValue(':CLIENTE_OPCAO', $ClassCliente->GetOpcao());
        $insert->bindValue(':CLIENTE_RAZAO', $ClassCliente->GetRazao());
        $insert->bindValue(':CLIENTE_NUM', $ClassCliente->GetNumero());
        try {
            $insert->execute();
        ?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cadastro Realizado com Sucesso',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>


        <?php
            header('location: ../../view/cliente/login.php');
        } catch (PDOException $e) {


        ?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Registro Inválido',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>

<?php


        }
    }

    public static function logout($dados)
    {

        session_destroy();

        header('location: http://primazia.agenciaprogride.com.br/home-resumida-cdaivpysmvvotjwotzxbvm/');
    }

    public static function RandonSenha($length = 7)
    {

        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }
}



?>