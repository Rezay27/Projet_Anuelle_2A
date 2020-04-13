<?php
try
{    // connection à la base de données
$bdd = new PDO('mysql:host=localhost:3307;dbname=technicall;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{

die('Erreur : '.$e->getMessage());  // En cas d'erreur, on affiche un message et on arrête tout
}



?>
