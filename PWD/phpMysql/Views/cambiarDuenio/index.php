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
    <title>Cambiar Dueño</title>
</head>

<body>
    <?php require_once '../templates/header.php' ?>
    <div class='m-3' id="contenedorForm">
        <form action="../accion/accionCambioDuenio.php" method="post">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="inputPatente" id="inputPatente" placeholder="Patente">
                <label for="inputPatente">La patente</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="number" name="inputDni" id="inputDni" placeholder="Dni Nuevo Dueño">
                <label for="inputDni">El DNI del nuevo dueño</label>
            </div>
            <div class="form-floating mb-3">
                <input type="submit" value="Cambiar" id="botonSubmit" disabled>
                <a class="btn m-3" style="background-color:#563d7c; color:white;" href="../autos/index.php">Volver</a>
            </div>


        </form>
    </div>
    <script src="../../Public/jsPuro/cambiarDuenio.js"></script>
    <?php require_once '../templates/footer.php' ?>
</body>

</html>