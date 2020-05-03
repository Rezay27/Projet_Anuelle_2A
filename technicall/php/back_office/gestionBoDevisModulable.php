<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');

$id = $_GET['demande'];
$demandes = $bdd->prepare("SELECT * FROM `demandes` where id_demandes = ?  ");
$demandes->execute(array($id));
$demande = $demandes->fetch();



$membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
$membres ->execute(array($demande['id_membre']));
$membre_info = $membres->fetch();

$abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
$abonnement ->execute(array($demande['id_membre']));
$abonnement_exist = $abonnement ->fetch();


if(isset($demande['prix_demande'])){ $prix_total = $demande['prix_demande'] ;} else { $prix_total =$demande['point_demande'];}
$prix_ht = $prix_total / 1.2;
$tva = $prix_total - $prix_ht;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <script type="text/javascript" src="../../js/devismodulable.js"></script>
    <link href="../../css/css.css" rel="stylesheet">

    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section class="bloc1BO">
            <h3> Demandes Personnalisé en attente de confirmation</h3>
            <form action="generationDevisBo.php" enctype="multipart/form-data" method="post" id="envoie_devis">
                <p><?php echo $membre_info['nom'] . ' ' . $membre_info['prenom'] . '<br>' . $demande['adresse'] . ' - ' . $demande['code_postal'] . '<br>' . $demande['ville'] ?></p>
                <p> Date et Heure de l'intervention : <?php echo $demande['date_demande'] . ' à ' . $demande['heure'] ?></p>
                <p> Prix souhaité: <?php echo $prix_total ?> </p>
                <!-- DEBUT AFFICHAGE SERVICE -->
                <table  id="info_devis">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Nombre d'heure/Quantité</th>
                        <?php if(isset($demande['point_demande'])) { ?>
                            <th> Nombre de point/u</th>
                        <?php } else { ?>
                            <th>Taux horaire (€/h)</th>
                        <?php } ?>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="" name="nom" value="<?php echo $demande['nom_demande']; ?>"></td>
                            <td><input class="nb_heuretd" name="nb_heure" value="<?php echo $demande['nb_heure']; ?>"></td>
                            <?php if(isset($demande['point_demande'])){ ?>
                                <td><input class="t_horairetd" name="t_horaire" value="<?php echo $demande['point_unite'] ?>"></td>
                            <?php } else { ?>
                                <td><input class="t_horairetd" name="t_horaire" value="<?php echo $demande['taux_horaire'] ?>"></td>
                            <?php } ?>
                            <?php if(isset($demande['point_demande'])) { ?>
                                <td><input class="totalline" name="prix" value="<?php echo $demande['point_demande'] ?>"></td>
                            <?php } else { ?>
                                <td><input class="totalline" name="prix" value="<?php echo $demande['prix_demande'] ?>"></td>
                            <?php } ?>
                        </tr>
                        <tr class="new"></tr>
                        <tr id="addline">
                            <td><input type="button" value="+ Ajouter une ligne" name="Ajouter"></td>
                        </tr>
                    <tr>
                        <td class="space"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php if(isset($demande['point_demande'])) { ?>

                        <tr>
                            <td colspan="2"></td>
                            <td style="text-align: center;" ><strong>Total:</strong></td>
                            <td><input name="total" id="total" style="text-align: center;width: 50%;float: left" type="text" value="<?php echo  $prix_total ; ?>"><p style="float: right;width: 50%">points</p></td>
                        <tr>
                            <td colspan="2" class="no-border"></td>
                            <td style="text-align: center;" ><strong>Nombre de point restant:</strong></td>
                            <td><input  name="total" id="total" style="text-align: center;width: 50%;float: left" type="text" value="<?php echo  $abonnement_exist['nb_point'] ; ?>"><p style="float: right;width: 50%">points</p></td>
                        </tr>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="2"></td>
                            <td style="text-align: center;"><strong>Total:</strong></td>
                            <td><input id="ht" style="text-align: center;width: 50%;float: left" type="text" value="<?php echo  round($prix_ht,2) ; ?>"><p style="float: right;width: 50%">euros</p></td>
                        </tr>
                        <tr>
                            <td colspan="3" ></td>
                            <td><input id="tva" style="text-align: center;width: 50%;float: left" type="text" value="<?php echo  round($tva,2) ; ?>"><p style="float: right;width: 50%">euros</p></td>
                        </tr>)
                        <tr>
                            <td colspan="3" ></td>
                            <td><input  name="total" id="total" style="text-align: center;width: 50%;float: left" type="text" value="<?php echo  $prix_total ; ?>"><p style="float: right;width: 50%">euros</p></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <br>
                <!-- FIN AFFICHAGE PRIX -->
                <!-- INFO TRANSMIS CACHER -->
                <input hidden type="text" name="id" value="<?php echo $id; ?>">
                <input hidden type="number" name="prix_t" value="<?php echo $prix_total?>">
                <input hidden type="text" name="devis"
                       value="<?php echo  $id . '-' . $date . '.pdf' ?>">
                <input hidden type="text" name="facture"
                       value="<?php echo 'Facture' . $id . '-' . $date . '.pdf' ?>">


              <input class="submitservice" style="font-weight: bold;" type="submit" value="Télécharger le devis" name="savedemandepoint">
            </form>
            <div class="divvalidedevis">
                <?php if($demande['ref_devis']==null){?>
                    <a style="pointer-events: none;" class="validedevis" href="gestionBoDemandesPerso.php?devis=ok">Valider </a>
                <?php } else { ?>
                <a class="validedevis" href="gestionBoDemandesPerso.php?devis=ok">Valider </a>
                <?php }?>
            </div>
        </section>
    </div>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>