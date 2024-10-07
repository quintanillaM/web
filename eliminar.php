<?php
include("conexion.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Elimina el usuario
    $consulta = $conexion->prepare("DELETE FROM usuario WHERE id = :id");
    $consulta->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $consulta->execute();

    // Reinicia IDs
    $conexion->exec("SET @num := 0;"); // Reiniciar el contador
    $conexion->exec("UPDATE usuario SET id = @num := (@num + 1) ORDER BY id;"); // Actualiza los ID
    $conexion->exec("ALTER TABLE usuario AUTO_INCREMENT = 1;"); // Reiniciar el auto incrementador

    header('Location: index.php');
    exit;
}
?>
