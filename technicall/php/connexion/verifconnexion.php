<?php
session_start();
include('../include/connect_bdd.php');
//  Récupération de l'utilisateur et de son pass hashé
if(isset($_POST['formconnect'])){

  $pseudo = htmlspecialchars($_POST['pseudoconnect']);

  $req = $bdd->prepare('SELECT id_membre, mdp FROM membre WHERE pseudo = :pseudo');

  $req->execute(array('pseudo' => $pseudo));

  $resultat = $req->fetch();


  // Comparaison du pass envoyé via le formulaire avec la base
  $isPasswordCorrect = password_verify($_POST['mdpconnect'], $resultat['mdp']);

  if ($isPasswordCorrect) {
          $_SESSION['id'] = $resultat['id_membre'];
          $_SESSION['pseudo'] = $pseudo;

        header("Location: index.php");
     }

      else
      {

        ?>
        <script type="text/javascript">
        alert("Mauvais identifiant ou mot de passe !");
        document.location.href = 'connexion.php';
        </script>
        <?php
      }
}

?>
