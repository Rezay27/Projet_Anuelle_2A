<?php
include_once('../multi_langue/multiLangue.php');
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
                echo "<li><a href=\"../index/index.php\">".HOME."<i class=\"fas fa-home\"></i></a></li>";
                echo "<li><a href=\"../inscription/inscription.php\">".REGISTER."<i class=\"fas fa-users-cog\"></i></i></a></li>";
                echo "<li><a href=\"../connexion/connexion.php\">".CONNECT."<i class=\"fas fa-users-cog\"></i></i></a></li>";
            } else if(isset($_SESSION['pseudo'])) {
                echo "<li><a href=\"../index/index.php\">".HOME."<i class=\"fas fa-home\"></i></a></li>";
                if (isset($abonnement_exist['id_membre'])) {
                    echo "<li><a href=\"../demande_service/DemandeService.php\">".REQUEST."<i class=\"fas fa-users-cog\"></i></i></a></li>";
                } else {

                    echo "<li><a href=\"../demande_service/choice_service.php\">".REQUEST."<i class=\"fas fa-users-cog\"></i></i></a></li>";
                }
                echo "<li><a href=\"../profil/profil_membre.php?id=".$_SESSION['id']."\" >".PROFIL."<i class=\"fas fa-users-cog\"></i></a></li>";
                echo "<li><a href=\"../stripe/abonnement.php\">".SUBSCRIPTION."<i class=\"fas fa-users-cog\"></i></a></li>";
                if (1 == $admin['admin']) {
                    echo "<li><a href=\"../back_office/gestionBOMembre.php\">".BO."<i class=\"fas fa-users-cog\"></i></i></a></li>";
                }
                echo "<li><a href=\"../connexion/deconnexion.php\">".DISCONNECT."<i class=\"fas fa-users-cog\"></i></i></a></li>";
            }else if(isset($_SESSION['id_inter'])){
                $id_inter = $_SESSION['id_inter'];
                echo "<li><a href=\"../index/index.php\">".HOME."<i class=\"fas fa-home\"></i></a></li>";
                echo "<li><a href=\"../profil/profil_inter.php?id=".$_SESSION['id_inter']."\" >".PROFIL."<i class=\"fas fa-users-cog\"></i></a></li>";
                echo "<li><a href=\"../connexion/deconnexion.php\">".DISCONNECT."<i class=\"fas fa-users-cog\"></i></i></a></li>";
            }
            echo '<li><form method="post" action="../index/index.php" ><select name="langue" onchange="this.form.submit()">',"n";
            echo "\t",'<option value="', $_SESSION['langue'] ,'">', $_SESSION['langue'] ,'</option>',"\n";
            foreach($matchedfiles as $file)
            {
                if ($file!=$_SESSION['langue']){
                    echo "\t",'<option value="', $file ,'">', $file ,'</option>',"\n";
                }
            }
            echo '</select></form></li>',"\n";
            ?>
        </ul>
    </nav>
</header>
