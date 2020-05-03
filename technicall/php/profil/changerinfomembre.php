<?php session_start(); ?>
<?php require('../include/connect_bdd.php');

$select_intervenant = $bdd ->prepare('select * from membre where id_membre = ? ');
$select_intervenant ->execute(array($_SESSION['id']));
$inter = $select_intervenant->fetch();
$id= $_SESSION['id'];

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
    <h1 style="text-align: center" class="page-header">Edition du profil</h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 personal-info">
            <h3>Information personnelles</h3>
            <form action="modifinfoprofil.php?id=<?=$id?>" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Prenom:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editprenom" value="<?php echo $inter['prenom'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Nom:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editnom" value="<?php echo $inter['nom'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editmail" value="<?php echo $inter['email'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Adresse:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editadresse" value="<?php echo $inter['adresse'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Ville:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editville" value="<?php echo $inter['ville'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Code Postal:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type ="text" name="editcp" value="<?php echo $inter['code_postal'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mot de passe:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="" name="editpassword" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="" name="editpasswordverif" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input class="btn btn-primary" value="Save Changes" name="save" type="submit">
                        <span></span>
                        <input class="btn btn-default" value="Cancel" type="reset">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('../include/footer.php'); ?>
</body>
</html>