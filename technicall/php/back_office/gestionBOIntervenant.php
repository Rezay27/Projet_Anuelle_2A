<?php session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
$reponse = $bdd->query("SELECT * FROM membre WHERE id_membre='{$_SESSION['id']}'");
$admin = $reponse -> fetch();
if($admin['admin']==1){



    if(isset($_POST['Modifier'])) {
        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $base = $bdd ->prepare("SELECT * FROM intervenant WHERE id = ? ");
            $base -> execute(array($id));
            $bases = $base ->fetch();

            $nommodif = htmlspecialchars($_POST['nommodif']);
            $prenommodif = htmlspecialchars($_POST['prenommodif']);
            $mailmodif = htmlspecialchars($_POST['mailmodif']);
            $telephonemodif = htmlspecialchars($_POST['telephonemodif']);
            $datemodif = htmlspecialchars($_POST['datemodif']);


                $reqm = $bdd -> prepare("SELECT *FROM intervenant WHERE mail = ?");
                $reqm -> execute(array($mailmodif));
                $reqms = $reqm -> rowCount();

                if($reqms == 0 || $mailmodif == $bases['mail']){

                    $modif = $bdd->prepare('UPDATE intervenant SET prenom = ?,nom = ?,mail = ?, birthdate= ?, telephone = ? where id = ? ');
                    $modif->execute(array($prenommodif,$nommodif, $mailmodif,$datemodif,$telephonemodif,$id));
                    header('Location: gestionBOIntervenant.php?modifier=ok');
                }
                else {
                    header('Location: gestionBOIntervenant.php?modifier=nonemail');
                }
            }
        }


    ?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="../../css/css.css" rel="stylesheet">
        <title>Gestion intervenant BO</title>
    </head>
    <body>
    <?php include('../include/header.php'); ?>
    <main>
        <?php include('gestionBomenue.php'); ?>

        <section>
            <div class="divBO">
                <section  class="bloc1BO">
                    <a href="export.php">Exporter la liste</a>
                    <h3 > Intervenants </h3>
                    <?php
                    $i = 0;
                    $member = $bdd -> query("SELECT * FROM intervenant ");



                    if(isset($_GET['search']) && !empty($_GET['search'])){
                        $search = htmlspecialchars($_GET['search']);
                        $member = $bdd -> query("SELECT * FROM intervenant WHERE nom LIKE '%".$search."%' ");
                    }

                    if($member -> rowCount() == 0){
                        echo '<p style=\'color : red \'> Recherche Introuvable ! </p>';
                    }

                    if(isset($_GET['modifier']) && $_GET['modifier']=='ok'){
                        echo '<p style=\'color : green \'> Le Membre à bien été modifié ! </p>';
                    }
                    if(isset($_GET['modifier']) && $_GET['modifier']=='nonemail'){
                        echo '<p style=\'color : red \'> Impossible de modifier l\'email (Déjà existant) ! </p>';
                    }
                    ?>

                    <form  method="get">
                        <label  class="search" for="">Recherche un Intervenant via le nom :</label>
                        <input class="search" type="search" name="search" placeholder="Recherche..." value="<?php if(isset($search)){ echo $search;} ?>">
                        <input class="search" type="submit" name="" value="Valider">
                    </form>
                    <table>
                        <tr>
                            <th > Nom </th>
                            <th > Prenom </th>
                            <th > Email </th>
                            <th > Téléphone </th>
                            <th > Adresse </th>
                            <th> Date Anniverssaire </th>
                            <th > Nom QrCode </th>
                            <th > Modifier </th>
                        </tr>
                </section>
                <?php while( ($member1 = $member-> fetch())){?>
                    <form action="gestionBOMembre.php" method="post">
                        <tr>
                            <td > <input class="modifie" type="text" name="nommodif" value="<?php echo $member1['nom'];?>"></td>
                            <td > <input class="modifie" type="text" name="prenommodif" value="<?php echo $member1['prenom']; ?>">  </td>
                            <td> <input class="modifie" type="text" name="mailmodif" value="<?php echo $member1['mail']?>"></td>
                            <td> <input class="modifie" type="text" name="telephonemodif" value="<?php echo $member1['telephone']?>"></td>
                            <td> <input class="modifie" type="text" value="<?php echo $member1['adresse']?>"><input class="modifie" type="text" value="<?php echo $member1['ville']?>"><input class="modifie" type="text" value="<?php echo $member1['codepostal']?>"></td>
                            <td ><input class="modifie" type="date" value="<?php echo $member1['birthdate']?>"></td>

                            <td> <input class="modifie" type="text" name="Qrcodemodif" value="<?php echo $member1['nomQrCode']?>"></td>
                            <td> <input formaction="gestionBOIntervenant.php?id=<?= $member1['id'];?>" type="submit"  name="Modifier" value="Modifier *"> </td>
                        </tr>
                    </form>
                    <?php
                } ?>
                </table>
                <p>* Pour modifier un intervenant , changer la valeur du champs puis cliquer sur modifier</p>
            </div>
        </section>
    </main>
    <?php include('../include/footer.php'); ?>

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
