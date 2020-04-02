<?php session_start();
include('../include/connect_bdd.php');

if(isset($_POST['valider'])) {
    $name = htmlspecialchars($_POST["nameservices"]);
    $tarif = htmlspecialchars($_POST["tarifservices"]);
    $type = htmlspecialchars($_POST["typeservices"]);
    $ville = htmlspecialchars($_POST["ville"]);
    $adresse = htmlspecialchars($_POST["adresse"]);
    $code_postal = htmlspecialchars($_POST["code_postal"]);
    $date = htmlspecialchars($_POST["dateservice"]);
    $heure = htmlspecialchars($_POST["heureservice"]);
    $id = $_SESSION['id'];


    $insertdemande = $bdd->prepare("INSERT INTO demandes(nom_demande,prix_demande,type_demande,date,heure,ville,code_postal,adresse,valide) VALUES(:nom_demande,:prix_demande,:type_demande,:date,:heure,:ville,:code_postal,:adresse,:valide)");
    $insertdemande->execute(array
        ("nom_demande" => $name,
            "prix_demande" => $tarif,
            "type_demande" => $type,
            "date" => $date,
            "heure" => $heure,
            "ville" => $ville,
            "code_postal" => $code_postal,
            "adresse" => $adresse,
            "valide" => 1
        )
    );
    $reponse = $bdd->query("SELECT id_demandes FROM demandes order by id_demandes DESC LIMIT 0, 1");
    $donnees = $reponse->fetch();
    $insermembre_demande = $bdd->prepare("insert into membre_demande(id_demande,id_membre) values(:id_demande,:id_membre)");
    $insermembre_demande->execute(array(
        "id_demande" => $donnees['id_demandes'],
        "id_membre" => $_SESSION['id']
    ));

    $reponse = $bdd->prepare('Select id_services from services where nom_service = ?');
    $reponse->execute(array("$name"));
    $donnees = $reponse->fetch();
    $reponse1 = $bdd->query("SELECT id_demandes FROM demandes order by id_demandes DESC LIMIT 0, 1");
    $donnees1 = $reponse1->fetch();
    $inserservice_demande = $bdd->prepare("insert into demande_service(id_demande,id_service) values(:id_demande,:id_service)");
    $inserservice_demande->execute(array(
        "id_demande" => $donnees1['id_demandes'],
        "id_service" => $donnees['id_services']
    ));

    header('Location:DemandeService.php');
}

    if(isset($_POST['fermer'])){
        header('Location:DemandeService.php');

    }
