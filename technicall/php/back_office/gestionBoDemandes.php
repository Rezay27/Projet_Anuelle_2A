<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
$non_abo = $bdd->query("select nom_demande from demandes where statut_demande = 0 AND id_intervenant_demande is null AND type_demande='simple' AND point_demande is null and date_demande > now() GROUP BY ref_devis");
$nb_nonabo = $non_abo->rowCount();

$abo = $bdd->query("select id_demandes from demandes where statut_demande = 0 AND id_intervenant_demande is null AND type_demande='simple' AND point_demande is not null and date_demande > now()  GROUP BY ref_devis ");
$nb_abo = $abo->rowCount();

$perso = $bdd->query("select id_demandes from demandes where statut_demande = 0 AND id_intervenant_demande is null AND type_demande='perso' AND date_demande > now() and ref_devis is null and refuser = 0");
$nb_perso = $perso->rowCount();

?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="../../css/css.css" rel="stylesheet">

        <title>Gestion Demandes BO</title>
    </head>
<body>
<?php include('../include/header.php'); ?>
    <main>
<?php include('gestionBomenue.php'); ?>

        <div class="divBO">
            <section  class="bloc1BO ">
                <div class="boutonhautperso">
                <div class="divchoixdemande">
                    <a href="gestionBoDemandesNonAbo.php">Demande Non Abonnées</a>
                    <br>
                    <br>
                    <span style="color:red;font-size: 12px;"> En attente d'affectation : <?php echo $nb_nonabo; ?>
                </div>
                <div class="divchoixdemande">
                    <a href="gestionBoDemandesAbo.php">Demande Abonnées</a>
                    <br>
                    <br>
                    <span  style="color:red;font-size: 12px;"> En attente d'affectation : <?php echo $nb_abo; ?>
                </div>
                </div>
                <div class="divchoixdemandeperso">
                    <a href="gestionBoDemandesPerso.php">Demande Personnalisées</a>
                    <br>
                    <br>
                    <span style="color:red;font-size: 12px;"> Demande non traitées : <?php echo $nb_perso; ?>
                </div>
            </section>
        </div>

    </main>
<?php include('../include/footer.php'); ?>
</body>
</html>
