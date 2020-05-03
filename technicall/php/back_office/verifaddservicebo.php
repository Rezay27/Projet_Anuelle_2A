<?php session_start();
include('../include/connect_bdd.php');

if(isset($_POST['valider_service_bo']))
{
    $name= htmlspecialchars($_POST['nom_service']);
    $prix = htmlspecialchars($_POST['prix_service']);

    $insert = $bdd -> prepare("insert into services(nom_service,tarif,service_valide) values (:nom_service,:tarif,:service_valide)");
    $insert->execute(array(
        "nom_service" => $name,
        "tarif" => $prix,
        "service_valide" => 1
    ));

    header('Location:gestionBoService.php');

}

?>