<?php
require('../include/connect_bdd.php');
require_once "configPay.php";

session_start();

$date = date("d-m-Y");
$heure = date("H:i");


$tableau = htmlspecialchars($_POST['tableau_demande']);

$tableau1 = explode('-', $tableau);

$numero_d = $bdd -> prepare('select id_demandes from demandes order by id_demandes DESC LIMIT 0, 1');
$numero_d ->execute(array());
$last_devis = $numero_d -> fetch();
$last_devis = $last_devis['id_demandes']+1;


$prix_total = end($tableau1);
$prix_ht = $prix_total / 1.2;
$tva = $prix_total - $prix_ht;

$adresse = htmlspecialchars($_POST['adresse_client']);
$ville = htmlspecialchars($_POST['ville_client']);
$cp = htmlspecialchars($_POST['cp_client']);
$date = htmlspecialchars($_POST['date_client']);
$time = htmlspecialchars($_POST['time_client']);
$description = htmlspecialchars($_POST['description_client']);

$membre = $bdd->prepare("select * from membre where id_membre = ?");
$membre->execute(array($_SESSION['id']));
$membre_info = $membre->fetch();

$abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
$abonnement ->execute(array($_SESSION['id']));
$abonnement_exist = $abonnement ->fetch();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Devis</title>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/devis.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link rel="stylesheet" href="../../css/css.css">
    <style>
        footer {
            margin-top: 10%;
        }
    </style>
</head>
<body>
<?php include('../include/header.php'); ?>

<div class="bloc1">
    <h3>Devis n° <?php echo $last_devis ?> </h3>
    <form action="stripePay.php?id=10" enctype="multipart/form-data" method="post" id="envoie_devis">
        <p><?php echo $membre_info['nom'] . ' ' . $membre_info['prenom'] . '<br>' . $adresse . ' - ' . $cp . '<br>' . $ville ?></p>
        <p> Date et Heure de l'intervention : <?php echo $date . ' à ' . $time ?></p>
        <p> Info complémentaire : <?php echo $description ?> </p>
        <!-- DEBUT AFFICHAGE SERVICE -->
        <table id="info_devis">
            <tr>
                <th>Nom</th>
                <th>Nombre d'heure</th>
                <?php if(isset($abonnement_exist['id_membre'])){?>
                    <th> Nombre de point</th>
                <?php } else { ?>
                    <th>Taux horaire (€/h)</th>
                <?php } ?>
                <th>Prix</th>
            </tr>
            <?php for ($i = 0; $i < sizeof($tableau1) - 1; $i++) { ?>
                <tr>
                    <td><p name="nom"><?php echo $tableau1[$i]; ?></p></td>
                    <?php $i++; ?>
                    <td><p name="nb_heure"><?php echo $tableau1[$i]; ?> h</p></td>
                    <?php $i++; ?>
                    <?php if(isset($abonnement_exist['id_membre'])){?>
                        <td><p name="t_horaire"><?php echo $tableau1[$i] ?> points</p></td>
                    <?php }else{?>
                    <td><p name="t_horaire"><?php echo $tableau1[$i] ?> €/h</p></td>
                    <?php } ?>
                    <?php $i++ ?>
                    <?php if(isset($abonnement_exist['id_membre'])){?>
                        <td><p name="prix"><?php echo $tableau1[$i]; ?> points</p></td>
                    <?php }else{?>
                        <td><p name="prix"><?php echo $tableau1[$i]; ?> €</p></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <!-- FIN AFFICHAGE SERVICE -->
        <br>
        <!-- AFFICHAGE PRIX -->
        <table>
            <?php if(isset($abonnement_exist['id_membre'])){?>
            <tr>
                <th>Total points</th>
                <td> <?php echo $prix_total . ' points ' ?></td>
            </tr>
            <?php }else {?>
            <tr>
                <th>Total TTC</th>
                <td> <?php echo $prix_total . ' € ' ?></td>
            </tr>
            <tr>
                <th>TVA</th>
                <td> <?php echo round($tva, 2) . ' € ' ?> </td>
            </tr>
            <tr>
                <th> Total HT</th>
                <td><?php echo round($prix_ht, 2) . ' € ' ?></td>
            </tr>
            <?php }?>
        </table>
        <!-- FIN AFFICHAGE PRIX -->
        <!-- INFO TRANSMIS CACHER -->
        <textarea name="tableau_demande" hidden><?php echo $tableau; ?></textarea>
        <input hidden type="text" name="adresse" value="<?php echo $adresse; ?>">
        <input hidden type="number" name="cp" value="<?php echo $cp; ?>">
        <input hidden type="text" name="ville" value="<?php echo $ville; ?>">
        <input hidden type="date" name="date" value="<?php echo $date; ?>">
        <input hidden type="time" name="heure" value="<?php echo $time; ?>">
        <input hidden type="text" name="description" value="<?php echo $description; ?>">
        <input hidden type="text" name="devis" value="<?php echo 'Devis'. $last_devis. '-'. $date.'.pdf' ?>">
        <input hidden type="text" name="facture" value="<?php echo 'Facture'. $last_devis. '-'. $date.'.pdf' ?>">

        <?php if(isset($abonnement_exist['id_membre'])){?>
        <input  type="submit" value="Enregistrer" name="savedemandepoint">
        <?php } else {?>
        <!-- BUTTON PAIEMENT -->
        <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="<?php echo $stripeDetails['publishableKey']; ?>"
                data-amount="<?php echo $prix_total * 100 ?>"
                data-name="Payement des services"
                data-description=""
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="French">
        </script>

        <?php }?>

    </form>


    <a href="devis_pdf.php?tableau=<?= $tableau;?>" >Save PDF </a>
</div>


<?php include('../include/footer.php'); ?>
</body>
</html>
