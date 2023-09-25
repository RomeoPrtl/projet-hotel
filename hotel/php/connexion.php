<?php 
$server = "localhost";
$mdp = "";
$utilisateur = "root";
$bdd = "db_hotel";

try {
    $dsn = "mysql:host=$server;dbname=$bdd";
    $co = new PDO($dsn, $utilisateur, $mdp);
    $co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connexion établie";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>