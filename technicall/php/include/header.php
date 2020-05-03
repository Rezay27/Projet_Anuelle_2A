<?php

include('../include/connect_bdd.php');
if(isset($_SESSION['id'])) {
    $reponse = $bdd->prepare("SELECT admin FROM membre WHERE id_membre = ?");
    $reponse->execute(array($_SESSION['id']));
    $admin = $reponse->fetch();
}

if(isset($_SESSION['id'])) {
    $abonnement = $bdd->prepare("select * from abonnement_test where id_membre = ? ");
    $abonnement->execute(array($_SESSION['id']));
    $abonnement_exist = $abonnement->fetch();
}
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<header>
    <nav>
        <img id='logo' src="../../images/Logo_TechniCall.png" alt="Geekkeeg">
        <ul>

            <?php
            /*$isconnected = $_GET['connected'];*/
            if (!isset($_SESSION['pseudo'])&&!isset($_SESSION['id_inter'])) {
                echo "<li><a href=\"../index/index.php\">Accueil<i class=\"fas fa-home\"></i></a></li>";
                echo "<li><a href=\"../inscription/inscription.php\">Inscription<i class=\"fas fa-users-cog\"></i></i></a></li>";
                echo "<li><a href=\"../connexion/connexion.php\">Connexion<i class=\"fas fa-users-cog\"></i></i></a></li>";
            } else if(isset($_SESSION['pseudo'])) {
                echo "<li><a href=\"../index/index.php\">Accueil<i class=\"fas fa-home\"></i></a></li>";
                if (isset($abonnement_exist['id_membre'])) {
                    echo "<li><a href=\"../demande_service/DemandeService.php\">Demande et Service<i class=\"fas fa-users-cog\"></i></i></a></li>";
                } else {

                    echo "<li><a href=\"../demande_service/choice_service.php\">Demande et Service<i class=\"fas fa-users-cog\"></i></i></a></li>";
                }
                echo "<li><a href=\"../stripe/abonnement.php\">Abonnement<i class=\"fas fa-users-cog\"></i></a></li>";
                if (1 == $admin['admin']) {
                    echo "<li><a href=\"../back_office/gestionBOMembre.php\">Back Office<i class=\"fas fa-users-cog\"></i></i></a></li>";
                }
                echo "<li><a href=\"../connexion/deconnexion.php\">Deconnexion<i class=\"fas fa-users-cog\"></i></i></a></li>";
            }else if(isset($_SESSION['id_inter'])){
                $id_inter = $_SESSION['id_inter'];
                echo "<li><a href=\"../index/index.php\">Accueil<i class=\"fas fa-home\"></i></a></li>";
                echo "<li><a href=\"../profil/profil.php?id=".$_SESSION['id_inter']."\" >Profil<i class=\"fas fa-users-cog\"></i></a></li>";
                echo "<li><a href=\"../connexion/deconnexion.php\">Deconnexion<i class=\"fas fa-users-cog\"></i></i></a></li>";
            }
            ?>
        </ul>
    </nav>
</header>
