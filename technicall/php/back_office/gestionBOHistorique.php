<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/css.css" rel="stylesheet">
    <title>Gestion Historique BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>

    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Historiques </h3>
                <?php
                $demande = $bdd ->query ("SELECT * FROM `demandes` inner join demande_service on demandes.id_demandes = demande_service.id_demande inner join services on demande_service.id_service = services.id_services where demandes.valide = 1");

                ?>
                <table>
                    <tr>
                        <th> Demande n° </th>
                        <th> Nom Intervention </th>
                        <th > Lieu </th>
                        <th> Date </th>
                        <th> Heure </th>
                        <th > Prix </th>
                        <th> Nombre d'heure </th>
                        <th > Intervenant </th>
                        <th> Facture n° </th>
                        <th> Devis n° </th>
                    </tr>
                    <?php while($demandes = $demande->fetch()){ ?>
                    <tr>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['nom_demande']; ?>">  </td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                        <td> <input class="modifie" type="date" value="<?php echo $demandes['date']?>"></td>
                        <td> <input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['prix_demande']?>"></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['nb_heure']?>"></td>
                        <td> <?php if(isset($demandes['id_intervenant_demande'])) { ?><input class="modifie" type="text" value="<?php echo $demandes['id_intervenant_demande']; ?>"><?php }else{?> AJOUTER <?php }?></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['ref_facture']?>"></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['ref_devis']?>"></td>
                    </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </section>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>

