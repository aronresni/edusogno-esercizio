<?php
require '../db/Conexion.php';

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    try {
        $sqlDelete = "DELETE FROM eventi WHERE id = :id";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmtDelete->execute();

        if ($stmtDelete->rowCount() > 0) {
            echo "Evento eliminado correctamente.";
            header('Location: http://localhost/edusogno/edusogno-esercizio/pages/profile/profile.php');
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
