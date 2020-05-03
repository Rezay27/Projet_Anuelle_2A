<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');


$inter= $bdd->query("select id from intervenant where valide = 0");
$nb_new = $inter->rowCount();

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
                    <a href="gestionBOMembre.php">Membre</a>
                    <br>
                    <br>
                </div>
                <div class="divchoixdemande">
                    <a href="gestionBOAdmin.php">Admin</a>
                    <br>
                    <br>
                </div>
            </div>
            <div class="divchoixdemandeperso">
                <a href="gestionBOIntervenant.php">Intervenant</a>
                <br>
                <br>
                <span style="color:red;font-size: 12px;"> Nouveaux Intervenants : <?php echo $nb_new; ?>
            </div>
        </section>
    </div>

</main>
<?php include('../include/footer.php'); ?>
</body>
</html>
