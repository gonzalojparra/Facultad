<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Public/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/cssPuro/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap" rel="stylesheet">
    <title>Autos</title>
</head>

<body>
    <?php require_once '../templates/header.php'; ?>

    
    <h3><p class= "titulos text-center bienvenida">AUTOS</p></h3>

    <div>
        <hr>
        <form action="../accion/verAutos.php" method="POST">
            <input type="hidden" name="accion" id="accion" value="verAutos">
            <input class="btn m-3 p-2 text-center" style="background-color: #563d7c; color:white;" type="submit" value="Ver Autos">
        </form>
        <hr>


        <a class="btn m-3 p-2 text-center" href="../buscarAuto/index.php" style="background-color: #563d7c; color:white;">Buscar autos</a>
        <!-- <form action="../accion/accionBuscarAuto.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control w-50 m-2" id="patente" name="patente" placeholder="Patente">
                <label for="patente">Patente</label>
                <input type="hidden" name="accion" id="accion" value="buscarAutos">
                <input class="btn m-3 p-2 text-center" style="background-color: #EB5E0B; color:white;" type="submit" value="Buscar autos">
            </div>
        </form> -->
        <hr>

        <div>
            <a class="btn m-3 p-2 text-center" style="background-color: #563d7c; color:white;" href="../nuevoAuto/index.php">Cargar nuevo auto</a>
        
        </div>
        <hr>

        <div>
            <a class="btn m-3 p-2 text-center" style="background-color: #563d7c; color:white;" href="../cambiarDuenio/index.php">Cambiar dueño</a>
        </div>

    </div>

    <?php require_once '../templates/footer.php'; ?>
</body>

</html>