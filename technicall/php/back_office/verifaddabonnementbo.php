<?php session_start();
include('../include/connect_bdd.php');

if(isset($_POST['valider_abonnement_bo'])) {
    $nom = htmlspecialchars($_POST['nom_abonnement']);
    $prix = htmlspecialchars($_POST['prix_abonnement']);
    $description1 = htmlspecialchars($_POST['description1_abonnement']);
    $description2 = htmlspecialchars($_POST['description2_abonnement']);
    $description3 = htmlspecialchars($_POST['description3_abonnement']);
    $nb_heure = htmlspecialchars($_POST['nombreH_abonnement']);

    var_dump($nom);

    $insert_type = $bdd->prepare('insert into type_abonnement(nom,prix) values (:nom,:prix)');
    $insert_type->execute(array(
        "nom" => $nom,
        "prix" => $prix * 100
    ));

    $select_last_id = $bdd->prepare('select * from type_abonnement where nom= ? order by id DESC LIMIT 0, 1');
    $select_last_id->execute(array($nom));
    $last_id = $select_last_id->fetch();
    var_dump($last_id['id']);

    $insert_info = $bdd->prepare('insert into info_abonnement(description1,description2,description3,nb_heure,type_abonnement) values(:description1,:description2,:description3,:nb_heure,:type_abonnement)');
    $insert_info->execute(array(
        "description1" => $description1,
        "description2" => $description2,
        "description3" => $description3,
        "nb_heure" => $nb_heure,
        "type_abonnement" => $last_id['id']
    ));


    header('Location:gestionBoAbonnement.php');
}

?>