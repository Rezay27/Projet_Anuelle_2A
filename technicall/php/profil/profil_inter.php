<?php session_start(); ?>
<?php require('../include/connect_bdd.php');

$select_intervenant = $bdd ->prepare('select * from intervenant where id = ? ');
$select_intervenant ->execute(array($_SESSION['id_inter']));
$inter = $select_intervenant->fetch();


?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="../../css/css.css">
</head>
<body>
<?php  include('../include/header.php');?>



<div class="container" style="padding-top: 60px;">
    <h1 class="page-header" style="text-align: center;text-decoration: underline">Profil</h1>
    <div class="row">
        <?php
        if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
            echo '<div class="alert alert-info alert-dismissable">
        <a class="panel-close close" data-dismiss="alert">×</a> 
        <i class="fa fa-coffee"></i>
        Le mot de passe a bien été modifié .
      </div>';
        }

        ?>
        <div class="col-md-12 col-sm-12 col-xs-12 personal-info">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Prenom:</label>
                    <div class="col-lg-8">
                        <p class="form-control">   <?php echo $inter['prenom'];?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nom:</label>
                    <div class="col-lg-8">
                        <p class="form-control"> <?php echo $inter['nom'];?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <p class="form-control">  <?php echo $inter['mail'];?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Adresse:</label>
                    <div class="col-lg-8">
                        <p class="form-control">   <?php echo $inter['adresse']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Ville:</label>
                    <div class="col-lg-8">
                        <p class="form-control">   <?php echo $inter['ville']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Date de naissance:</label>
                    <div class="col-lg-8">
                        <p class="form-control">   <?php echo $inter['birthdate']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">QrCode:</label>
                    <div class="col-lg-8">
                        <p class="form-control"> <?php echo $inter['nomQrCode']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <button formaction="changerinfointer.php?" class="btn btn-primary">Changer son mot de passe
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
</body>
</html>
