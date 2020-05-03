<?php session_start();
include('../include/connect_bdd.php');

if(isset($_POST['valider']))
{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $prenom = htmlspecialchars($_POST['prenom']);
  $nom = htmlspecialchars($_POST['nom']);
  $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
  $email = htmlspecialchars($_POST['email']);
  $gender = $_POST['civility'];
  $date_naissance =  htmlspecialchars($_POST['date_naissance']);
  $adresse = htmlspecialchars($_POST['adresse']);
  $ville = htmlspecialchars($_POST['ville']);
  $code_postal = htmlspecialchars($_POST['code_postal']);

  $reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = ?");
  $reqpseudo->execute(array("$pseudo"));
  $pseudoexist = $reqpseudo->rowCount();
  if($pseudoexist == 0)
  {
    $reqemail = $bdd->prepare("SELECT * FROM membre WHERE email = ?");
    $reqemail->execute(array("$email"));
    $emailexist = $reqemail->rowCount();
    if($emailexist == 0 ) {
      $insertmbr = $bdd->prepare("INSERT INTO membre(pseudo,prenom,nom,mdp,email,date_naissance,adresse,ville,code_postal,date_creation) VALUES(:pseudo,:prenom,:nom,:password,:email,:dateNaissance,:adresse,:ville,:code_postal,NOW())");
      $insertmbr->execute(array
          ("pseudo" => htmlspecialchars($_POST['pseudo']),
              "prenom" => $prenom,
              "nom" => $nom,
              "password" => $password,
              "email" => htmlspecialchars($_POST['email']),
              "dateNaissance" => htmlspecialchars($_POST['date_naissance']),
              "adresse" => $adresse,
              "ville" => $ville,
              "code_postal" =>htmlspecialchars($_POST['code_postal'])
          )
      );
          }

      header('Location:../index/index.php?inscri=ok');
    }


else
{
  header('Location:inscription.php');
}
}

?>
