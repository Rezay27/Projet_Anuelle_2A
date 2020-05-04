<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
if (isset($_GET['refuser'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $refuser = $_GET['refuser'];

        $modif_info = $bdd->prepare("update demandes set refuser = ? where id_demandes = ? ");
        $modif_info->execute(array($refuser, $id));

        $selectdemande = $bdd -> prepare('select * from demandes where id_demandes = ? ');
        $selectdemande->execute(array($id));
        $demande = $selectdemande->fetch();

        $msg = '<p>Bonjour , votre demande n° '.$demande['id_demandes'].' concernant : "'. $demande['nom_demande'] .'" a été refusé. </p><br>';
        $msg .= '<p>Les raison sont les suivantes : <br><strong> - Elle ne corresponds pas a la charte  <br> - Elle n\'est pas conforme <br>   </strong></p><br>';
        $msg .= '<p>Vous pouvez tout de fois refaire une demande avec un autre service</p>';
        $msg .= '<h3>Bonne journée ! </h3>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // send email
        mail("gabriel76.viot@gmail.com", "Demande refusé", $msg, $headers);


        header('Location:gestionBoDemandesPerso.php?refuser=ok');

    }
}

$nb_affectation = $bdd->query('SELECT id_demandes from demandes where statut_demande = 0 AND type_demande = \'perso\'  AND id_intervenant_demande is null and ref_devis is not null and statut_devis=1 and date_demande > now() group by ref_devis ');
$nb_affect = $nb_affectation->rowCount();


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

    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section class="bloc1BO">
            <h3> Demandes Personnalisé non traitée
                <span class="deroulelisteperso">
                    <select onChange='change(this)' class='selectperso'>
           <option value"">Choisir une page</option>
                        <option value='gestionBoDemandesPersoEnAttenteA.php'>Demande en attente d'affectation (<?php echo $nb_affect ?>) </option>
            <option value='gestionBoDemandesPersoEnAttenteC.php'>Demande en attente de validation</option>
           <option value='gestionBoDemandesPersoEnCours.php'>Demande en cours</option>
            </select>
                </span>
            </h3>
            <?php if (isset($_GET['refuser']) && $_GET['refuser'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été refusée ! </p>';
            };
            if (isset($_GET['devis']) && $_GET['devis'] == 'ok') {
                echo '<p style=\'color : green \'> Le devis à bien été envoyé ! </p>';
            };
            $demande = $bdd->query("SELECT * FROM `demandes` where statut_demande = 0 AND type_demande = 'perso' AND ref_devis is null and refuser = 0 and date_demande > now() ");

            if (isset($demandes['prix_demande'])) {
                $point = 0;
            } else {
                $point = 1;
            }
            ?>
            <table class="tablebo">
                <thead>
                <tr>
                    <th> Demande n°</th>
                    <th> Demandeur</th>
                    <th> Nom</th>
                    <th> Nombre_heure</th>
                    <th> Date</th>
                    <th> Devis</th>
                    <th> Refuser</th>
                </tr>
                </thead>
                <?php while ($demandes = $demande->fetch()) {
                    if (isset($demandes['prix_demande'])) {
                        $point = 0;
                    } else {
                        $point = 1;
                    }
                    ?>
                    <form action="gestionBoDemandesPerso.php" method="post">
                        <tr>
                            <td><input class="modifie" type="text" name="demande"
                                       value="<?php echo $demandes['id_demandes']; ?>"></td>
                            <?php
                            $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                            $membres->execute(array($demandes['id_membre']));
                            $membre = $membres->fetch();
                            ?>
                            <td><input class="modifie" type="text"
                                       value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                            <td><input class="modifie" type="text" name="nom"
                                       value="<?php echo $demandes['nom_demande']; ?>"></td>
                            <td><input class="modifie" type="text" name="nb_heure"
                                       value="<?php echo $demandes['nb_heure']; ?>"></td>
                            <td><input class="modifie" type="date" name="date"
                                       value="<?php echo $demandes['date_demande'] ?>"><input class="modifie"
                                                                                              type="time" name="time"
                                                                                              value="<?php echo $demandes['heure'] ?>">
                            </td>
                            <td><a href="gestionBoDevisModulable.php?demande=<?= $demandes['id_demandes'] ?>"
                                > Générer le devis </a></td>
                            <td>
                                <a href="gestionBoDemandesPerso.php?id=<?= $demandes['id_demandes'] . "&refuser=1"; ?>"
                                   name="refuser">Refuser</a></td>
                        </tr>
                    </form>
                <?php } ?>
            </table>
        </section>
    </div>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>