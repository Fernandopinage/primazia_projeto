<?php

include_once "../../layout/heard.php";

if (isset($_POST['filtro'])) {
    $dado = $_POST['opcao'];

    switch ($dado) {


        case '1':

?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

        <?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/pequenosreparos.php');
            break;

        case '2':
            //header('location: ../../view/cliente/pequenosreparos.php');
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'warning',
                    title: 'Em Manutenção',
                    showConfirmButton: false,
                    timer: 4500
                })
            </script>

        <?php
            break;

        case '3':
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'warning',
                    title: 'Em Manutenção',
                    showConfirmButton: false,
                    timer: 4500
                })
            </script>

        <?php
            //header('location: ../../view/cliente/pequenosreparos.php');
            break;

        case '4':

        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: 'warning',
                    title: 'Em Manutenção',
                    showConfirmButton: false,
                    timer: 4500
                })
            </script>

        <?php
            //header('location: ../../view/cliente/pequenosreparos.php');
            break;

        case '5':
            ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

        <?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/dedetizacao.php');
            break;

        case '6':
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

        <?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/diarista.php');
            break;

        case '7':
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

        <?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/lavanderia.php');
            break;

        case '8':
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

        <?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/arcondicionado.php');
            break;

        case '9':
        ?>

            <script>
                Swal.fire({
                    position: 'top-center',
                    icon: '',
                    title: '<div class="spinner-border text-warning" role="status"> <span class="visually-hidden">Loading...</span></div>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>

<?php
            header('Refresh: 1.5; url=http://192.168.1.54/primazia_projeto/view/cliente/motoboy.php');
            break;


        default:
            # code...
            break;
    }
}


?>
<link href="../../layout/css/cliente_pedido.css" rel="stylesheet">

<div class="container-fluid">
    <div class="container" id="registro">
        <div class="text-center">
            <img id="logo" src="../../images/primazia.png" class="img"><br>
        </div>

        <div class="title text-center">
            <p>QUAL SERVIÇO VOCÊ <span>PRECISA?</span></p>
        </div>


        <form method="post">
            <div class="row g-12 ms-3 p-2">
                <div class="col-11 ">
                    <select class="form-select" name="opcao" aria-label="Default select example">
                        <option selected>Selecione sua Profissão</option>
                        <option value="1">Artífice (Pedreiro,Pintor e Hidráulico)</option>
                        <option value="2">Babá</option>
                        <option value="3">Cabelereiro</option>
                        <option value="4">Cuidador(a) de Idoso</option>
                        <option value="5">Dedetização</option>
                        <option value="6">Diarista</option>
                        <option value="7">Lavanderia</option>
                        <option value="8">Manutenção de Ar Condicionado</option>
                        <option value="9">Motoboy</option>
                    </select><br>
                </div>
            </div>
            <div class="row g-6">
                <div class="col text-center">
                    <input type="submit" id='botaoEnviar' name="filtro" value="AVANÇAR" type="button" class="btn orangered btn-lg">
                </div>
            </div>
        </form>
    </div>

    <div class="container" id="registro_logo">
        <img id='image' src="../../images/profissional.gif" class="img">
    </div>


</div>

<?php

include_once "../../layout/footer.php";
?>