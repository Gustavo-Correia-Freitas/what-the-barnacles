<?php

// Serve para a conexão, professor.

$host  = 'localhost';   
$banco = 'biblioteca';  
$user  = 'root';        
$senha = '';

//Cada "$" serve como um conector que leva para outras partes do código.

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die('Não consegui conectar ao banco: ' . $erro->getMessage() .
        '<br>Confira se o MySQL está ligado no painel do XAMPP e se o banco.sql foi importado.');
}

function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

