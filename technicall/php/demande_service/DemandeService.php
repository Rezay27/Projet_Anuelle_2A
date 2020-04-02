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
    $demande = $bdd->query("Select * FROM services inner join type_service on services.id_type_service = type_service.id_type where service_valide = 1");
    ?>
    <table id="tableDS">
        <thead>
        <tr>
            <th>Nom du service</th>
            <th>Prix</th>
            <th>Type de Service</th>
        </tr>
        </thead>
        <tbody>
        <?php while (($demandes = $demande->fetch())) { ?>
            <tr>
                <td><p id="name" class="listds"><?php echo $demandes['nom_service']; ?> </p></td>
                <td class="price_td"><p id="price" class="listds"><?php echo $demandes['tarif']; ?> €</p></td>
                <td><p id="type" class="listds"><?php echo $demandes['nom_type']; ?> </p></td>
            </tr>
            <div id="popup" class="blocpopup">
                <form id="demandeservice" action="verifdemandeservice.php" name="demandeservice" method="post"
                      enctype="multipart/form-data">
                    <h3 class="nameservice"></h3>
                    <p class="priceservice"></p>
                    <p class="typeservice"></p>
                    <input type="text" hidden id="nameservices" name="nameservices">
                    <input type="text" hidden id="tarifservices" name="tarifservices">
                    <input type="text" hidden id="typeservices" name="typeservices">
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

                    if(isset($donnees['type_abonnement'])){?>
                        <input class="submitservice" type="submit" name="valider" value="Envoyer"/>
                        <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                        <p> * Votre demande est directement enregistré </p>
                        <?php } else {?>
                        <input class="submitservice" type="submit" name="payer" value="Payer"/>
                        <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                        <p> * Vous allez être redirigé vers la page de paiement </p>
                   <?php }?>
                </form>
            </div>
        <?php } ?>
        </tbody>
    </table>
    <input type="submit" class="submit" value="Demande personnalisée" name="addservice" id="button_add"/>
    <div class="blocpopup" id="popupadd">
        <h3>Demande personnalisée</h3>
        <form id="add_service" action="verifaddservice.php" name="addservice" method="post" enctype="multipart/form-data">
            <label>Nom du service :</label>
            <input type="text" name="addname" placeholder="Nom du service">
            <label>Prix souhaitez :</label>
            <input type="number" name="addtarif" placeholder="Prix Souhaitez">
            <label> Genre de service :</label>
            <?php
            $nom_type = $bdd->query('SELECT * FROM `type_service` GROUP BY nom_type');
            ?>
            <select name="addtypeservices">
                <option value="">Selectionner une valeur </option>
                <?php while($nom_types = $nom_type -> fetch()){?>
                <option value="<?php echo $nom_types['nom_type'];?>"><?php echo $nom_types['nom_type'];?></option>
                <?php } ?>
            </select>
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

            if(isset($donnees['type_abonnement'])){?>
                <input class="submitservice" type="submit" name="abo_valider" value="Envoyer"/>
                <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                <p> * Votre demande est directement enregistré </p>
                <?php } else {?>
                <input class="submitservice" type="submit" name="payer" value="Payer"/>
                <input class="submitservice" type="submit" name="fermer" value="Annuler"/>
                <p> * Vous allez être redirigé vers la page de paiement </p>
            <?php }?>
        </form>
    </div>
</div>

</main>
<?php include('../include/footer.php'); ?>
</body>
</html>