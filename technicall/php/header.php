<?php

include('connect_bdd.php');
$reponse = $bdd->query("SELECT * FROM membre WHERE admin = 1");
$donnees = $reponse -> fetch();


?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<header>
    <nav>
        <img id='logo'  src="../images/Logo_TechniCall.png" alt="Geekkeeg">
        <ul>

            <?php
            /*$isconnected = $_GET['connected'];*/
            if(!isset($_SESSION['pseudo'])){
                echo "<li><a href=\"index.php\">Accueil<i class=\"fas fa-home\"></i></a></li>";
                echo  "<li><a href=\"inscription.php\">Inscription<i class=\"fas fa-check\"></i></a></li>";
                echo "<li><a href=\"connexion.php\">Connexion<i class=\"fas fa-sign-in-alt\"></i></a></li>";
            }else{
                echo "<li><a href=\"index.php\">Accueil<i class=\"fas fa-home\"></i></a></li>";
                echo "<li><a href=\"DemandeService.php\">Demande & Service<i class=\"fas fa-users-cog\"></i></a></li>";
                echo "<li><a href=\"stripe/pricing.php\">Abonnement<i class=\"fas fa-users-cog\"></i></a></li>";
                if($donnees['pseudo']==$_SESSION['pseudo']){
                    echo "<li><a href=\"gestionBOMembre.php\">BackOffice<i class=\"fas fa-wrench\"></i></a></li>";
                }
                echo "<li><a href=\"deconnexion.php\">Déconnexion<i class=\"fas fa-sign-out-alt\"></i></a></li>";
            }
            ?>
        </ul>
    </nav>
</header>