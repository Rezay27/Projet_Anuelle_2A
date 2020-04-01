<?php session_start();
include('connect_bdd.php');

if(isset($_POST['abo_valider']))
{
    $name = htmlspecialchars($_POST["addname"]);
    $tarif = htmlspecialchars($_POST["addtarif"]);
    $type = htmlspecialchars($_POST["addtypeservices"]);
    $ville = htmlspecialchars($_POST["addville"]);
    $adresse = htmlspecialchars($_POST["addadresse"]);
    $code_postal = htmlspecialchars($_POST["addcode_postal"]);
    $date = htmlspecialchars($_POST["adddateservice"]);
    $heure = htmlspecialchars($_POST["addheureservice"]);
    $id = $_SESSION['id'];

    $insertdemande= $bdd->prepare("INSERT INTO demandes(nom_demande,prix_demande,type_demande,date,heure,ville,code_postal,adresse,valide) VALUES(:nom_demande,:prix_demande,:type_demande,:date,:heure,:ville,:code_postal,:adresse,:valide)");
    $insertdemande->execute(array
        ("nom_demande" => $name,
            "prix_demande" => $tarif . " €",
            "type_demande" => $type,
            "date" => $date,
            "heure" => $heure,
            "ville" => $ville,
            "code_postal" => $code_postal,
            "adresse" => $adresse,
            "valide" => 0
        )
    );

    $reponse = $bdd->query("SELECT id_demandes FROM demandes order by id_demandes DESC LIMIT 0, 1");
    $donnees = $reponse -> fetch();
    $insermembre_demande = $bdd->prepare("insert into membre_demande(id_demande,id_membre) values(:id_demande,:id_membre)");
    $insermembre_demande->execute(array(
        "id_demande" => $donnees['id_demandes'],
        "id_membre" => $_SESSION['id']
    ));

    $types = $bdd-> prepare("select id_type from type_service where nom_type = ? ");
    $types -> execute(array("$type"));
    $type_id = $types -> fetch();
    $new_service = $bdd ->prepare("insert into services (nom_service,tarif,id_type_service,service_valide) values(:nom_service,:tarif,:id_type_service,:service_valide)");
    $new_service -> execute(array(
        "nom_service" => $name,
        "tarif"=> $tarif,
        "id_type_service" => $type_id['id_type'],
        "service_valide" => 0
    ));

    $reponses = $bdd->prepare('Select id_services from services where nom_service = ?');
    $reponses->execute(array("$name"));
    $donnees = $reponses -> fetch();
    $reponse1 = $bdd->query("SELECT id_demandes FROM demandes order by id_demandes DESC LIMIT 0, 1");
    $donnees1 = $reponse1 -> fetch();
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
?>