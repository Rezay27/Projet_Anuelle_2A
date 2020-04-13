<?php session_start();
include('../include/connect_bdd.php');

if (isset($_POST['valider'])) {
    $name = htmlspecialchars($_POST["nameservices"]);
    $tarif = htmlspecialchars($_POST["tarifservices"]);
    $type = htmlspecialchars($_POST["typeservices"]);
    $nb_heure = htmlspecialchars($_POST["nb_heure"]);
    $ville = htmlspecialchars($_POST["ville"]);
    $adresse = htmlspecialchars($_POST["adresse"]);
    $code_postal = htmlspecialchars($_POST["code_postal"]);
    $date = htmlspecialchars($_POST["dateservice"]);
    $heure = htmlspecialchars($_POST["heureservice"]);
    $id = $_SESSION['id'];

    $select_nb_heure = $bdd->prepare("select * from abonnement_test where id_membre = ?  ");
    $select_nb_heure->execute(array($_SESSION['id']));
    $nb_heure_exist = $select_nb_heure->fetch();
    //Verifier le nombre d'heure restante
    if ($nb_heure_exist['heure_restante'] > $nb_heure) {

        //Insere la demande en bdd
        $insertdemande = $bdd->prepare("INSERT INTO demandes(nom_demande,prix_demande,type_demande,date,heure,ville,code_postal,adresse,nb_heure,valide) VALUES(:nom_demande,:prix_demande,:type_demande,:date,:heure,:ville,:code_postal,:adresse,:nb_heure,:valide)");
        $insertdemande->execute(array
            ("nom_demande" => $name,
                "prix_demande" => $tarif,
                "type_demande" => $type,
                "date" => $date,
                "heure" => $heure,
                "ville" => $ville,
                "code_postal" => $code_postal,
                "adresse" => $adresse,
                "nb_heure" => $nb_heure,
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

        //update nombre d'heure restante
        $sous_nb_heure = $bdd->prepare("update abonnement_test set heure_restante=? where id_membre = ? ");
        $sous_nb_heure->execute(array($nb_heure_exist['heure_restante'] - $nb_heure, $_SESSION['id']));

        header('Location:DemandeService.php?demande=1');
    } else {
        header('Location: DemandeService.php?nb_heure=neg');
    }

    // Si non affichage d'un message avec choix (1- abonnement sup | 2 - paiement le prix du service)
}

if (isset($_POST['fermer'])) {
    header('Location:DemandeService.php');

}
