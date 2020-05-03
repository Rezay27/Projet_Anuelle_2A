<?php
session_start();
require_once "../include/connect_bdd.php";
require_once "configPay.php";

if(isset($_POST['savedemandepoint'])){
    $tableau = htmlspecialchars($_POST['tableau_demande']);
    echo $tableau;
    $tableau1 = explode('-', $tableau);
    var_dump($tableau1);

    $point_total = end($tableau1);

    $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
    $abonnement ->execute(array($_SESSION['id']));
    $abonnement_exist = $abonnement ->fetch();

    $newpoint = $abonnement_exist['nb_point'] - $point_total;

    $numero_d = $bdd->prepare('select ref_devis from demandes order by ref_devis DESC LIMIT 0, 1');
    $numero_d->execute(array());
    $last_devis = $numero_d->fetch();
    $last_devis = $last_devis['ref_devis'] +1;

    $adresse = htmlspecialchars($_POST['adresse']);
    $ville = htmlspecialchars($_POST['ville']);
    $cp = htmlspecialchars($_POST['cp']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['heure']);
    $description = htmlspecialchars($_POST['description']);
    $devis = htmlspecialchars($_POST['devis']);
    $facture = htmlspecialchars($_POST['facture']);

        if($newpoint < 0){

            header('Location: DemandeService.php?ok=nbpointneg');

        }else {

            for ($i = 0; $i < sizeof($tableau1) - 1; $i++) {
                $name = $tableau1[$i];
                $i++;
                $nb_heure = $tableau1[$i];
                $i++;
                $taux_h = $tableau1[$i];
                $i++;
                $prix_t = $tableau1[$i];

                $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,point_unite,point_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande,ref_devis,ref_facture) values (:id_membre,:nom,:nb_heure,:point_unite,:point_demande,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant,:devis ,:facture)');
                $insert->execute(array(
                    "id_membre"=>$_SESSION['id'],
                    "nom" => $name,
                    "nb_heure" => $nb_heure,
                    "point_unite" => $taux_h,
                    "point_demande" => $prix_t,
                    "type_demande" => 'simple',
                    "date_demande" => $date,
                    "heure" => $time,
                    "ville" => $ville,
                    "cp" => $cp,
                    "adresse" => $adresse,
                    "statue" => 0,
                    "intervenant" => NULL,
                    "devis" => $devis,
                    "facture"=> $facture

                ));

            $update_point = $bdd->prepare("UPDATE abonnement_test set nb_point = ? WHERE id_membre = ?  ");
            $update_point->execute(array($newpoint, $_SESSION['id']));
            }
    header('Location:DemandeService.php?ok=sucess&&tableau='.$tableau);


    }
}else {
    \Stripe\Stripe::setVerifySslCerts(false);

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
    $productID = $_GET['id'];

    if (!isset($_POST['stripeToken'])) {
        header("Location: DemandeService.php");
        exit();
    }

    $token = $_POST['stripeToken'];
    $email = $_POST["stripeEmail"];


    $tableau = htmlspecialchars($_POST['tableau_demande']);
    echo $tableau;
    $tableau1 = explode('-', $tableau);
    var_dump($tableau1);

    $prix_total = end($tableau1);


    $charge = \Stripe\Charge::create(array(
        "amount" => $prix_total * 100,
        "currency" => "usd",
        "description" => "descri",
        "source" => $token,
    ));
    $numero_d = $bdd->prepare('select ref_devis from demandes order by ref_devis DESC LIMIT 0, 1');
    $numero_d->execute(array());
    $last_devis = $numero_d->fetch();
    $last_devis = $last_devis['ref_devis'] + 1;

    $adresse = htmlspecialchars($_POST['adresse']);
    $ville = htmlspecialchars($_POST['ville']);
    $cp = htmlspecialchars($_POST['cp']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['heure']);
    $description = htmlspecialchars($_POST['description']);
    $devis = htmlspecialchars($_POST['devis']);
    $facture = htmlspecialchars($_POST['facture']);

    var_dump($facture);
    for ($i = 0; $i < sizeof($tableau1) - 1; $i++) {
        $name = $tableau1[$i];
        $i++;
        $nb_heure = $tableau1[$i];
        $i++;
        $taux_h = $tableau1[$i];
        $i++;
        $prix_t = $tableau1[$i];

        $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,taux_horaire,prix_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande,ref_devis,ref_facture) values (:id_membre,:nom,:nb_heure,:taux_horaire,:prix_demandes,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant,:devis,:facture )');
        $insert->execute(array(
            "id_membre"=>$_SESSION['id'],
            "nom" => $name,
            "nb_heure" => $nb_heure,
            "taux_horaire" => $taux_h,
            "prix_demandes" => $prix_t,
            "type_demande" => 'simple',
            "date_demande" => $date,
            "heure" => $time,
            "ville" => $ville,
            "cp" => $cp,
            "adresse" => $adresse,
            "statue" => 0,
            "intervenant" => NULL,
            "devis" => $devis,
            "facture"=> $facture
        ));

        header('Location:DemandeService.php?ok=sucess');

    }
}