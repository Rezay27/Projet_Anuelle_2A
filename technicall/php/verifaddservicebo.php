<?php session_start();
include('connect_bdd.php');

if(isset($_POST['valider_service_bo']))
{
    $name= htmlspecialchars($_POST['nom_service']);
    $prix = htmlspecialchars($_POST['prix_service']);
    $type = htmlspecialchars($_POST['type_services']);

    $insert = $bdd -> prepare("insert into services(nom_service,tarif,id_type_service,service_valide) values (:nom_service,:tarif,:id_type_service,:service_valide)");
    $insert->execute(array(
        "nom_service" => $name,
        "tarif" => $prix,
        "id_type_service" => $type,
        "service_valide" => 0
    ));

    header('Location:gestionBoService.php');

}

?>