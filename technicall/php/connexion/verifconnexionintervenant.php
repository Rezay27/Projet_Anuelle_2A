<?php
session_start();
include('../include/connect_bdd.php');
//  Récupération de l'utilisateur et de son pass hashé
if(isset($_POST['formconnect'])){

    $email = htmlspecialchars($_POST['emailconnect']);

    $req = $bdd->prepare('SELECT id, mdp,valide FROM intervenant WHERE mail = :email');

    $req->execute(array('email' => $email));

    $resultat = $req->fetch();


    // Comparaison du pass envoyé via le formulaire avec la base

    if ($_POST['mdpconnect'] == $resultat['mdp']) {
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['email'] = $email;
        if($resultat['valide']==0) {
            header("Location:changermdpintervenantnew.php?id={$_SESSION['id']}");
        }else{
            header("Location:../index/index.php");

        }
    }

    else
    {

        ?>
        <script type="text/javascript">
            alert("Mauvais identifiant ou mot de passe !");
            document.location.href = 'connexionintervenant.php';
        </script>
        <?php
    }
}

?>
