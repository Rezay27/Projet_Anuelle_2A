<?php session_start();
include('../include/connect_bdd.php');
if (isset($_POST['save'])) {

    $nom = htmlspecialchars($_POST['editnom']);
    $prenom = htmlspecialchars($_POST['editprenom']);
    $email = htmlspecialchars($_POST['editmail']);
    $adresse = htmlspecialchars($_POST['editadresse']);
    $ville = htmlspecialchars($_POST['editville']);
    $cp = htmlspecialchars($_POST['editcp']);
    $password = password_hash($_POST['editpassword'], PASSWORD_DEFAULT);
    $id = $_GET['id'];
    $update = $bdd->prepare('update membre set nom= ? , prenom= ? , email =? , adresse = ? , ville =? , code_postal = ? ,mdp=? where id_membre = ? ');
    $update->execute(array($nom, $prenom, $email, $adresse, $ville, $cp, $password, $id));

    header('Location: profil_membre?modif=ok');

}


?>