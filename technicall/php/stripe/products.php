<?php
$abonnement1 = $bdd->query("SELECT * from type_abonnement INNER JOIN info_abonnement ON type_abonnement.id = info_abonnement.type_abonnement WHERE type_abonnement.id = 1");
$abonnements1 = $abonnement1->fetch();
$abonnement2 = $bdd->query("SELECT * from type_abonnement INNER JOIN info_abonnement ON type_abonnement.id = info_abonnement.type_abonnement WHERE type_abonnement.id = 2");
$abonnements2 = $abonnement2->fetch();
$abonnement3 = $bdd->query("SELECT * from type_abonnement INNER JOIN info_abonnement ON type_abonnement.id = info_abonnement.type_abonnement WHERE type_abonnement.id = 3");
$abonnements3 = $abonnement3->fetch();
$products = array(
    "product1" => array(
        "title" => $abonnements1['nom'],
        "price" => $abonnements1['prix'],
        "features" => array(" -  " . $abonnements1['description1'], " -  " . $abonnements1['description2'], " -  " . $abonnements1['description3'])
    ),
    "product2" => array(
        "title" => $abonnements2['nom'],
        "price" => $abonnements2['prix'],
        "features" => array(" -  " . $abonnements2['description1'], " -  " . $abonnements2['description2'], " -  " . $abonnements2['description3'])
    ),
    "product3" => array(
        "title" => $abonnements3['nom'],
        "price" => $abonnements3['prix'],
        "features" => array(" -  " . $abonnements3['description1'], " -  " . $abonnements3['description2'], " -  " . $abonnements3['description3'])
    )
);
?>