<?php session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
$reponse = $bdd->query("SELECT * FROM membre WHERE id_membre='{$_SESSION['id']}'");
$admin = $reponse->fetch();
if ($admin['admin'] == 1) {


    if (isset($_POST['Modifier'])) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $base = $bdd->prepare("SELECT * FROM intervenant WHERE id = ? ");
            $base->execute(array($id));
            $bases = $base->fetch();

            $nommodif = htmlspecialchars($_POST['nommodif']);
            $prenommodif = htmlspecialchars($_POST['prenommodif']);
            $mailmodif = htmlspecialchars($_POST['mailmodif']);
            $telephonemodif = htmlspecialchars($_POST['telephonemodif']);
            $datemodif = htmlspecialchars($_POST['datemodif']);


            $reqm = $bdd->prepare("SELECT *FROM intervenant WHERE mail = ?");
            $reqm->execute(array($mailmodif));
            $reqms = $reqm->rowCount();

            if ($reqms == 0 || $mailmodif == $bases['mail']) {

                $modif = $bdd->prepare('UPDATE intervenant SET prenom = ?,nom = ?,mail = ?, birthdate= ?, telephone = ? where id = ? ');
                $modif->execute(array($prenommodif, $nommodif, $mailmodif, $datemodif, $telephonemodif, $id));
                header('Location: gestionBOIntervenant.php?modifier=ok');
            } else {
                header('Location: gestionBOIntervenant.php?modifier=nonemail');
            }
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
        <script type="text/javascript" src="../../js/demandebo.js"></script>
        <link href="../../css/css.css" rel="stylesheet">
        <title>Gestion intervenant BO</title>
    </head>
    <body>
    <?php include('../include/header.php'); ?>
    <main>
        <?php include('gestionBomenue.php'); ?>

        <section>
            <div class="divBO">
                <section class="bloc1BO">
                    <h3> Nouveaux Intervenants </h3>
                    <?php
                    $i = 0;
                    $member = $bdd->query("SELECT * FROM intervenant where valide = 0");


                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = htmlspecialchars($_GET['search']);
                        $member = $bdd->query("SELECT * FROM intervenant WHERE nom LIKE '%" . $search . "%' and valide = 0");
                    }

                    if ($member->rowCount() == 0) {
                        echo '<p style=\'color : red \'> Recherche Introuvable ! </p>';
                    }
                    if (isset($_GET['valide']) && $_GET['valide'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'intervenant à bien été validé ! </p>';
                    }
                    if (isset($_GET['modifier']) && $_GET['modifier'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'intervenant à bien été modifié ! </p>';
                    }
                    if (isset($_GET['modifier']) && $_GET['modifier'] == 'nonemail') {
                        echo '<p style=\'color : red \'> Impossible de modifier l\'email (Déjà existant) ! </p>';
                    }
                    ?>

                    <form method="get">
                        <label class="search" for="">Recherche un Intervenant via le nom :</label>
                        <input class="search" type="search" name="search" placeholder="Recherche..."
                               value="<?php if (isset($search)) {
                                   echo $search;
                               } ?>">
                        <input class="search" type="submit" name="" value="Valider">
                    </form>
                    <table class="tablebo">
                        <thead>
                        <tr>
                            <th> Nom</th>
                            <th> Prenom</th>
                            <th> Email</th>
                            <th> Téléphone</th>
                            <th> Adresse</th>
                            <th> Date Anniverssaire</th>
                            <th> Nom QrCode</th>
                            <th> Valider</th>
                            <th> Modifier</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while (($member1 = $member->fetch())) { ?>
                            <form action="gestionBOIntervenant.php" method="post">
                                <tr>
                                    <td><input class="modifie" type="text" name="nommodif"
                                               value="<?php echo $member1['nom']; ?>"></td>
                                    <td><input class="modifie" type="text" name="prenommodif"
                                               value="<?php echo $member1['prenom']; ?>"></td>
                                    <td><input class="modifie" type="text" name="mailmodif"
                                               value="<?php echo $member1['mail'] ?>"></td>
                                    <td><input class="modifie" type="text" name="telephonemodif"
                                               value="<?php echo $member1['telephone'] ?>"></td>
                                    <td><input class="modifie" type="text"
                                               value="<?php echo $member1['adresse'] ?>"><input class="modifie"
                                                                                                type="text"
                                                                                                value="<?php echo $member1['ville'] ?>"><input
                                                class="modifie" type="text"
                                                value="<?php echo $member1['codepostal'] ?>"></td>
                                    <td><input class="modifie" type="date" name="datemodif"
                                               value="<?php echo $member1['birthdate'] ?>"></td>
                                    <td><input class="modifie" type="text" name="Qrcodemodif"
                                               value="<?php echo $member1['nomQrCode'] ?>"></td>
                                    <td>
                                        <a href="gestionBOIntervenant.php?id=<?= $member1['id']; ?>&mail=1">Valider</a>
                                    </td>
                                        <?php if(isset($_GET['mail'])){
                                            $id = $_GET['id'];
                                            function genererChaineAleatoire($longueur = 6)
                                            {
                                                return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($longueur/strlen($x)) )),1,$longueur);
                                            }
                                            $mdp = genererChaineAleatoire();
                                            $update = $bdd->prepare('update intervenant set mdp=? where id = ? ');
                                            $update->execute(array($mdp,$id));
                                            $msg = '<p>Bonjour '. $member1['prenom'].', afin de compléter la procédure d\'enregistrement sur notre site : veuillez vous rendre sur ce lien : </p><br>';
                                            $msg .= '<a href="http://localhost/technicall/php/connexion/connexionIntervenant.php">Lien </a><br>';
                                            $msg .= '<p>Votre mot de passe de connexion est le suivant : <strong> '. $mdp .'</strong></p><br>';
                                            $msg .= '<p>Il vous sera demander de changer de mot de passe a votre première connexion</p>';
                                            $msg .= '<h3>Merci d\'avoir rejoint la communauté ! </h3>';
                                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                                            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                                            // send email
                                            mail("oceane.renoux@hotmail.fr","Finalisation d'inscription",$msg,$headers);
                                            header('Location:gestionBOIntervenant.php?');
                                        }?>
                                    <td><input formaction="gestionBOIntervenant.php?id=<?= $member1['id']; ?>"
                                               type="submit" name="Modifier" value="Modifier *"></td>
                                </tr>
                            </form>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <p>* Pour modifier un intervenant , changer la valeur du champs puis cliquer sur modifier</p>
                </section>
                <section class="bloc1BO">
                    <h3> Intervenants </h3>
                    <?php
                    $i = 0;
                    $member = $bdd->query("SELECT * FROM intervenant where valide = 1");


                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = htmlspecialchars($_GET['search']);
                        $member = $bdd->query("SELECT * FROM intervenant WHERE nom LIKE '%" . $search . "%' and valide =1");
                    }

                    if ($member->rowCount() == 0) {
                        echo '<p style=\'color : red \'> Recherche Introuvable ! </p>';
                    }
                    if (isset($_GET['valide']) && $_GET['valide'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'intervenant à bien été validé ! </p>';
                    }
                    if (isset($_GET['modifier']) && $_GET['modifier'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'intervenant à bien été modifié ! </p>';
                    }
                    if (isset($_GET['modifier']) && $_GET['modifier'] == 'nonemail') {
                        echo '<p style=\'color : red \'> Impossible de modifier l\'email (Déjà existant) ! </p>';
                    }
                    ?>

                    <form method="get">
                        <label class="search" for="">Recherche un Intervenant via le nom :</label>
                        <input class="search" type="search" name="search" placeholder="Recherche..."
                               value="<?php if (isset($search)) {
                                   echo $search;
                               } ?>">
                        <input class="search" type="submit" name="" value="Valider">
                    </form>
                    <table class="tablebo">
                        <thead>
                        <tr>
                            <th> Nom</th>
                            <th> Prenom</th>
                            <th> Email</th>
                            <th> Téléphone</th>
                            <th> Adresse</th>
                            <th> Date Anniverssaire</th>
                            <th> Nom QrCode</th>
                            <th> Modifier</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while (($member1 = $member->fetch())) { ?>
                            <form action="gestionBOIntervenant.php" method="post">
                                <tr>
                                    <td><input class="modifie" type="text" name="nommodif"
                                               value="<?php echo $member1['nom']; ?>"></td>
                                    <td><input class="modifie" type="text" name="prenommodif"
                                               value="<?php echo $member1['prenom']; ?>"></td>
                                    <td><input class="modifie" type="text" name="mailmodif"
                                               value="<?php echo $member1['mail'] ?>"></td>
                                    <td><input class="modifie" type="text" name="telephonemodif"
                                               value="<?php echo $member1['telephone'] ?>"></td>
                                    <td><input class="modifie" type="text"
                                               value="<?php echo $member1['adresse'] ?>"><input class="modifie"
                                                                                                type="text"
                                                                                                value="<?php echo $member1['ville'] ?>"><input
                                                class="modifie" type="text"
                                                value="<?php echo $member1['codepostal'] ?>"></td>
                                    <td><input class="modifie" type="date" name="datemodif"
                                               value="<?php echo $member1['birthdate'] ?>"></td>
                                    <td><input class="modifie" type="text" name="Qrcodemodif"
                                               value="<?php echo $member1['nomQrCode'] ?>"></td>
                                    <td><input formaction="gestionBOIntervenant.php?id=<?= $member1['id']; ?>"
                                               type="submit" name="Modifier" value="Modifier *"></td>
                                </tr>
                            </form>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                    <p>* Pour modifier un intervenant , changer la valeur du champs puis cliquer sur modifier</p>
                </section>
            </div>
        </section>
    </main>
    <?php include('../include/footer.php'); ?>

    </body>
    </html>
<?php } else {
    ?>
    <script type="text/javascript">
        alert("Heho ! Tu n'as pas le droit de trainer par ici !");
        document.location.href = 'index.php';
    </script>
    <?php
} ?>
