<?php

include_once "../../class/ClassAdmin.php";
include_once "../../dao/DAO.php";
require_once __DIR__ . "../../mail/admin_redefinir.php";
class AdminDAO extends DAO
{

    public function insertAdmin($ClassAdmin){

     $sql = "INSERT INTO `admin`(`admin_id`, `admin_nome`, `admin_senha`, `admin_email`, `admin_foto`) 
     VALUES (null, :admin_nome, :admin_senha, :admin_email, :admin_foto)";

     $insert = $this->con->prepare($sql);
     $insert->bindValue(':admin_nome', $ClassAdmin->GetNome());
     $insert->bindValue(':admin_senha', md5($ClassAdmin->GetSenha()));
     $insert->bindValue(':admin_email', $ClassAdmin->GetEmail());
     $insert->bindValue(':admin_foto', $ClassAdmin->GetFoto());
     
     
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
        header('location: ../../view/admin/login.php');

        } catch (\Throwable $th) {
            ?>

            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Registro Inválido',
                    text:'algo deu errado entre em contato com os administradores',
                    showConfirmButton: false,
                    timer: 3500
                })
            </script>

            <?php
        }

    }

    public function updateSenha($novaSenha,$id,$email,$senha){

        $sql = "SELECT * FROM `admin` WHERE admin_id = :admin_id and admin_email = :admin_email and admin_senha = :admin_senha";
        $select = $this->con->prepare($sql);
        $select->bindValue(':admin_id', $id);
        $select->bindValue(':admin_email', $email);
        $select->bindValue(':admin_senha', $senha);
        $select->execute();

        if($select->fetch(PDO::FETCH_ASSOC)){
            $new =  md5($novaSenha);

            $sql2 = "UPDATE `admin` SET `admin_senha`=:admin_senha where admin_id = :admin_id";
            $update = $this->con->prepare($sql2);
            $update->bindValue(':admin_id', $id);
            $update->bindValue(':admin_senha', $new);
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
        header('Refresh: 5.0; url=../admin/login.php');
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

    public function redefinirSenha($ClassAdmin){

        $sql = "SELECT * FROM `admin` WHERE `admin_email` = :admin_email";
        $select = $this->con->prepare($sql);
        $select->bindValue(':admin_email', $ClassAdmin->GetEmail());
        $select->execute();

        if($row = $select->fetch(PDO::FETCH_ASSOC)){

            $id = $row['admin_id'];
            $nome = $row['admin_nome'];
            $email = $ClassAdmin->GetEmail();
            $senha = AdminDAO::RandonSenha();
            $senha = base64_encode($senha);

            $sql2 = "UPDATE `admin` SET `admin_senha`= :admin_senha WHERE admin_id=:admin_id and admin_email=:admin_email";
            $update = $this->con->prepare($sql2);
            $update->bindValue(':admin_id', $id);
            $update->bindValue(':admin_email', $ClassAdmin->GetEmail());
            $update->bindValue(':admin_senha', $senha);
            
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

                  Redefinir::Senha($email, $senha,$id,$nome);
                //echo $email."<br>". $senha."<br>".$id."<br>".$nome;


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