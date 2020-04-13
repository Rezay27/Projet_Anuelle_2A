<?php session_start(); ?>
<?php require('../include/connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");

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

    $demande = $bdd->query("Select * FROM services inner join type_service on services.id_type_service = type_service.id_type where service_valide = 1");
    ?>
    <table id="tableDS">
        <thead>
        <tr>
            <th> Choix</th>
            <th>Nom du service</th>
            <th> Nombre d'heure</th>
            <th>Taux horaire (€/h)</th>
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
                <td class="total_td"><p class="total<?php echo $demandes['id_services'] ?> total_demande">0 €</p></td>
            </tr>
            <div id="popup" class="blocpopup">
                <form id="demandeservice" action="verifdemandeservice.php" name="demandeservice" method="post"
                      enctype="multipart/form-data">
                    <h3 class="nameservice"></h3>
                    <p class="priceservice">/h</p>
                    <p class="typeservice"></p>
                    <input type="text" hidden id="nameservices" name="nameservices">
                    <input type="text" hidden id="tarifservices" name="tarifservices">
                    <input type="text" hidden id="typeservices" name="typeservices">
                    <label> Nombre d'heure :</label>
                    <input type="number" name="nb_heure">
                    <label>Ville :</label>
                    <input name="ville" type="text" placeholder="Ville">
                    <label>Adresse :</label>
                    <input name="adresse" type="text" placeholder="Adresse">
                    <label>Code Postal :</label>
                    <input name="code_postal" type="text" placeholder="Code Postal">
                    <label>Date :</label>
                    <input name="dateservice" type="date" min="<?php echo $date ?>">
                    <label>Heure :</label>
                    <input name="heureservice" type="time">
                    <?php
                    $reponse = $bdd->query("SELECT * FROM abonnement_test where id_membre='{$_SESSION['id']}' ");
                    $donnees = $reponse->fetch();

                    if (isset($donnees['type_abonnement'])) {
                        ?>
                        <input class="submitservice" type="submit" name="valider" value="Envoyer"/>
                        <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                        <p> * Votre demande est directement enregistré </p>
                    <?php } else { ?>
                        <input class="submitservice" type="submit" name="payer" value="Payer"/>
                        <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                        <p> * Vous allez être redirigé vers la page de paiement </p>
                    <?php } ?>
                </form>
            </div>
        <?php } ?>
        </tbody>
    </table>
    <section class="Ttotal_demande ">
        <div class="divPrice">
            <p class="prix_Ttotal">Total : 0 €</p>
        </div>
        <div class="divSubmit">
            <input class="" type="submit" value="Valider">
        </div>
    </section>
    <input type="submit" class="submit" value="Demande personnalisée" name="addservice" id="button_add"/>
    <div class="blocpopup" id="popupadd">
        <h3>Demande personnalisée</h3>
        <form id="add_service" action="verifaddservice.php" name="addservice" method="post"
              enctype="multipart/form-data">
            <label>Nom du service :</label>
            <input type="text" name="addname" placeholder="Nom du service">
            <label>Prix souhaitez /h :</label>
            <input type="number" name="addtarif" placeholder="Prix Souhaitez">
            <label> Genre de service :</label>
            <?php
            $nom_type = $bdd->query('SELECT * FROM `type_service` GROUP BY nom_type');
            ?>
            <select name="addtypeservices">
                <option value="">Selectionner une valeur</option>
                <?php while ($nom_types = $nom_type->fetch()) { ?>
                    <option value="<?php echo $nom_types['nom_type']; ?>"><?php echo $nom_types['nom_type']; ?></option>
                <?php } ?>
            </select>
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
            <?php
            $reponse = $bdd->query("SELECT * FROM abonnement_test where id_membre='{$_SESSION['id']}' ");
            $donnees = $reponse->fetch();

            if (isset($donnees['type_abonnement'])) {
                ?>
                <input class="submitservice" type="submit" name="abo_valider" value="Envoyer"/>
                <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                <p> * Votre demande est directement enregistré </p>
            <?php } else { ?>
                <input class="submitservice" type="submit" name="payer" value="Payer"/>
                <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                <p> * Vous allez être redirigé vers la page de paiement </p>
            <?php } ?>
        </form>
    </div>

    <!--Pop up nb_heure inssufisante -->
    <?php if (isset($_GET['nb_heure']) && $_GET['nb_heure'] == 'neg') { ?>
        <div class="blocpopup_errreur">
            <h3>Vous ne disposez pas d'un nombre d'heure suffisant !</h3>
            <a href="../stripe/pricing.php" name="new_abonnement" class="button_erreur_heure submitservice">Passer a
                l'abonnement supérieur</a>
            <a href="#" name="payer_comptant" class="button_erreur_heure submitservice">Payer le service au prix
                indiqué</a>
            <input class="submitservice" type="submit" name="fermer_heure" value="Annuler"/>
        </div>
    <?php } ?>
</div>

</main>
<?php include('../include/footer.php'); ?>
</body>
</html>