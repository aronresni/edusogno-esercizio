<?php
class Conexion {
    function conexionBD() {
        $host = "localhost";
        $dbname = "edusogno";
        $username = "postgres";
        $password = "Aroncapo1$";

        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         
            $conn->exec("
                CREATE TABLE IF NOT EXISTS utenti (
                    id serial PRIMARY KEY,
                    nome varchar(45),
                    cognome varchar(45),
                    email varchar(255),
                    password varchar(255)
                );
                CREATE TABLE IF NOT EXISTS eventi (
                    id serial PRIMARY KEY,
                    attendees text,
                    nome_evento varchar(255),
                    data_evento timestamp
                );
            ");

            $conn->exec("
                INSERT INTO eventi (attendees, nome_evento, data_evento) 
                VALUES 
                ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00'), 
                ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00'), 
                ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00')
            ");


        } catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
        }
    }
}

$conexion = new Conexion();
$conexion->conexionBD();
?>
