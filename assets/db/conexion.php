<?php

$server = 'localhost';
$username = 'postgres';
$password = 'Aroncapo1$';
$database = 'edusogno';

try {
  $conn = new PDO("pgsql:host=$server;dbname=$database;", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
                  id SERIAL PRIMARY KEY,
                  email VARCHAR(255),
                  password VARCHAR(255)
              )";
  $conn->exec($sqlUsers);

  $sqlUtentiEventi = "CREATE TABLE IF NOT EXISTS utenti (
                          id SERIAL PRIMARY KEY,
                          nome VARCHAR(45),
                          cognome VARCHAR(45),
                          email VARCHAR(255),
                          password VARCHAR(255)
                      );

                      CREATE TABLE IF NOT EXISTS eventi (
                          id SERIAL PRIMARY KEY,
                          attendees TEXT,
                          nome_evento VARCHAR(255),
                          data_evento TIMESTAMP
                      )";
  $conn->exec($sqlUtentiEventi);


  $sqlInsertEventi = "INSERT INTO eventi (attendees, nome_evento, data_evento) 
                      VALUES 
                      ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00'), 
                      ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00'), 
                      ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00')";
  $conn->exec($sqlInsertEventi);

} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
