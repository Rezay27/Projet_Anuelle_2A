<?php session_start(); ?>
<?php require('../include/connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");
require_once "configPay.php";
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
<div id="searchDS">

    <h3>Chercher un Service</h3>

    <?php
    if (isset($_GET['demande']) && $_GET['demande'] == 1) {
        echo '<p style=\'color : green \'> La demande a bien été envoyée ! </p>';
    }

    if (isset($_GET['ok']) && $_GET['ok'] == 'sucess') {
        echo '<p style=\'color : green \'> La demande a bien été envoyée ! </p>';
        $tableau = $_GET['tableau'];
        echo ' <a href="facture_pdf.php?tableau=<?=$tableau; ?>"> Télécharger la facture </a>';
    }

    if (isset($_GET['ok']) && $_GET['ok'] == 'nbpointneg') {
        echo '<p style=\'color : red \'> Vous n\'avez pas suffisament de point <a href="../stripe/abonnement.php">Reprendre des points !</a></p>';
    }

    $demande = $bdd->query("Select * FROM services inner join type_service on services.id_type_service = type_service.id_type where service_valide = 1");

    $membre = $bdd -> prepare("select * from membre where id_membre = ?");
    $membre -> execute(array($_SESSION['id']));
    $membre_info = $membre ->fetch();

    $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
    $abonnement ->execute(array($_SESSION['id']));
    $abonnement_exist = $abonnement ->fetch();
    ?>

    <!-- TABLEAU AFFICHAGE -->
    <table id="tableDS">
        <thead>
        <tr>
            <th> Choix</th>
            <th>Nom du service</th>
            <th> Nombre d'heure</th>
            <?php if(isset($abonnement_exist['id_membre'])){?>
            <th> Nombre de point</th>
            <?php } else { ?>
            <th>Taux horaire (€/h)</th>
            <?php } ?>
            <th> Total service</th>
        </tr>
        </thead>
        <tbody>
        <?php while (($demandes = $demande->fetch())) { ?>
            <tr>
                <td class="checkbox">
                    <label for="accepter"></label>
                    <input onblur="verifBox(this)" id="<?php echo $demandes['id_services'] ?>"
                           class="<?php echo $demandes['id_services'] ?> checkbox_demande" type="checkbox"
                           name="condition"/></input>
                    <label id="coche" for="<?php echo $demandes['id_services'] ?>"></label>
                </td>
                <td><p id="name" class="listds"><?php echo $demandes['nom_service']; ?> </p></td>
                <td class="number_td"><input class="nb_heure_demande" type="number"></td>
                <td class="price_td"><p id="price<?php echo $demandes['id_services'] ?>"
                                        class="listds tarif_demande"><?php echo $demandes['tarif']; ?> </p></td>
                <td class="total_td"><p class="total<?php echo $demandes['id_services'] ?> total_demande"><?php if(isset($abonnement_exist['id_membre'])){?>0 point<?php } else { ?>0 €<?php } ?></p></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <!-- END TABLEAU AFFICHAGE -->

    <!-- SECTION TOTAL PRIX -->
    <section class="Ttotal_demande ">
        <div class="divPrice">
            <input type="text" id="prixtotal" class="prix_Ttotal" value="<?php if(isset($abonnement_exist['id_membre'])){?>Total : 0 point<?php } else { ?>Total : 0 €<?php } ?>"/>
        </div>
        <div class="divSubmit">
            <input class="valide_total" type="submit" value="Valider">
        </div>
    </section>
    <!-- END SECTION TOTAL PRIX -->

    <!-- POP UP INFO CLIENT -->
    <div class="blocpopup" id="popupinfo">
        <h3>Information complémentaire</h3>
        <form id="form_info" action="devis.php" name="info_client" method="post" enctype="multipart/form-data" class="payer">
            <label>Adresse :</label>
            <input type="text" name="adresse_client" placeholder="Adresse" value="<?php echo $membre_info["adresse"]?>">
            <label>Code Postal : </label>
            <input type="text" name="cp_client" placeholder="Code postal" value="<?php echo $membre_info['code_postal']?>">
            <label> Ville : </label>
            <input type="text" name="ville_client" placeholder="Ville" value="<?php echo $membre_info['ville']?>">
            <label> Date :</label>
            <input type="date" name="date_client">
            <label> Heure : </label>
            <input type="time" name="time_client">
            <label>Description : </label>
            <textarea placeholder="Description" name="description_client" rows="8" cols="25"></textarea>
            <textarea hidden class='tableau_demande' name="tableau_demande" ></textarea>
            <input class="submitservice" type="submit" name="payer" value="Acceder au devis">

            <input class="submitservicenormal" type="button"  name="fermer" value="Annuler"/>
            <p> * Vous allez être redirigé vers la page de paiement </p>

        </form>
    </div>

    <!-- END POP UP INFO CLIENT -->

    <!-- DEMANDE PERSO -->
    <input type="submit" class="submit" value="Demande personnalisée" name="addservice" id="button_add"/>
    <div class="blocpopup" id="popupadd">
        <h3>Demande personnalisée</h3>
        <form id="add_service" action="verifaddservice.php" name="addservice" method="post"
              enctype="multipart/form-data">
            <label>Nom du service :</label>
            <input type="text" name="addname" placeholder="Nom du service">
            <?php if(isset($abonnement_exist['id_membre'])){?>
             <label>Prix souhaitez /h (point):</label>
             <input type="number" name="addtarif" placeholder="Prix Souhaitez">
            <?php }else { ?>
            <label>Prix souhaitez /h :</label>
            <input type="number" name="addtarif" placeholder="Prix Souhaitez">
            <?php } ?>
            <label> Nombre d'heure :</label>
            <input type="number" name="nb_heure">
            <label>Ville :</label>
            <input name="addville" type="text" placeholder="Ville">
            <label>Adresse :</label>
            <input name="addadresse" type="text" placeholder="Adresse">
            <label>Code Postal :</label>
            <input name="addcode_postal" type="text" placeholder="Code Postal">
            <label>Date :</label>
            <input name="adddateservice" type="date" min="<?php echo $date ?>">
            <label>Heure :</label>
            <input name="addheureservice" type="time">
            <?php if(isset($abonnement_exist['id_membre'])){?>
                <input class="submitservice" type="submit" name="abo_valider" value="Envoyer"/>
            <?php } else { ?>
                <input class="submitservice" type="submit" name="nonabo_valider" value="Envoyer"/>
            <?php } ?>
                <input class="submitservice" type="button" name="fermer" value="Annuler"/>
                <p> * Votre demande est sera soumise à validation </p>
        </form>
    </div>

    <!-- END DEMANDE PERSO -->


    <!--Pop up nb_heure inssufisante -->
    <?php if (isset($_GET['nb_heure']) && $_GET['nb_heure'] == 'neg') { ?>
        <div class="blocpopup_errreur">
            <h3>Vous ne disposez pas d'un nombre d'heure suffisant !</h3>
            <a href="../stripe/abonnement.php" name="new_abonnement" class="button_erreur_heure submitservice">Passer a
                l'abonnement supérieur</a>
            <a href="#" name="payer_comptant" class="button_erreur_heure submitservice">Payer le service au prix
                indiqué</a>
            <input class="submitservice" type="submit" name="fermer_heure" value="Annuler"/>
        </div>
    <?php } ?>
    <!-- END POP HEURE INSU -->

</div>

</main>
<?php include('../include/footer.php'); ?>
</body>
</html>
