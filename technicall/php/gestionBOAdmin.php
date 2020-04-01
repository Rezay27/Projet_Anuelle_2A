<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('connect_bdd.php');
$reponse = $bdd->query("SELECT * FROM membre WHERE id_membre='{$_SESSION['id']}'");
$admin = $reponse -> fetch();
if($admin['admin']==1){
    if(isset($_POST['Modifier'])) {
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $base = $bdd ->prepare("SELECT * FROM membre WHERE id_membre = ? ");
            $base -> execute(array($id));
            $bases = $base ->fetch();

            $pseudomodif = htmlspecialchars($_POST['pseudomodif']);
            $emailmodif = htmlspecialchars($_POST['emailmodif']);
            $datemodif = htmlspecialchars($_POST['datemodif']);
            $req = $bdd -> prepare("SELECT * FROM membre WHERE pseudo  = ?");
            $req -> execute(array($pseudomodif));
            $reqs = $req -> rowCount();

            if($reqs == 0 || $pseudomodif == $bases['pseudo']){
                $reqm = $bdd -> prepare("SELECT * FROM membre WHERE email = ? ");
                $reqm -> execute(array($emailmodif));
                $reqms = $reqm -> rowCount();

                if($reqms == 0 || $emailmodif == $bases['email']){

                    $modif = $bdd->prepare('UPDATE membre SET pseudo = ?,email = ?,date_naissance = ?  where id_membre = ? ');
                    $modif->execute(array($pseudomodif,$emailmodif,$datemodif,$id));
                    header('Location: gestionBOAdmin.php?modifier=ok');
                }
                else {
                    header('Location: gestionBOAdmin.php?modifier=nonemail');
                }
            }
            else {
                header('Location: gestionBOAdmin.php?modifier=nonpseudo');

            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="../css/css.css" rel="stylesheet">
        <title>Gestion membre BO</title>
    </head>
    <body>
    <?php include('header.php'); ?>
    <main>
        <?php include('gestionBomenue.php'); ?>

        <section>
            <div class="divBO">
                <section  class="bloc1BO">
                    <h3> Les Admins </h3>
                    <?php

                    $Femme = 'Femme';
                    $Homme = 'Homme';
                    $admin=0;
                    $i = 0;
                    $reponse = $bdd->query("SELECT * FROM membre WHERE pseudo='{$_SESSION['pseudo']}'");
                    $donnees = $reponse -> fetch();
                    $member = $bdd -> query("SELECT * FROM membre WHERE admin = '1' ");
                    $creadate1=$bdd->query('SELECT DAY(date_creation) as day_member, MONTH(date_creation) as month_member, YEAR(date_creation) as year_member, HOUR(date_creation) as hour_member, MINUTE(date_creation) as minute_member FROM membre WHERE admin =1');
                    $dateannive=$bdd->query('SELECT DAY(date_naissance) as day_member_birth, MONTH(date_naissance) as month_member_birth, YEAR(date_naissance) as year_member_birth, HOUR(date_naissance) as hour_member_birth, MINUTE(date_naissance) as minute_member_birth FROM membre WHERE admin = 1');
                    ?>
                    <?php  if(isset($_GET['modifier']) && $_GET['modifier']=='ok'){
                        echo '<p style=\'color : green \'> Le Membre à bien été modifié ! </p>';
                    }
                    if(isset($_GET['modifier']) && $_GET['modifier']=='nonpseudo'){
                        echo '<p style=\'color : red \'> Impossible de modifier le pseudo (Déjà existant) ! </p>';
                    }
                    if(isset($_GET['modifier']) && $_GET['modifier']=='nonemail'){
                        echo '<p style=\'color : red \'> Impossible de modifier l\'email (Déjà existant) ! </p>';
                    }?>
                    <table>
                        <tr>
                            <th > Pseudo</th>
                            <th> Email </th>
                            <th > Date Anniversaire </th>
                            <th> Date de Création </th>
                            <th> Type Abonnement</th>
                            <th > Delete Admin </th>
                            <th > Modifier </th>
                        </tr>

                        <?php while( ($member1 = $member-> fetch())&&($crea=$creadate1->fetch()) &&($creadate=$dateannive->fetch())){ ?>


                        <form action="gestionBOAdmin.php" method="post">
                            <tr>
                                <td > <input class="modifie" type="text" name="pseudomodif" value="<?php echo $member1['pseudo'];?>"></td>
                                <td > <input class="modifie" type="text" name="emailmodif" value="<?php echo $member1['email']; ?>">  </td>
                                <td> <input class="modifie" type="date" name="datemodif" value="<?php echo $member1['date_naissance']?>"></td>
                                <?php
                                if($crea['minute_member']<10){
                                    $minute_member =  '0'.$crea['minute_member'];
                                } else{
                                    $minute_member = $crea['minute_member'];
                                }
                                if($crea['month_member']<10){
                                    $month_member = '0'.$crea['month_member'];
                                } else {
                                    $month_member = $crea['month_member'];
                                }
                                if($crea['day_member']<10){
                                    $day_member =  '0'.$crea['day_member'];
                                } else {
                                    $day_member = $crea['day_member'];
                                }
                                if($crea['hour_member']<10){
                                    $hour_member =  '0'.$crea['hour_member'];
                                } else {
                                    $hour_member = $crea['hour_member'];
                                }?>
                                <td > <?php echo $day_member.'/'.$month_member.'/'.$crea['year_member']; ?> </td>
                                <td></td>
                                <td> <a href="gestionBOAdmin.php?admin=<?= $member1['id_membre'];?>"> Delete Admin </a> </td>
                                <?php if(isset($_GET['admin'])AND !empty($_GET['admin'])){
                                    $id= htmlspecialchars((int) $_GET['admin']);



                                    $del= $bdd-> prepare('UPDATE membre SET admin = ? WHERE id_membre = ?  ');

                                    $del-> execute(array($admin,$id));
                                    header("Location: gestionBOMembre.php");

                                } ?>
                                <td> <input formaction="gestionBOAdmin.php?id=<?= $member1['id_membre'];?>" type="submit"  name="Modifier" value="Modifier *"> </td>
                                <?php
                                } ?>
                            </tr>
                    </table>
                    <p>* Pour modifier un membre , changer la valeur du champs puis cliquer sur modifier</p>
                </section>
    </main>
    <?php include('footer.php'); ?>
    </body>
    </html>
<?php }else{
    ?>
    <script type="text/javascript">
        alert("Heho ! Tu n'as pas le droit de trainer par ici !");
        document.location.href = 'index.php';
    </script>
    <?php
} ?>
