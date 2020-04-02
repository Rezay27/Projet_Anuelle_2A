<?php
session_start();
    require_once "../include/connect_bdd.php";
	require_once "config.php";


	\Stripe\Stripe::setVerifySslCerts(false);

	// Token is created using Checkout or Elements!
	// Get the payment token ID submitted by the form:
	$productID = $_GET['id'];

	if (!isset($_POST['stripeToken']) || !isset($products[$productID])) {
		header("Location: pricing.php");
		exit();
	}

    $token = $_POST['stripeToken'];
    $email = $_POST["stripeEmail"];


    // Charge the user's card:
    $charge = \Stripe\Charge::create(array(
        "amount" => $products[$productID]["price"],
        "currency" => "usd",
        "description" => $products[$productID]["title"],
        "source" => $token,
    ));

	$info_abonnements = $bdd ->prepare("select type_abonnement.id,nb_heure from type_abonnement inner join info_abonnement on type_abonnement.id = info_abonnement.type_abonnement where type_abonnement.nom = ? ");
	$info_abonnements -> execute(array($products[$productID]["title"]));
	$info_abonnement = $info_abonnements -> fetch();

	$abonnement_membre=$bdd->prepare("select * from abonnement_test where id_membre = ? ");
	$abonnement_membre->execute(array($_SESSION['id']));
	$abonnement_membres = $abonnement_membre -> fetch();

    if(isset($abonnement_membres['id'])){
        $update_abonnement=$bdd->prepare("update abonnement_test set type_abonnement= ? , date_paiement = NOW(), heure_restante=?, fin_abonnement=DATE_ADD(NOW(),INTERVAL 1 month) where id_membre = ? ");
        $update_abonnement->execute(array( $info_abonnement['id'],$info_abonnement['nb_heure'],$_SESSION['id']));
    }else {
        $insert_abonnement = $bdd->prepare("insert into abonnement_test(type_abonnement,date_paiement,heure_restante,id_membre,fin_abonnement) VALUES (:type_abonnement,NOW(),:heure_restante,:id_membre,DATE_ADD(NOW(),INTERVAL 1 month))");
        $insert_abonnement->execute(array(
            "type_abonnement" => $info_abonnement['id'],
            "heure_restante" => $info_abonnement['nb_heure'],
            "id_membre" => $_SESSION['id'],
        ));
    }
    header('Location:pricing.php');
    echo 'Success! You have been charged $' . ($products[$productID]["price"]/100);
?>