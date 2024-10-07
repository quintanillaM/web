<?php 
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];

    if (empty($usuario) || empty($clave) || empty($nombre)) {
        $error .= "Complete los campos.";
    } else {
        include("conexion.php");
        $consulta = "INSERT INTO usuario (nombre, clave, usuario) VALUES (:nombre, :clave, :usuario)";
        $consulta = $conexion->prepare($consulta);
        $consulta->bindParam(':usuario', $usuario);
        $consulta->bindParam(':clave', $clave);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->execute();

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo usuario</title>
    <link rel="stylesheet" href="editar-css.css">
</head>
<body>
    <center>
    <div class="contenedor">
    <h1>Nuevo usuario</h1>
    <div>
        <p><?php echo $error; ?></p>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="user formulario-sm"> <!-- Se aplica la clase 'user' para el estilo -->
            <table>
                <tr>
                    <td>
                        <input type="text" placeholder="Usuario" name="usuario" class="form-input" required> <!-- Clase para los inputs -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" placeholder="*************" name="clave" class="form-input" required> <!-- Clase para los inputs, incluyendo clave -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" placeholder="Nombre completo" name="nombre" class="form-input" required> <!-- Clase para los inputs -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Guardar" class="btn-guardar"> <!-- Botón con clases aplicadas -->
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
</body>
</html>

