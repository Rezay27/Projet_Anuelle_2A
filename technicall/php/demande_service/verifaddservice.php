<?php session_start();
include('../include/connect_bdd.php');

if(isset($_POST['abo_valider']))
{
    $name = htmlspecialchars($_POST["addname"]);
    $tarif = htmlspecialchars($_POST["addtarif"]);
    $nb_heure = htmlspecialchars($_POST["nb_heure"]);
    $ville = htmlspecialchars($_POST["addville"]);
    $adresse = htmlspecialchars($_POST["addadresse"]);
    $cp = htmlspecialchars($_POST["addcode_postal"]);
    $date = htmlspecialchars($_POST["adddateservice"]);
    $heure = htmlspecialchars($_POST["addheureservice"]);
    $id = $_SESSION['id'];

    $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,point_unite,point_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande) values (:id_membre,:nom,:nb_heure,:point_unite,:point_demande,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant)');
    $insert->execute(array(
        "id_membre"=>$id,
        "nom" => $name,
        "nb_heure" => $nb_heure,
        "point_unite" => ($tarif/$nb_heure),
        "point_demande" => $tarif,
        "type_demande" => 'perso',
        "date_demande" => $date,
        "heure" => $heure,
        "ville" => $ville,
        "cp" => $cp,
        "adresse" => $adresse,
        "statue" => 0,
        "intervenant" => NULL
    ));

    header('Location:DemandeService.php?ok=sucess');


}

if(isset($_POST['nonabo_valider']))
{
    $name = htmlspecialchars($_POST["addname"]);
    $tarif = htmlspecialchars($_POST["addtarif"]);
    $nb_heure = htmlspecialchars($_POST["nb_heure"]);
    $ville = htmlspecialchars($_POST["addville"]);
    $adresse = htmlspecialchars($_POST["addadresse"]);
    $cp = htmlspecialchars($_POST["addcode_postal"]);
    $date = htmlspecialchars($_POST["adddateservice"]);
    $heure = htmlspecialchars($_POST["addheureservice"]);
    $id = $_SESSION['id'];

    $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,taux_horaire,prix_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande) values (:id_membre,:nom,:nb_heure,:taux_horaire,:prix_demande,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant)');
    $insert->execute(array(
        "id_membre"=>$id,
        "nom" => $name,
        "nb_heure" => $nb_heure,
        "taux_horaire" => ($tarif/$nb_heure),
        "prix_demande" => $tarif,
        "type_demande" => 'perso',
        "date_demande" => $date,
        "heure" => $heure,
        "ville" => $ville,
        "cp" => $cp,
        "adresse" => $adresse,
        "statue" => 0,
        "intervenant" => NULL
    ));

    header('Location:DemandeService.php?ok=sucess');


}
?>