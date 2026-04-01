<?php
$host = "db"; // Nome do serviço no docker-compose
$user = "root";
$pass = "root";
$db   = "financeiro";

$conn = new mysqli($host, $user, $pass, $db);
?>