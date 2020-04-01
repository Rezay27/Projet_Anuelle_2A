<?php
session_start();
include('connect_bdd.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>PageConnexion</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/css.css" media="screen" type="text/css" />
</head>

<body>
  <?php include("header.php"); ?>

  <main>

    <div>
      <h1 class="bloc1">Se connecter</h1>
      <section class="bloc1">
        <form action="verifconnexion.php"  method="post">
          <div>
            <label>Utilisateur</label>
            <input type="text" name="pseudoconnect" placeholder="Pseudo" value="<?php if(isset($pseudoconnect)){echo $pseudoconnect;}?>">
          </div>
          <div>
            <label>Mot de passe</label>
            <input type="password" name="mdpconnect" placeholder="Mot de passe">
          </div>
          <div>
            <label for=""></label>
            <input class="submit" type="submit"  value="Connexion" name="formconnect">
          </div>
        </form>
<BR>
        <a href="inscription.php">Je n'ai pas de compte ! </a>

        <div class="erreur">
          <?php  if(isset($erreur))
          {
            echo $erreur."<br>";
          }
          ?>
        </div>


      </div>
    </section>
  </main>
</body>
</html>
