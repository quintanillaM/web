<?php
// Conexión a la base de datos
include("conexion.php");

// Verificar si se ha recibido un id por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consultar los datos del usuario seleccionado
    $consulta = $conexion->prepare("SELECT * FROM usuario WHERE id = :id");
    $consulta->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $consulta->execute();

    // Obtener el usuario
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "Usuario no encontrado";
        exit;
    }
} else {
    echo "ID no válido.";
    exit;
}

// Si se envía el formulario, actualizar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevousuario = $_POST['usuario'];
    $nuevonombre = $_POST['nombre'];

    // Validar los campos
    if (empty($nuevousuario) || empty($nuevonombre)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Actualizar el registro en la base de datos
        $consulta = $conexion->prepare("UPDATE usuario SET usuario = :usuario, nombre = :nombre WHERE id = :id");
        $consulta->bindParam(':usuario', $nuevousuario);
        $consulta->bindParam(':nombre', $nuevonombre);
        $consulta->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($consulta->execute()) {
            header('Location: index.php'); // Redirigir despues de actualizar
            exit;
        } else {
            echo "Error al actualizar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="editar-css.css">
</head>
<body>

<div class="user">
    <center>
    <h1>Editar Usuario</h1>

    <form action="editar.php?id=<?php echo htmlspecialchars($id_usuario); ?>" method="POST">
        <div class="user">
            <label for="usuario">Editar Usuario:</label><br> 
            <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" placeholder="Usuario" required>
       <br>
        </div>
    
        <div class="user">
            
            <label for="nombre">Editar Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" placeholder="Nombre completo" required>

        </div>
        <div class="user">
        
            <input type="submit" value="Guardar" class="btn-guardar">
            <br>
        </div>
        </center>
    </form>
</div>


</body>
</html>
