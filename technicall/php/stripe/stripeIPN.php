<?php
session_start();
require_once "../include/connect_bdd.php";
require_once "config.php";


\Stripe\Stripe::setVerifySslCerts(false);

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$productID = $_GET['id'];
if (!isset($_POST['stripeToken'])) {
    header("Location: pricing.php");
    exit();
}

$token = $_POST['stripeToken'];
$email = $_POST["stripeEmail"];

$abonnements = $bdd->prepare("SELECT * from type_abonnement INNER JOIN info_abonnement ON type_abonnement.id = info_abonnement.type_abonnement where type_abonnement.id = ?");
$abonnements->execute(array($productID));
$abonnement = $abonnements->fetch();

$pack =substr($abonnement['nom'],0,4);
var_dump(substr($abonnement['nom'],0,4));

$prix = $abonnement['prix'];
var_dump($prix);
// Charge the user's card:
$charge = \Stripe\Charge::create(array(
    "amount" => $prix,
    "currency" => "usd",
    "description" => $abonnement['nom'],
    "source" => $token,
));

$info_abonnements = $bdd->prepare("select type_abonnement.id,nb_point from type_abonnement inner join info_abonnement on type_abonnement.id = info_abonnement.type_abonnement where type_abonnement.nom = ? ");
$info_abonnements->execute(array($abonnement['nom']));
$info_abonnement = $info_abonnements->fetch();

$abonnement_membre = $bdd->prepare("select * from abonnement_test where id_membre = ? ");
$abonnement_membre->execute(array($_SESSION['id']));
$abonnement_membres = $abonnement_membre->fetch();

if (isset($abonnement_membres['id'])&& $pack != 'Pack') {
    $update_abonnement = $bdd->prepare("update abonnement_test set type_abonnement= ? , date_paiement = NOW(), nb_point=?,debut_abonnement=NOW(), fin_abonnement=DATE_ADD(NOW(),INTERVAL 1 month) where id_membre = ? ");
    $update_abonnement->execute(array($info_abonnement['id'], $info_abonnement['nb_point'], $_SESSION['id']));
} else if (isset($abonnement_membres['id'])&& $pack == 'Pack'){
    $update_abonnement_pack = $bdd->prepare("update abonnement_test set type_abonnement= ? , date_paiement = NOW(), nb_point=?,debut_abonnement=NOW(), fin_abonnement=DATE_ADD(NOW(),INTERVAL 1 month) where id_membre = ? ");
    $update_abonnement_pack->execute(array($info_abonnement['id'],($abonnement_membres["nb_point"]+ $info_abonnement['nb_point']), $_SESSION['id']));
} else {
    $insert_abonnement = $bdd->prepare("insert into abonnement_test(type_abonnement,date_paiement,nb_point,id_membre,debut_abonnement,fin_abonnement) VALUES (:type_abonnement,NOW(),:nb_point,:id_membre,NOW(),DATE_ADD(NOW(),INTERVAL 1 month))");
    $insert_abonnement->execute(array(
        "type_abonnement" => $info_abonnement['id'],
        "nb_point" => $info_abonnement['nb_point'],
        "id_membre" => $_SESSION['id'],
    ));
}

header('Location:abonnement.php?ok=ok');
?>