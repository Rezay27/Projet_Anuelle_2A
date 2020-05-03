<?php session_start();
include('../include/connect_bdd.php');
if (isset($_POST['save'])) {


    $password = password_hash($_POST['editpassword'], PASSWORD_DEFAULT);
    $id = $_GET['id'];

    $update = $bdd->prepare('update intervenant set mdp=? where id = ? ');
    $update->execute(array($password, $id));

    header('Location: profil_inter?modif=ok');

}


?>