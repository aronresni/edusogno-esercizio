<?php
require '../assets/db/Conexion.php';

// Verificar si se ha proporcionado un ID de evento en la URL
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        // Preparar y ejecutar la consulta para eliminar el evento
        $sqlDelete = "DELETE FROM eventi WHERE id = :id";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmtDelete->execute();

        if ($stmtDelete->rowCount() > 0) {
            echo "Evento eliminado correctamente.";
            header('Location: ../profile.php');
        } else {
            echo "No se encontró ningún evento con el ID proporcionado.";
        }
    } catch (PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
} else {
    echo "ID de evento no proporcionado.";
}
?>
