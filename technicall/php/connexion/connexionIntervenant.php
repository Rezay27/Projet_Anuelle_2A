<?php
session_start();
include('../include/connect_bdd.php');
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
        <h1 class="bloc1">Se connecter</h1>
        <section class="bloc1">
            <form action="verifconnexionintervenant.php" method="post">
                <div>
                    <label>Email</label>
                    <input type="text" name="emailconnect" placeholder="Email"
                           value="<?php if (isset($emailconnect)) {
                               echo $emailconnect;
                           } ?>">
                </div>
                <div>
                    <label>Mot de passe reçu par mail</label>
                    <input type="password" name="mdpconnect" placeholder="Mot de passe">
                </div>
                <div>
                    <label for=""></label>
                    <input class="submit" type="submit" value="Connexion" name="formconnect">
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
