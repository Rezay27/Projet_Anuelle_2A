<?php session_start(); ?>
<?php require('../include/connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Demande & Service</title>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/services.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link rel="stylesheet" href="../../css/css.css">
</head>
<body>
<?php include('../include/header.php'); ?>

<div class="bloc1">
    <h3> Que voulez-vous ? </h3>
<div style="font-size: 40px;text-decoration: underline">
        <a class="submit " href="DemandeService.php">Un service Simple</a>
        <a class="submit " href="../stripe/abonnement.php">Un service Récurrent</a>
    </div>
</div>
<?php include('../include/footer.php'); ?>
</body>
</html>
