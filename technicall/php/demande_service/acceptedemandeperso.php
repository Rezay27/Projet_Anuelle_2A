<?php session_start(); ?>
<?php require('../include/connect_bdd.php');
require_once "configPay.php";

$date = date("d-m-Y");
$heure = date("H:i");

if(isset($_GET["devis"])){
    if(isset($_GET['id'])){
        $devis = $_GET['devis'];
        $id = $_GET['id'];

        $selectdemande = $bdd ->prepare('select * from demandes where ref_devis = ?');
        $selectdemande->execute(array($devis));

        $id_membres = $bdd ->prepare('select * from demandes where ref_devis = ?');
        $id_membres->execute(array($devis));
        $id_membre = $id_membres->fetch();
        $id_membre = $id_membre['id_membre'];

        $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
        $abonnement ->execute(array($id));
        $abonnement_exist = $abonnement ->fetch();

        if(isset($abonnement_exist['id_membre'])){
            $point = $bdd -> prepare('select sum(point_demande) as total from demandes where ref_devis = ?');
            $point ->execute(array($devis));
            $total = $point->fetch();

        }else {
            $prix = $bdd -> prepare('select sum(prix_demande) as total from demandes where ref_devis = ?');
            $prix ->execute(array($devis));
            $total = $prix->fetch();
        }




?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Demande & Service</title>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/services.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link rel="stylesheet" href="../../css/css.css">
</head>
<body>
<?php include('../include/header.php'); ?>

<div class="bloc1">
    <h3> Payer mon devis personalisé </h3>
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
        <?php  while($demande = $selectdemande->fetch()){ ?>

            <tr>
                <td><p name="nom"><?php echo $demande['nom_demande']; ?></p></td>
                <td><p name="nb_heure"><?php echo $demande['nb_heure']; ?> h</p></td>
                <?php if(isset($abonnement_exist['id_membre'])){?>
                    <td><p name="t_horaire"><?php echo $demande['point_unite'] ?> points</p></td>
                <?php }else{?>
                    <td><p name="t_horaire"><?php echo $demande['taux_horaire'] ?> €/h</p></td>
                <?php } ?>
                <?php if(isset($abonnement_exist['id_membre'])){?>
                    <td><p name="prix"><?php echo $demande['point_demande']; ?> points</p></td>
                <?php }else{?>
                    <td><p name="prix"><?php echo $demande['prix_demande']; ?> €</p></td>
                <?php } ?>
            </tr>

        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td>Total</td>
            <td><?php echo $total['total'] ?></td>
        </tr>
    </table>
    <?php if(isset($abonnement_exist['id_membre'])){?>
        <a class="divchoixdemande" href="payerperso.php?id=10&devis=<?=$devis;?>&point=1&total=<?=$total['total']?>&id_membre=<?=$id_membre;?>">Payer en point</a>
    <?php }else{?>
        <form class="style_button" action="payerperso.php?id=10&devis=<?=$devis;?>&point=0&total=<?=$total['total']?>&id_membre=<?=$id_membre;?>" method="POST">
        <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="<?php echo $stripeDetails['publishableKey']; ?>"
                data-amount="<?php echo $total['total'] * 100 ?>"
                data-name="Payement des services"
                data-description=""
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="French">
        </script>
    </form>
    <?php } ?>

</div>
<?php include('../include/footer.php'); ?>
</body>
</html>
<?php    }
}
?>