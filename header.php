<?php
require_once "config.php";

spl_autoload_register(function ($class) 
{
    $path = __DIR__ . '\src\\' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

function html(mixed $text) : string
{
    return htmlspecialchars($text, ENT_QUOTES);
}
  
$pdo = ConnectionDB::connect($host, $db, $user, $pass);