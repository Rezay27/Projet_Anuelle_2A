<?php session_start();
/*$chemin = getcwd();
echo $chemin;*/ ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../../css/css.css">
  <title>Inscription</title>
    <script type="text/css">
        footer{
            position: absolute;
            margin-bottom: 0;
            padding: 0;
            width: 100%;
            background-color:#231D29;
        }
    </script>
</head>
<body>
  <?php include("../include/header.php"); ?>
  <main>
    <h1 class="bloc1">Inscription</h1>
    <section class="bloc1" >
      <form id="inscription" action="verifinscription.php" name="inscription" method="post" enctype="multipart/form-data" onsubmit="return verifF(this)" type="formulaire">
        <div>
          <label class="civi">Civilite</label>
          <div class="element">
            <input id="homme"class="civility" name="civility" value ="1"   type="radio" value="<?php if(isset($_POST['civility']) && $_POST['civility']!="" ) echo $_POST['civility'];?>" />
            <label class="radio" for="homme">Homme</label>
          </div>
          <div class="element">
            <input id="femme" class="civility" name="civility" value="0"  type="radio" value="<?php if(isset($_POST['civility']) && $_POST['civility']!="" ) echo $_POST['civility'];?>" checked/>
            <label class="radio"for="femme">Femme</label>
          </div>
          <div class="element">
            <input id="nongenre" class="civility" name="civility" value="2"  type="radio" value="<?php if(isset($_POST['civility']) && $_POST['civility']!="" ) echo $_POST['civility'];?>" checked/>
            <label class="radio"for="nongenre">Non genré</label>
          </div>
        </div>
        <!-- Pseudo -->
        <div>
          <label for="pseudo">Pseudo </label>
          <span id="erreur"></span>
          <input onblur="verifPseudo(this)" id="pseudo" type="text" name="pseudo" placeholder="Pseudo" value="<?php if(isset($_POST['pseudo']) && $_POST['pseudo']!="" ) echo $_POST['pseudo'];?>"/>
        </div>
        <!-- Prenom -->
        <div>
          <label for="prenom">Prenom </label>
          <span id="erreur1"></span><br>
          <input onblur="verifPrenom(this)" id="prenom" type="text" name="prenom" placeholder="Prenom" value="<?php if(isset($_POST['prenom']) && $_POST['prenom']!="" ) echo $_POST['prenom'];?>"/>
        </div>
        <!-- Nom -->
        <div class="">
          <label for="nom"> Nom </label>
          <span id="erreur2"></span><br>
          <input onblur="verifNom(this)" id="nom" type="text" name="nom" placeholder="Nom" value="<?php if(isset($_POST['nom']) && $_POST['nom']!="" ) echo $_POST['nom'];?>"/>
        </div>
        <!-- Mot de passe -->
        <div class="">
          <label for="password"> Mot de Passe </label>
          <span id="erreur3"></span><br>
          <input onblur="verifMdp(this)" id="password" type="password" name="password" placeholder="Mot de Passe" />
          <span id="erreur4"></span><br>
          <input onblur="verifMdp2(this)" id="password_conf" type="password" name="conf_password" placeholder="Confirmation Mot de Passe" />
        </div>
        <!-- Email -->
        <div class="">
          <label for"email"> Email </label>
          <span id="erreur5"></span><br>
          <input id='email' class="modif" type="text" placeholder="Email" name="email" onblur="verifMail(this)" value="<?php if(isset($_POST['email']) && $_POST['email']!="" ) echo $_POST['email'];?>"/>
          <span id="erreur6"></span><br>
          <input onblur="verifMail2(this)" id="email_conf" type="text" name="conf_email" placeholder="Confirmation Email"  />
        </div>
        <!-- Date de naissance -->
        <div class="">
          <label for="date_naissance">Date de Naissance</label>
          <span id="erreur7"></span><br>
          <input onblur="verifBirth(this)" id="date_naissance" type="date" name="date_naissance" placeholder="Date de Naissance" min = "1919-01-01" max= "2001-01-11" value=""/>
        </div>
          <!-- Code postal-->
          <div class="">
              <label for="code_postal">Code Postal</label>
              <span id="erreur8"></span></br>
              <input onblur="verifCode(this)" id="code_postal" type="text" name="code_postal" placeholder="Code Postal"/>
          </div>
            <!-- Condition utilisation -->
            <div class="element_coche">
              <label for="accepter"></label>
              <input onblur="verifBox(this)" id="checkbox"value="1" class="accepter" type="checkbox" name="condition"/>   </input>
              <label id="coche" for="checkbox">J'accepte les <a href="../index/conditionG.php" target="_blank"> conditions générales</a>.</label>
            </div>
            <!-- Validation -->
            <div>
              <label for="envoyer"></label>
              <input class="submit" type="submit" name="valider" value="Valider"/>
            </div>
          </form>
        </section>
      </main>
      <script type="text/javascript" src="../../js/inscription.js"></script>
      <?php include('../include/footer.php');?>
    </body>
    </html>
