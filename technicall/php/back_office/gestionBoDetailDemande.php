<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
$facture = $_GET['facture'];
$id_membre = $_GET['id_membre'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link href="../../css/css.css" rel="stylesheet">

    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section class="bloc1BO">
            <h3> Demandes (Abonnés)</h3>
            <?php
            $demande = $bdd->prepare("SELECT * FROM demandes where ref_facture = ? ");
            $demande->execute(array($facture));

            $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
            $abonnement ->execute(array($id_membre));
            $abonnement_exist = $abonnement ->fetch();
            ?>
            <table id="tablebo">
                <thead>
                <tr>
                    <th> Facture n°</th>
                    <th> Demandeur</th>
                    <th> Nom service</th>
                    <th> Nombre_heure</th>
                    <?php if(isset($abonnement_exist['id_membre'])){?>
                        <th> Nombre de point</th>
                    <?php } else { ?>
                        <th>Taux horaire (€/h)</th>
                    <?php } ?>
                    <th> Total</th>
                    <th> Ajouter un intervenant</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['ref_facture']; ?>"></td>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['id_membre']; ?>"</td>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['nom_demande']; ?>"></td>
                        <td><input class="modifie facture" type="text" value="<?php echo $demandes['nb_heure']; ?>">
                        </td>
                        <?php if(isset($abonnement_exist['id_membre'])){?>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['point_unite'] ?>  points">
                            <?php }else{ ?>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['taux_horaire'] ?>  €">
                            <?php }?>
                        </td>
                        <?php if(isset($abonnement_exist['id_membre'])){?>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['point_demande'] ?>  points">
                            <?php }else{ ?>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['prix_demande'] ?>  €">

                            <?php }?>
                        <td><a href="gestionBoDemandesNonAbo.php?id_demandes=<?= $demandes['id_demandes']; ?>">
                                Ajouter </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>