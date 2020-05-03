<?php
session_start();
include('../include/connect_bdd.php');

if (isset($_POST['valider_role_bo'])) {
    $name = htmlspecialchars($_POST['nom_role']);

    $checkequal = $bdd->prepare("SELECT * FROM role WHERE nom_role = ?" );
    $checkequal->execute(array($name));
    $count=$checkequal->fetch();

    if ($count == null){
        $insert = $bdd->prepare("insert into role(nom_role) values (:nom_role)");
        $insert->execute(array(
            "nom_role" => $name,
        ));
    }



    header('Location:gestionBoRole.php');

}

