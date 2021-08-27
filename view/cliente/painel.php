<?php
include_once "../../layout/heard.php";

session_start();

if (empty($_SESSION['user'])) {

    header('location: ../../view/cliente/login.php');
}

?>
<link href="../../layout/css/cliente_painel.css" rel="stylesheet">
<div id="logo">
    <img src="../../images/primazia.png" alt="" width="250" height="190">
</div>


<div class="container">

    <div class="text-center">
        <img id="usuario" src="../../images/perfil.jpg" class="img"><br><br>
        <h5 style="text-transform: capitalize;"><?php echo $_SESSION['user']['nome'] ?></h5><br>
        <img src="../../images/photo1629981520.jpeg" class="img" width="130"> 4,67</h5></img><br>
    </div>

   
</div>

<div class="container-fluid">

    <nav class="navbar navbar">
        <div class="row g-5">
            <div class="col-md">
                <a class="navbar-brand" href="../cliente/pedido.php">
                    <img src="../../images/encontreumprofissional.png" alt="" width="80" height="80">
                </a>
                <p class="fs-6"> Encontre um Profissional</p>
            </div>
            <div class="col-md">
                <a class="navbar-brand" href="http://primazia.agenciaprogride.com.br/contato-home-resumida/">
                    <img src="../../images/faleconosco.png" alt="" width="80" height="80">
                </a>
                <p class="fs-6"> Fale Conosco </p>

            </div>

            <div class="col-md">
                <a class="navbar-brand" href="http://primazia.agenciaprogride.com.br/login-registro-profissional/">
                    <img src="../../images/cadastresecomoprofissional.png" alt="" width="70" height="70">
                </a>
                <p class="fs-6"> Cadastre-se como Profissional</p>
            </div>

            <div class="col-md">
                <a class="navbar-brand" href="#">
                    <img src="../../images/pedidosquesolicitei.png" alt="" width="70" height="70">
                </a>
                <p class="fs-6"> Meus Pedidos</p>
            </div>
            <div class="col-md">
                <a class="navbar-brand" href="../../view/cliente/logout.php">
                    <img src="../../icons/photo1629906564.jpeg" alt="" width="70" height="70">
                </a>
                <p class="fs-6">Sair</p>
            </div>
        </div>
    </nav>

</div>




<?php
require "../../layout/footer.php";
?>