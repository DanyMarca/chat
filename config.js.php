<?php
// Imposta header Javascript
header('Content-Type: application/javascript');

// Calcola dinamicamente il dominio
$host = $_SERVER['HTTP_HOST'];

?>

// Questo sarà letto nel frontend
const API_BASE_URL = "http://<?php echo $host; ?>/chat/BE/api";