<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require "../../vendor/autoload.php";

//Create an instance; passing `true` enables exceptions

class Mail
{

    public function Envio($nome,$email,$pedido,$telefone,$data)
    {

        $mail = new PHPMailer(true);

       echo "<pre>";
       var_dump($pedido);
       echo "</pre>";

         
         $categoria = $pedido['categoria'];
         $categoria = implode('<br>',$categoria);

         $area = $pedido['area'];
         $area = implode('<br>',$area);

         $local = $pedido['local'];
         $local = implode('<br>',$local);

         $dependente = $pedido['dependente'];
         $dependente = implode('<br>',$dependente);
         
         $serviço = $pedido['serviço'];
         $serviço = implode('<br>',$serviço);
         
        echo $serviço;

/*
       $tamanho = count($pedido);
     
        $categoria = array();
        

        
       for($i=0; $i<$tamanho; $i++){

        $categoria[] = $pedido['categoria'][$i];
       
    }
*/


        
        try {
            //Server settings
            //$mail->SMTPDebug = 1;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'primaziateste2021@gmail.com';                     //SMTP username
            $mail->Password   = 'pr0gr!d@2021';                         //SMTP password
            $mail->SMTPSecure = 'SSL';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('primaziateste2021@gmail.com', 'G2S');
            $mail->addAddress('luiz.c@progride.com.br', 'G2S - GoToService');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'utf-8';
            $mail->Subject = 'NOVO PEDIDO';
            $mail->Body    = '<b>Produtos:</b><br>'.$categoria.'';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
           // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        }

        

    }
}