<?php
session_start();
include('../include/connect_bdd.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>PageConnexion</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/css.css" media="screen" type="text/css"/>
</head>

<body>
<?php include("../include/header.php"); ?>

<main>

    <div>
        <h1 class="bloc1">Changer le mot de passe</h1>
        <section class="bloc1">
            <form action="changermdpintervenantnewverif.php?id=<?=$id?>" method="post">
                <div>
                    <label>Nouveau Mot de passe</label>
                    <input type="password" name="password" placeholder="Mot de passe">
                </div>
                <div>
                    <label>Nouveau Mot de passe</label>
                    <input type="password" name="password_conf" placeholder="Confirmer le mot de passe">
                </div>
                <div>
                    <label for=""></label>
                    <input class="submit" type="submit" value="Connexion" name="changemdpnew">
                </div>
            </form>

            <div class="erreur">
                <?php if (isset($erreur)) {
                    echo $erreur . "<br>";
                }
                ?>
            </div>


    </div>
    </section>
</main>
</body>
</html>
