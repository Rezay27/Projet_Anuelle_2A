<?php session_start(); ?>
<?php require('../include/connect_bdd.php');

$select_intervenant = $bdd ->prepare('select * from intervenant where id = ? ');
$select_intervenant ->execute(array($_SESSION['id_inter']));
$inter = $select_intervenant->fetch();
$id= $_SESSION['id_inter'];

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
    <h1 style="text-align: center" class="page-header">Saisissez votre nouveau mot de passe</h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 personal-info">
            <form action="modifinfoprofilinter.php?id=<?=$id?>" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label">Mot de passe:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="" name="editpassword" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirmer le mot de passe:</label>
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