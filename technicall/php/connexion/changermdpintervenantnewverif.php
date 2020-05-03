<?php
session_start();
include('../include/connect_bdd.php');
//  Récupération de l'utilisateur et de son pass hashé
if(isset($_POST['changemdpnew'])){

    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $id=$_GET['id'];

    $req = $bdd->prepare('update intervenant set mdp = ? , valide = ? where id = ? ');

    $req->execute(array($password,1,$id));

header('Location:../index/index.php');


};

?>
